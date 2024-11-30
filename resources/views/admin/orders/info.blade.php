@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/order/index.css') }}">
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="page-wrapper cardhead">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('admin.orders.index') }}"><i class="fa fa-angle-left"></i> Quản lý đơn hàng</a>
                        <div class="flex justify-between">
                            <div class="index__card-title--rzIx0 font-semibold">
                                @foreach ($getInfo->order_details as $detail)
                                    <div class="flex items-center"><span
                                            class="mr-2">{{ $detail->product_variant->SKU }}</span></div>
                                @endforeach

                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($getInfo->status_orders as $item)
                                    <div class="col-md-12">
                                        <div class="flex justify-between">
                                            <div class="index__card-title--rzIx0 font-semibold">
                                                <div class="flex items-center"><span class="mr-2">
                                                        @if ($item->status_id == 1)
                                                            Chờ xử lý
                                                        @elseif ($item->status_id == 2)
                                                            Cần gửi
                                                        @elseif ($item->status_id == 3)
                                                            Đơn hàng đã được vận chuyển
                                                        @elseif ($item->status_id == 4)
                                                            Đã hoàn thành
                                                        @elseif ($item->status_id == 6)
                                                        Đơn hàng giao không thành công
                                                        @else
                                                            Đã hủy
                                                        @endif
                                                        <br>
                                                    </span></div>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="completed-box">
                                            <div class="KeyValuePair">
                                                <div class="text-header">
                                                    <div class="truncate">Vị trí</div>
                                                </div>
                                                <div class="text-footer">Việt Nam</div>
                                            </div>
                                            <div class="KeyValuePair">
                                                <div class="text-header">
                                                    <div class="truncate">Thời gian tạo</div>
                                                </div>
                                                <div class="text-footer">{{ $item->created_at->format('d/m/Y H:i:s') }}
                                                </div>
                                            </div>
                                            <div class="KeyValuePair">
                                                <div class="text-header">
                                                    <div class="truncate">Vị trí</div>
                                                </div>
                                                <div class="text-footer">Việt Nam</div>
                                            </div>
                                            <div class="KeyValuePair">
                                                <div class="text-header">
                                                    <div class="truncate">Vị trí</div>
                                                </div>
                                                <div class="text-footer">Việt Nam</div>
                                            </div>


                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex justify-between">
                                        <div class="index__card-title--rzIx0 font-semibold">
                                            <div class="flex items-center"><span class="mr-2">Đơn hàng hiện tại</span>
                                            </div>
                                        </div>
                                        <div></div>
                                    </div>
                                    @foreach ($getInfo->order_details as $detail)
                                        <div class="card-header">
                                            <p class="card-title">ID SKU : {{ $detail->product_variant->SKU }}</p>
                                            <div class="product-info">
                                                <div class="info-image">

                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>

                                                </div>
                                                <div class="info-des">
                                                    <div class="des-header">{{ $detail->product_variant->product->name }}
                                                    </div>
                                                    <div class="des-footer">{{ $detail->value_variants }}</div>
                                                </div>
                                                <div class="info-price">
                                                    <div class="price">
                                                        {{ number_format($detail->original_price, 0, ',', '.') }}₫ x
                                                        {{ $detail->quantity }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex justify-between">
                                        <div class="index__card-title--rzIx0 font-semibold">
                                            <div class="flex items-center"><span class="mr-2">Lịch sử đơn hàng</span>
                                            </div>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="list-history">
                                    @foreach ($getInfo->status_orders as $item)
                                        @if ($item->status_id == 5)
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom5"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Yêu cầu hủy được gửi bởi khách hàng</div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng bị hủy theo yêu cầu của khách hàng hoặc do quy định
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom1 active"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Đơn hàng do khách hàng tạo</div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng đã được tiếp nhận và xác nhận từ hệ thống</div>
                                                    </div>
                                                </div>
                                            </div>
                                           @elseif($item->status_id == 6) 
                                           <div class="listitem">
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                    style="border-left-style: dashed;"></div>
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="theme-arco-timeline-item-dot-custom5"
                                                        data-status="{{ $item->status_id }}">
                                                        <div
                                                            class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="sc-jeGSBP">Đơn hàng giao không thành công</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        Đơn hàng giao đến khách hàng không thành công
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="listitem">
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                    style="border-left-style: dashed;"></div>
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="theme-arco-timeline-item-dot-custom3"
                                                        data-status="{{ $item->status_id }}">
                                                        <div
                                                            class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="sc-jeGSBP">Đơn hàng đang được vận chuyển
                                                    </div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        Đơn hàng đã được giao cho đơn vị vận chuyển và đang trên đường giao đến bạn</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="listitem">
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                    style="border-left-style: dashed;"></div>
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="theme-arco-timeline-item-dot-custom2"
                                                        data-status="{{ $item->status_id }}">
                                                        <div
                                                            class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="sc-jeGSBP">Đơn hàng đang được chuẩn bị</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        Đơn hàng đang được chuẩn bị để giao cho đơn bị vận chuyển</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="listitem">
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                    style="border-left-style: dashed;"></div>
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="theme-arco-timeline-item-dot-custom1 active"
                                                        data-status="{{ $item->status_id }}">
                                                        <div
                                                            class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="theme-arco-timeline-item-dot-wrapper">
                                                <div class="theme-arco-timeline-item-dot-content">
                                                    <div class="sc-jeGSBP">Đơn hàng do khách hàng tạo</div>
                                                    <div class="text-sm font-regular text-gray-3">
                                                        Đơn hàng đã được tiếp nhận và xác nhận từ hệ thống</div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom4"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Đơn đặt hàng đã hoàn thành</div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng đã được giao thành công đến bạn</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom3"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Đơn hàng đang được vận chuyển
                                                        </div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng đã được giao cho đơn vị vận chuyển và đang trên đường giao đến bạn</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom2"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Đơn hàng đang được chuẩn bị</div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng đang được chuẩn bị để giao cho đơn bị vận chuyển</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listitem">
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-line theme-arco-timeline-item-dot-line-is-vertical"
                                                        style="border-left-style: dashed;"></div>
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="theme-arco-timeline-item-dot-custom1 active"
                                                            data-status="{{ $item->status_id }}">
                                                            <div
                                                                class="theme-arco-timeline-item-parent-dot theme-arco-timeline-item-status-normal theme-arco-timeline-item-dotType-hollow-normal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="theme-arco-timeline-item-dot-wrapper">
                                                    <div class="theme-arco-timeline-item-dot-content">
                                                        <div class="sc-jeGSBP">Đơn hàng do khách hàng tạo</div>
                                                        <div class="text-sm font-regular text-gray-3">
                                                            Đơn hàng đã được tiếp nhận và xác nhận từ hệ thống</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex justify-between">
                                        <div class="index__card-title--rzIx0 font-semibold">
                                            <div class="flex items-center"><span class="mr-2"> Những gì khách hàng
                                                    của
                                                    bạn đã thanh toán</span></div>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="font-regular text-base text-gray-2">Phương thức thanh toán</div>
                                        <div class="font-regular text-base text-gray-2 flex">
                                            <div class="ml-4">
                                                @if ($getInfo->payment_method === 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán trực tuyến
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full h-1 my-24 bg-gray-line"></div>
                                    <div class="space-y-12">
                                        <div class="PriceCard__SubsContainer-sc-mbai84-1 iKmkmn space-y-12">
                                            <div class="space-y-8">
                                                <div
                                                    class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">
                                                    <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO"><span>Giá bán của
                                                            đơn hàng</span></div>
                                                    @foreach ($getInfo->order_details as $detail)
                                                        <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                            {{ number_format($detail->original_price, 0, ',', '.') }}₫
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="space-y-8">
                                                <div
                                                    class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">

                                                    <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO"><span>Phí vận
                                                            chuyển</span></div>
                                                    <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                        {{ number_format($getInfo->shipping_price, 0, ',', '.') }}₫</div>
                                                </div>
                                            </div>
                                            <div class="space-y-8">
                                                <div
                                                    class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">

                                                    <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO"><span>Phí vận
                                                            chuyển được giảm</span></div>
                                                    <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">-
                                                        {{ number_format($getInfo->shipping_voucher, 0, ',', '.') }}₫</div>
                                                </div>
                                            </div>
                                            <div class="space-y-8">
                                                <div
                                                    class="PriceCard__SubTotal-sc-mbai84-3 bXIVTv flex justify-between text-p3-semibold  text-neutral-text2">
                                                    <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO">
                                                        <span>Thuế</span>
                                                    </div>
                                                    <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                        {{ number_format($getInfo->tax, 0, ',', '.') }}₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="PriceCard__Total-sc-mbai84-2 dtbnPi flex justify-between text-lg font-bold text-neutral-text1">
                                            <div class="PriceCard__RowLeft-sc-mbai84-5 fgzImO">Tổng cộng</div>
                                            <div class="PriceCard__RowRight-sc-mbai84-6 gzTJaq">
                                                {{ number_format($getInfo->total_payment, 0, ',', '.') }}₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex justify-between">
                                        <div class="index__card-title--rzIx0 font-semibold">Thông tin khách hàng</div>
                                        <div></div>
                                    </div>

                                    <div class="w-full h-1 my-24 bg-gray-line"></div>
                                    <div>
                                        <div class="flex flex-col">
                                            <div class="font-regular text-gray-3 text-base">Địa chỉ vận chuyển</div>
                                        </div>
                                        <div class="ShippingAddress__AddressCard-sc-j8zs8s-0 dEiFbK mt-12">
                                            <div class="flex text-base font-regular text-gray-1 break-words">
                                                <div class="text-base font-regular text-gray-1 break-words">
                                                    Tên: {{ $getInfo->full_name }}</div><span class="sc-fHYxKZ"></span>
                                            </div>
                                            <div class="flex text-base font-regular text-gray-1 break-words">
                                                <div class="text-base font-regular text-gray-1 break-words">
                                                    Số điện thoại: {{ $getInfo->phone_number }}</div><span
                                                    class="sc-fHYxKZ"><span class="sc-fHYxKZ"></span></span>
                                            </div>
                                            <div
                                                class="ShippingAddress__AddressDetailContainer-sc-j8zs8s-1 dXiFPh text-base font-regular text-gray-1 break-words">
                                                <div class="text-base font-regular text-gray-1 break-words">
                                                    Địa chỉ: {{ $getInfo->address }}</div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timelineItems = document.querySelectorAll(
            '.theme-arco-timeline-item-dot-custom2, .theme-arco-timeline-item-dot-custom3, .theme-arco-timeline-item-dot-custom4, .theme-arco-timeline-item-dot-custom5'
        );

        timelineItems.forEach((item) => {
            const status = parseInt(item.getAttribute('data-status'));

            // Thêm active cho các trạng thái thông thường
            if (status === 2 || status === 3 || status === 4) {
                for (let i = 2; i <= status; i++) {
                    document.querySelectorAll(`.theme-arco-timeline-item-dot-custom${i}`).forEach(el =>
                        el.classList.add('active'));
                }
            } else if (status === 5) {
                // Nếu là trạng thái 5, thêm active cho 2 và 5
                document.querySelectorAll(
                        '.theme-arco-timeline-item-dot-custom2, .theme-arco-timeline-item-dot-custom5')
                    .forEach(el => el.classList.add('active'));
            }  else if (status === 6) {
                // Nếu là trạng thái 5, thêm active cho 2 và 5
                document.querySelectorAll(
                        '.theme-arco-timeline-item-dot-custom2,.theme-arco-timeline-item-dot-custom3 , .theme-arco-timeline-item-dot-custom5')
                    .forEach(el => el.classList.add('active'));
            }
        });
    });
</script>
