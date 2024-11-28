<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Chart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
    private $chart;

    public function __construct(Chart $chart)
    {
        $this->chart = $chart;
    }

    //Thống kê doanh thu theo sản phẩm
    public function revenueByProduct(Request $request)
    {
        $type = $request->input('type', 'day');
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        $statistics = Chart::getTopSellingProducts(10, $date, $type);

        if ($request->ajax()) {
            return response()->json($statistics);
        }
        // dd($statistics);

        return view('admin.statistics.revenue_by_product', compact('statistics', 'type', 'date'));
    }

    //Thống kê sản phẩm trong giỏ hàng
    public function statisticCart()
    {
        $products = Chart::getCartStatistics();
        return view('admin.statistics.statistics_cart', compact('products'));
    }

    //Thống kê sản phẩm có lượt xem
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

    // Thống kê doanh thu theo thương hiệu
    public function revenueByBrand()
    {
        $statisticBrand = $this->chart->getBrandStatistics();
        // dd($statisticBrand);
        return view('admin.statistics.revenue_by_brands', compact('statisticBrand'));
    }

    // Thống kê doanh thu theo khách hàng
    public function revenueByCustomer(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.statistics.revenue_by_customer');
        }

        try {
            $type = $request->get('time_type', 'monthly');
            $date = match ($type) {
                'daily' => $request->get('daily_date', now()->format('Y-m-d')),
                'monthly' => $request->get('monthly_date', now()->format('Y-m')),
                'yearly' => $request->get('yearly_date', now()->year),
                default => now()->format('Y-m')
            };

            $revenueStats = $this->chart->getRevenueStatistics($date, $type);
            $spendingTiers = $this->chart->getCustomerSpendingTiers($date, $type);
            $customerDetails = $this->chart->getCustomerSpendingDetails($date, $type);

            return response()->json([
                'revenueStats' => $revenueStats,
                'customerDetails' => $customerDetails,
                'spendingTiers' => $spendingTiers,
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi xử lý dữ liệu'
            ], 500);
        }
    }
}
