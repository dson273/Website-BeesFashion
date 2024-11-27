<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chart extends Model
{
    use HasFactory;

    //Thống kê doanh thu, chi phí, lợi nhuận, số lượt order cửa hàng theo thời gian
    public static function getRevenueStatisticsByIntervals($intervals)
    {
        $caseStatements = [];
        $labels = [];

        foreach ($intervals as $index => $range) {
            $label = $range[0]->format('d/m');
            if ($range[0]->format('Y-m-d') !== $range[1]->format('Y-m-d')) {
                $label = $range[0]->format('d/m') . '-' . $range[1]->format('d/m');
            }
            // Xử lý trường hợp tháng
            if (
                $range[0]->format('Y-m') === $range[1]->format('Y-m') &&
                $range[0]->format('d') === '01' &&
                $range[1]->format('d') === $range[1]->copy()->endOfMonth()->format('d')
            ) {
                $label = $range[0]->format('m/Y');
            }

            $labels[] = $label;
            $caseStatements[] = "
        WHEN orders.created_at BETWEEN '{$range[0]->format('Y-m-d')} 00:00:00'
        AND '{$range[1]->format('Y-m-d')} 23:59:59'
        THEN '{$label}'";
        }

        $importIntervals = DB::table('import_histories')
            ->selectRaw('
        product_variant_id,
        import_price,
        created_at as start_time,
        COALESCE(LEAD(created_at) OVER (PARTITION BY product_variant_id ORDER BY created_at), NOW()) as end_time');

        $query = Order::selectRaw("
        CASE " . implode("\n", $caseStatements) . "
        END as label,
        COALESCE(SUM((order_details.original_price* order_details.quantity) - order_details.amount_reduced ), 0) as total_revenue,
        COALESCE(SUM(order_details.quantity * import_intervals.import_price), 0) as total_cost,
        COUNT(DISTINCT orders.id) as total_orders")
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->joinSub($importIntervals, 'import_intervals', function ($join) {
                $join->on('order_details.product_variant_id', '=', 'import_intervals.product_variant_id')
                    ->whereRaw('orders.created_at BETWEEN import_intervals.start_time AND import_intervals.end_time');
            })
            ->where('status_orders.status_id', 4)
            ->whereBetween('orders.created_at', [$intervals[0][0]->startOfDay(), end($intervals)[1]->endOfDay()])
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->label,
                    'total_revenue' => $item->total_revenue, //doanh thu
                    'total_cost' => $item->total_cost, //chi phí nhập
                    'profit' => $item->total_revenue - $item->total_cost, //lợi nhuận
                    'total_orders' => $item->total_orders //số lượng order
                ];
            });

        return $query->toArray();
    }

    public static function getTopSellingProducts($limit = 10, $date, $type = 'day')
    {
        $importIntervals = DB::table('import_histories')
            ->selectRaw('
            product_variant_id,
            import_price,
            created_at as start_time,
            COALESCE(LEAD(created_at) OVER (PARTITION BY product_variant_id ORDER BY created_at), NOW()) as end_time
        ');

        $query = Product::select([
            'products.id',
            'products.name',
            DB::raw('SUM(order_details.quantity) as total_quantity'),
            DB::raw('COALESCE(SUM((order_details.original_price * order_details.quantity)- order_details.amount_reduced) , 0) as total_revenue'),
            DB::raw('SUM(order_details.quantity * import_intervals.import_price) as total_cost')
        ])
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->joinSub($importIntervals, 'import_intervals', function ($join) {
                $join->on('order_details.product_variant_id', '=', 'import_intervals.product_variant_id')
                    ->whereRaw('orders.created_at BETWEEN import_intervals.start_time AND import_intervals.end_time');
            })
            ->where('status_orders.status_id', 4);

        switch ($type) {
            case 'day':
                $query->whereDate('orders.created_at', Carbon::parse($date)->format('Y-m-d'));
                break;
            case 'month':
                $date = Carbon::parse($date);
                $query->whereYear('orders.created_at', $date->year)
                    ->whereMonth('orders.created_at', $date->month);
                break;
            case 'year':
                $query->whereYear('orders.created_at', $date);
                break;
        }

        $query->groupBy('products.id', 'products.name');
        $productsData = $query->get();
        $sortedProducts = $productsData->sortByDesc('total_revenue');

        $topProducts = $sortedProducts->take($limit)->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'total_quantity' => $item->total_quantity,
                'total_revenue' => $item->total_revenue,
                'total_cost' => $item->total_cost,
                'profit' => $item->total_revenue - $item->total_cost
            ];
        })->values();

        $otherProducts = $sortedProducts->slice($limit);
        $others = [
            'id' => null,
            'name' => 'Other products',
            'total_quantity' => $otherProducts->sum('total_quantity'),
            'total_revenue' => $otherProducts->sum('total_revenue'),
            'total_cost' => $otherProducts->sum('total_cost'),
            'profit' => $otherProducts->sum('total_revenue') - $otherProducts->sum('total_cost')
        ];

        $result = $topProducts->toArray();
        if ($others['total_quantity'] > 0) {
            $result[] = $others;
        }

        $overallTotals = [
            'total_revenue' => $productsData->sum('total_revenue'),
            'total_cost' => $productsData->sum('total_cost'),
            'total_profit' => $productsData->sum('total_revenue') - $productsData->sum('total_cost'),
            'total_quantity' => $productsData->sum('total_quantity')
        ];

        return [
            'data' => $result,
            'totals' => $overallTotals,
            'period' => [
                'type' => $type,
                'date' => $date
            ]
        ];
    }
}
