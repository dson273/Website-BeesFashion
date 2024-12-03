@extends('user.layouts.master')

@section('content')
<!-- Container content -->
<main>
    <section class="section-b-space py-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="order-box-1"><img src="../assets/images/gif/failed.png" width="100px" alt="">
                        <h4>Order Failed</h4>
                        <p>Payment Is Failed Processsed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space">
        <div class="custom-container container order-success">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="order-items sticky">
                        <h4>Order Information </h4>
                        <p>Order invoice has been send to your registered email account. double check your order
                            details
                        </p>
                        <div class="order-table">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product </th>
                                            <th>Price </th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Applied voucher</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($get_order))
                                        @foreach ($get_order->order_details as $order_detail)
                                        <tr>
                                            <td>
                                                <div class="cart-box">
                                                    <a href="{{route('product.detail',$order_detail->product_variant->product->id)}}">
                                                        @if ($order_detail->product_variant->image)
                                                        <img src="{{asset('uploads/products/images/'.$order_detail->product_variant->image)}}" alt="" width="100px" height="110px">
                                                        @else
                                                        <img src="https://via.placeholder.com/300x200" alt="">
                                                        @endif
                                                    </a>
                                                    <div class="d-flex flex-column">
                                                        <a href="{{route('product.detail',$order_detail->product_variant->product->id)}}">
                                                            <h5>{{Str::limit($order_detail->product_variant->product->name,15,'...')}}</h5>
                                                        </a>
                                                        <span>{{$order_detail->value_variants}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span>{{number_format($order_detail->original_price,0,'.',',')}} đ</span>
                                            </td>
                                            <td>{{$order_detail->quantity}}</td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-end">
                                                    <span>{{number_format($order_detail->original_price*$order_detail->quantity,0,'.',',')}} đ</span>
                                                    @if ($order_detail->amount_reduced!=0)
                                                    <span class="text-danger">-{{number_format($order_detail->amount_reduced,0,'.',',')}} đ</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success">{{number_format(($order_detail->original_price*$order_detail->quantity)-$order_detail->amount_reduced,0,'.',',')}} đ</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">
                                                <span class="text-danger">Không có dữ liệu sản phẩm</span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="total fw-bold">
                                                Total :
                                            </td>
                                            <td class="total fw-bold">
                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="fs-5 text-dark {{$get_order->voucher!=0?"text-decoration-line-through":"fw-bold"}}">{{number_format($get_order->total_cost+$get_order->voucher,0,'.',',')}} đ</span>
                                                    @if ($get_order->voucher!=0)
                                                    <span class="fs-5 text-success fw-bold">{{number_format($get_order->total_cost,0,'.',',')}} đ</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="summery-box">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Order Details </h4>
                        </div>
                        <div class="summery-content">
                            <ul>
                                <li>
                                    <p class="fw-semibold">Product total ({{count($get_order->order_details)}})</p>
                                    <h6>{{number_format($get_order->total_cost+$get_order->voucher,0,'.',',')}} đ</h6>
                                </li>
                                <li>
                                    <p>Shipping to </p><span>vietnam</span>
                                </li>
                                <li>
                                    <p>Payment method </p><span>{{$get_order->payment_method}}</span>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <p>Shipping Costs</p><span>{{number_format($get_order->shipping_price,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Tax <span>(0,5% of total order value)</span> </p><span>{{number_format($get_order->tax,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Shipping voucher </p><span class="text-danger">-{{number_format($get_order->shipping_voucher,0,'.',',')}} đ</span>
                                </li>
                                <li>
                                    <p>Voucher </p><span class="text-danger">-{{number_format($get_order->voucher,0,'.',',')}} đ</span>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Total (VND)</h6>
                                <h5>{{number_format($get_order->total_payment,0,'.',',')}} đ</h5>
                            </div>
                            <div class="note-box">
                                <p>I'm hoping the store can work with me to get it delivered as soon as possible
                                    because
                                    I really need it to gift to my friend for her party next week.Many thanks for
                                    it.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="summery-footer">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Shipping Address</h4>
                        </div>
                        <ul>
                            <li>
                                <h6>{{$get_order->full_name}}</h6>
                                <h6>{{$get_order->phone_number}}</h6>
                                <h6>{{$get_order->address}}</h6>
                            </li>
                            <li>
                                <h6>Expected Date Of Delivery: <span>Track Order</span></h6>
                            </li>
                            <li>
                                <h5>{{$get_order->created_at->format('M d, Y')}}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End container content -->
@endsection