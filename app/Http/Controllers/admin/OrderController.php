<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Picqer\Barcode\BarcodeGeneratorHTML;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //tất cả đơn hàng
        $allOrders = Order::with(['status_orders' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(1);  // Lấy trạng thái mới nhất
        }])->orderBy('created_at', 'desc')->get();
        $allCount = $allOrders->count();
        //đơn hàng chờ xác nhận
        $pendingOrders = Order::whereHas('status_orders', function ($query) {
            // Chỉ lấy các đơn hàng có trạng thái "Pending" (status_id = 2)
            $query->where('status_id', 2);
        })->whereDoesntHave('status_orders', function ($query) {
            // Loại bỏ các đơn hàng đã có trạng thái "Cancelled" (status_id = 5) hoặc "Shipping" (status_id = 3)
            $query->whereIn('status_id', [5, 3]);
        })->orderBy('created_at', 'desc')->get();
        $pendingCount = $pendingOrders->count();

        //đơn hàng chờ xử lý
        $processingOrders = Order::with('status_orders')
            ->whereHas('status_orders', function ($query) {
                $query->where('status_id', 1); // Lọc đơn hàng có trạng thái "Processing"
            })
            ->whereDoesntHave('status_orders', function ($query) {
                $query->where('status_id', [5, 2]); 
            })
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo đơn hàng
            ->get();

        $processingCount = $processingOrders->count();
        //Đơn hàng đã giao 
        $shippingOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 3);  // Trạng thái 'Shipping'
        })
            ->whereDoesntHave('status_orders', function ($query) {
                $query->whereIn('status_id', [4, 6, 5]); 
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $shippingCount = $shippingOrders->count();

        //Đơn hàng đã hoàn thành
        $completedOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 4);
        })->orderBy('created_at', 'desc')
            ->get();
        $completedCount = $completedOrders->count();


        //Đơn hàng đã hủy
        $cancelledOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 5);
        })->orderBy('created_at', 'desc')
            ->get();
        $cancelledCount = $cancelledOrders->count();


        $fail_delivery = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 6);
        })->orderBy('created_at', 'desc')
            ->get();
        $fail_deliveryCount = $fail_delivery->count();

        return view('admin.orders.index', compact(
            'allOrders',
            'allCount',
            'pendingOrders',
            'pendingCount',
            'processingCount',
            'processingOrders',
            'shippingOrders',
            'shippingCount',
            'completedCount',
            'completedOrders',
            'cancelledOrders',
            'cancelledCount',
            'fail_delivery',
            'fail_deliveryCount'
        ));
    }

    public function printOrder($id)
    {
        // Tìm đơn hàng và load các quan hệ liên quan
        $order = Order::with('order_details.product_variant')->findOrFail($id);


        if ($order) {
            // Khởi tạo generator và tạo mã vạch cho từng SKU
            $generator = new BarcodeGeneratorHTML();
            $barcodes = [];

            foreach ($order->order_details as $detail) {
                $SKU = $detail->product_variant->SKU;
                $barcodes[$SKU] = $generator->getBarcode($SKU, $generator::TYPE_CODE_128);
            }

            // Tạo file PDF từ view và truyền dữ liệu
            $pdf = PDF::loadView('admin.orders.print', compact('order', 'barcodes'));

            // Xuất file PDF dưới dạng stream

            return $pdf->stream('order_' . $id . '.pdf');
        }

        // return $pdf->stream('order_' . $id . '.pdf');
    }

    public function onActive(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
        if ($order) {
            // Kiểm tra xem trạng thái Shipping (3) đã có chưa
            $shippingStatus = $order->status_orders()->where('status_id', 3)->first();

            // Nếu trạng thái Shipping (3) tồn tại, tạo trạng thái Completed (4)
            if ($shippingStatus) {
                // Tạo bản ghi trạng thái Completed (4)
                $order->status_orders()->create(['status_id' => 4]);

                return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được giao thành công');
            }

            return redirect()->route('admin.orders.index')->with('statusError', 'Không tìm thấy trạng thái vận chuyển cho đơn hàng này.');
        }
        return redirect()->route('admin.orders.index')->with('statusError', 'Đơn hàng đang xảy ra lỗi');
    }

    // TAB Cần gửi
    public function onSuccess(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
        if ($order) {

        $existingCancelledStatus = $order->status_orders()->where('status_id', 5)->first();

            // Thêm bản ghi trạng thái "Shipping" (status_id = 3)
            if (!$existingCancelledStatus) {
                $order->status_orders()->create(['status_id' => 3]);
            }

            return redirect()->route('admin.orders.index')->with('statusError', 'Đơn hàng đã bị hủy');
        }

        return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được gửi đi');
    }
    public function cancelOrder(Request $request, string $id)
    {
        $order = Order::with('order_details.product_variant')->findOrFail($id);
        if ($order) {
            // Kiểm tra xem đơn hàng đã có trạng thái Cancelled (status_id = 5) chưa
            $existingCancelledStatus = $order->status_orders()->where('status_id', 5)->first();

            // Nếu chưa có trạng thái Cancelled, tạo bản ghi mới
            if (!$existingCancelledStatus) {
                $order->status_orders()->create(['status_id' => 5]);
            }

            // Đảm bảo đơn hàng không còn trong tab Pending (tự động loại bỏ trạng thái Pending)
            // Bạn có thể thêm logic tại đây nếu cần (ví dụ: thông báo cho admin)

            return redirect()->route('admin.orders.index')->with('statusError', 'Đơn hàng đã được hủy bởi khách hàng');
        }

        return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng đã được hủy');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getInfo = Order::with('order_details.product_variant')
            ->findOrFail($id);

        // Lấy bản ghi trạng thái thay đổi gần đây nhất của đơn hàng
        $latestStatus = $getInfo->status_orders()->latest()->first();
        // Lấy tất cả trạng thái của đơn hàng và sắp xếp theo thời gian tạo
        $statusOrders = $getInfo->status_orders()->orderBy('created_at', 'asc')->get();


        // Trả về view và truyền dữ liệu
        return view('admin.orders.info', compact('getInfo', 'latestStatus', 'statusOrders'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
