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
        $allCount = Order::all();

        $pendingOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 2);
        })
            ->get();
        $pendingCount = $pendingOrders->count();

        $processingOrders = Order::with('status_orders')
            ->whereHas('status_orders', function ($query) {
                $query->where('status_id', 1);
            })
            ->get();
        $processingCount = $processingOrders->count();

        $shippingOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 3);
        })->get();
        $shippingCount = $shippingOrders->count();

        $completedOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 4);
        })->get();
        $completedCount = $completedOrders->count();

        $cancelledOrders = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 5);
        })->get();
        $cancelledCount = $cancelledOrders->count();


        $fail_delivery = Order::whereHas('status_orders', function ($query) {
            $query->where('status_id', 6);
        })->get();
        $fail_deliveryCount = $fail_delivery->count();

        return view('admin.orders.index', compact(
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
            // Cập nhật trạng thái của đơn hàng
            foreach ($order->status_orders as $statusOrder) {
                $statusOrder->update(['status_id' => 3]);
            }
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
            // Cập nhật trạng thái của đơn hàng
            foreach ($order->status_orders as $statusOrder) {
                $statusOrder->update(['status_id' => 4]);
            }      
        }
        
        return redirect()->route('admin.orders.index')->with('statusSuccess', 'Đơn hàng giao thành công');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getInfo = Order::with('order_details.product_variant')->findOrFail($id);
        return view('admin.orders.info', compact('getInfo'));
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
