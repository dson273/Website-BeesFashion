<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
    public function getStatistics(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        return response()->json([
            'topViewedProducts' => $this->getTopViewedProducts(10),
            'totalViews' => $this->getTotalViews($startDate, $endDate),
            'cartItems' => $this->getCartItems(),
            'totalRevenue' => $this->getTotalRevenue($startDate, $endDate),
            'totalOrders' => $this->getTotalOrders($startDate, $endDate),
            'revenueByTime' => $this->getRevenueByTime($startDate, $endDate),
            'revenueByProduct' => $this->getRevenueByProduct($startDate, $endDate),
            'revenueByBrand' => $this->getRevenueByBrand($startDate, $endDate),
            'topCustomers' => $this->getTopCustomers($startDate, $endDate),
        ]);
    }

    // Thống kê sản phẩm theo lượt xem
    private function getTopViewedProducts($limit = 10)
    {
        return Product::select('products.name', 'products.view')
            ->where('products.is_active', 1)
            ->orderBy('products.view', 'desc')
            ->limit($limit)
            ->get();
    }

    // Thống kê tổng lượt xem
    private function getTotalViews($startDate, $endDate)
    {
        return Product::whereBetween('updated_at', [$startDate, $endDate])->sum('view');
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

    // Thống kê doanh thu theo thời gian
    private function getRevenueByTime($startDate, $endDate)
    {
        return Order::select(
            DB::raw('DATE(orders.created_at) as date'),
            DB::raw('SUM(orders.total_payment) as revenue')
        )
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3) // Hoàn thành
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    // Tổng doanh thu
    private function getTotalRevenue($startDate, $endDate)
    {
        return Order::join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3) // Hoàn thành
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->sum('orders.total_payment');
    }

    // Tổng đơn hàng
    private function getTotalOrders($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    // Thống kê doanh thu theo sản phẩm
    private function getRevenueByProduct($startDate, $endDate)
    {
        $topProducts = Order::select(
            'products.name',
            DB::raw('SUM(order_details.quantity * (order_details.original_price - COALESCE(order_details.amount_reduced, 0))) as revenue')
        )
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3) // Hoàn thành
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();

        // Tính tổng doanh thu các sản phẩm còn lại
        $otherRevenue = Order::select(
            DB::raw('SUM(order_details.quantity * (order_details.original_price - COALESCE(order_details.amount_reduced, 0))) as revenue')
        )
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('status_orders', 'orders.id', '=', 'status_orders.order_id')
            ->where('status_orders.status_id', 3)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotIn('products.id', $topProducts->pluck('id'))
            ->value('revenue');

        if ($otherRevenue > 0) {
            $topProducts->push([
                'name' => 'Các sản phẩm khác',
                'revenue' => $otherRevenue
            ]);
        }

        return $topProducts;
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
