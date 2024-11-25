<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    //View dashboard
    public function index()
    {
        $totalProducts = Product::count();
        $totalView = Product::where('is_active', '1')->sum('view');
        $totalOrders = Order::join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3)
            ->count();
        // $totalRevenue =  Order::join('status_orders', 'orders.id', '=', 'status_orders.order_id')
        //     ->where('status_orders.status_id', 3)
        //     ->sum('orders.total_payment');
        $totalUsers = User::where('role', 'member')->count();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalView', 'totalUsers'));
    }

    //Liệt kê sản phẩm có lượt xem
    public function product_views()
    {
        $listProductViews = Product::where('is_active', 1)
            ->where('view', '>', 0)
            ->select('products.*')
            ->selectRaw('(SELECT file_name FROM product_files
                  WHERE is_default = 1 AND product_id = products.id LIMIT 1) as mainImage')
            ->orderBy('view', 'desc')
            ->get();

        return view('admin.statistics.product_views', compact('listProductViews'));
    }

    //Thống kê doanh thu shop theo thời gian
    public function getRevenue(Request $request)
    {
        $timeFrame = $request->get('time_frame', 'this_month');
        [$startDate, $endDate] = $this->getTimeFrameDates($timeFrame);

        $intervals = $this->getIntervalsByTimeFrame($timeFrame, $startDate, $endDate);
        $labels = array_map(function ($interval) {
            return $interval['label'];
        }, $intervals);

        $revenue = $this->getRevenueData($intervals, $labels);

        return response()->json([
            'labels' => $labels,
            'revenue' => array_values($revenue)
        ]);
    }

    private function getIntervalsByTimeFrame(string $timeFrame, Carbon $startDate, Carbon $endDate): array
    {
        if (in_array($timeFrame, ['this_year', 'last_year'])) {
            return $this->getMonthlyIntervals($startDate, $endDate);
        }

        if (in_array($timeFrame, ['this_quarter'])) {
            return $this->getQuarterlyMonthIntervals($startDate, $endDate);
        }

        $daysDifference = $startDate->diffInDays($endDate);
        if ($daysDifference <= 8) {
            return $this->getDailyIntervals($startDate, $endDate);
        }

        return $this->getGroupedIntervals($startDate, $endDate, 7);
    }

    private function getRevenueData(array $intervals, array $labels): array
    {
        $rawRevenue = Order::getRevenueByIntervals(array_map(function ($interval) {
            return [$interval['start'], $interval['end']];
        }, $intervals));

        $revenueByLabels = array_fill_keys($labels, 0);

        foreach ($rawRevenue as $item) {
            if (isset($revenueByLabels[$item['label']])) {
                $revenueByLabels[$item['label']] = $item['total_revenue'];
            }
        }

        return $revenueByLabels;
    }

    private function getTimeFrameDates(string $timeFrame): array
    {
        $today = Carbon::today();
        $dates = match ($timeFrame) {
            'today' => [$today, $today],
            'this_week' => [
                $today->copy()->startOfWeek(Carbon::SUNDAY),
                $today->copy()->endOfWeek(Carbon::SATURDAY)
            ],
            'this_month' => [
                $today->copy()->startOfMonth(),
                $today->copy()->endOfMonth()
            ],
            'this_quarter' => [
                $today->copy()->firstOfQuarter(),
                $today->copy()->lastOfQuarter()
            ],
            'this_year' => [
                $today->copy()->startOfYear(),
                $today->copy()->endOfYear()
            ],
            'last_week' => [
                $today->copy()->subWeek()->startOfWeek(Carbon::SUNDAY),
                $today->copy()->subWeek()->endOfWeek(Carbon::SATURDAY)
            ],
            'last_month' => [
                $today->copy()->subMonth()->startOfMonth(),
                $today->copy()->subMonth()->endOfMonth()
            ],
            'last_year' => [
                $today->copy()->subYear()->startOfYear(),
                $today->copy()->subYear()->endOfYear()
            ],
            'custom' => [
                Carbon::parse(request('start_date'))->startOfDay(),
                Carbon::parse(request('end_date'))->endOfDay()
            ],
            default => [$today, $today]
        };

        return $dates;
    }

    private function getDailyIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfDay(),
                'end' => $current->copy()->endOfDay(),
                'label' => $current->format('d/m')
            ];
            $current->addDay();
            if ($current->gt($endDate)) {
                break;
            }
        }

        return $intervals;
    }

    private function getMonthlyIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy()->startOfMonth();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfMonth(),
                'end' => $current->copy()->endOfMonth(),
                'label' =>$current->format('m/Y')
            ];
            $current->addMonth();
        }

        return $intervals;
    }

    private function getQuarterlyMonthIntervals(Carbon $startDate, Carbon $endDate): array
    {
        $intervals = [];
        $current = $startDate->copy()->startOfMonth();

        while ($current->lte($endDate)) {
            $intervals[] = [
                'start' => $current->copy()->startOfMonth(),
                'end' => $current->copy()->endOfMonth(),
                'label' =>$current->format('m/Y')
            ];
            $current->addMonth();
        }

        return $intervals;
    }

    private function getGroupedIntervals(Carbon $startDate, Carbon $endDate, int $groupCount): array
    {
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $daysPerGroup = ceil($totalDays / $groupCount);

        $intervals = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $groupStart = $currentDate->copy();
            $groupEnd = $currentDate->copy()->addDays($daysPerGroup - 1);

            if ($groupEnd->gt($endDate)) {
                $groupEnd = $endDate->copy();
            }

            $intervals[] = [
                'start' => $groupStart->startOfDay(),
                'end' => $groupEnd->endOfDay(),
                'label' => $groupStart->format('d/m') . '-' . $groupEnd->format('d/m')
            ];

            $currentDate = $groupEnd->copy()->addDay();

            if (count($intervals) >= $groupCount || $currentDate->gt($endDate)) {
                break;
            }
        }

        return $intervals;
    }
}
