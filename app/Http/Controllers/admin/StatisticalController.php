<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Chart;
use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
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

    private function formatPeriodText($type, $date)
    {
        $carbon = Carbon::parse($date);
        return match($type) {
            'day' => $carbon->format('d/m/Y'),
            'month' => $carbon->format('m/Y'),
            'year' => $carbon->format('Y'),
            default => $carbon->format('d/m/Y'),
        };
    }


    // Thống kê các sản phẩm trong giỏ hàng
    private function getCartItems()
    {
        return Cart::select(
            'products.name',
            'product_variants.name as variant_name',
            DB::raw('SUM(carts.quantity) as total_quantity')
        )
            ->join('product_variants', 'carts.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name', 'product_variants.name')
            ->get();
    }

    // Thống kê doanh thu theo thương hiệu
    private function getRevenueByBrand($startDate, $endDate)
    {
        return Order::select(
            'brands.name',
            DB::raw('SUM(order_details.quantity * (order_details.original_price - COALESCE(order_details.amount_reduced, 0))) as revenue')
        )
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3) // Hoàn thành
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('brands.id', 'brands.name')
            ->orderBy('revenue', 'desc')
            ->get();
    }

    // Thống kê doanh thu theo khách hàng
    private function getTopCustomers($startDate, $endDate)
    {
        return User::select(
            'users.full_name',
            'users.email',
            DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
            DB::raw('SUM(orders.total_payment) as total_spent')
        )
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3) // Hoàn thành
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.full_name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();
    }
}
