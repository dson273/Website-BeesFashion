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
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data of all products</h6>

            </div>
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="all">
                        Tất cả <span id="all-count" class="badge badge-light">{{ $allCount->count() }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="pending">
                        Cần gửi <span id="pending-count" class="badge badge-light">{{ $pendingCount }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="shipping">
                        Đã gửi <span id="shipping-count" class="badge badge-light">{{ $shippingCount }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="completed">
                        Đã hoàn tất <span id="completed-count" class="badge badge-light">{{ $completedCount }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="processing">
                        Chờ xử lý <span id="processing-count" class="badge badge-light">{{ $processingCount }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="cancellation">
                        Đã hủy <span id="cancellation-count" class="badge badge-light">{{ $cancelledCount }}</span>
                    </span>
                </a>
                <a href="javascript:void(0)">
                    <span class="ml-3 btn status-tab" id="fail_delivery">
                        Giao hàng không thành công <span id="fail_delivery-count"
                            class="badge badge-light">{{ $fail_deliveryCount }}</span>
                    </span>
                </a>
            </div>


            <div id="all-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($allCount->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($allCount as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="pending-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pendingOrders->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($pendingOrders as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>
                                            <td>
                                                <a href="{{ route('admin.orders.print', $item->id) }}"
                                                    onclick="printAndReload(event, this)">
                                                    <i class="fa fa-print"></i> In đơn
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="shipping-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($shippingOrders->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($shippingOrders as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>
                                            <td>
                                                <a href="{{ route('admin.orders.active', $item->id) }}"
                                                    onclick="return confirm('Xác nhận giao đơn hàng?')">
                                                    Xác nhận
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="completed-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($completedOrders->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($completedOrders as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="processing-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($processingOrders->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($processingOrders as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>


                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="cancellation-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cancelledOrders->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($cancelledOrders as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="fail_delivery-content" class="tab-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Đơn hàng</th>
                                    <th>Người mua</th>
                                    <th>Mặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Phương thức vận chuyển</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($fail_delivery->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                                viewBox="0 0 200 200" fill="none">
                                                <g clip-path="url(#clip0_13_210)">
                                                    <mask id="mask0_13_210" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="0" y="0" width="200"
                                                        height="200">
                                                        <path d="M200 0H0V200H200V0Z" fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_13_210)">
                                                        <path
                                                            d="M158.831 85.8156C158.831 99.0704 148.086 109.816 134.831 109.816C121.576 109.816 110.831 99.0704 110.831 85.8156C110.831 72.5608 121.576 61.8156 134.831 61.8156C148.086 61.8156 158.831 72.5608 158.831 85.8156Z"
                                                            fill="#D9D9D9" fill-opacity="0.2" />
                                                        <path
                                                            d="M138.919 139.303C138.919 143.758 142.531 147.369 146.986 147.369C151.441 147.369 155.052 143.758 155.052 139.303C155.052 134.848 151.441 131.236 146.986 131.236C142.531 131.236 138.919 134.848 138.919 139.303Z"
                                                            fill="#25F4EE" />
                                                        <path
                                                            d="M55.5814 42.2365C55.5814 43.958 56.977 45.3536 58.6986 45.3536C60.4201 45.3536 61.8157 43.958 61.8157 42.2365C61.8157 40.5149 60.4201 39.1193 58.6986 39.1193C56.977 39.1193 55.5814 40.5149 55.5814 42.2365Z"
                                                            fill="#FF6673" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M80.0429 47.6503C80.0429 40.2776 86.0197 34.1185 93.3924 34.1185C100.765 34.1185 106.742 40.2776 106.742 47.6503H121.126V61.8156H65.64V47.6503H80.0429ZM93.4732 46.1718C96.0864 46.1718 98.2049 44.0533 98.2049 41.4401C98.2049 38.8268 96.0864 36.7084 93.4732 36.7084C90.86 36.7084 88.7415 38.8268 88.7415 41.4401C88.7415 44.0533 90.86 46.1718 93.4732 46.1718Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M99.4729 96.4955C99.4729 101.722 95.236 105.959 90.0096 105.959C84.7831 105.959 80.5462 101.722 80.5462 96.4955C80.5462 91.269 84.7831 87.0321 90.0096 87.0321C95.236 87.0321 99.4729 91.269 99.4729 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M130.59 96.4955C130.59 101.722 126.353 105.959 121.127 105.959C115.9 105.959 111.663 101.722 111.663 96.4955C111.663 91.269 115.9 87.0321 121.127 87.0321C126.353 87.0321 130.59 91.269 130.59 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path
                                                            d="M159.996 96.4955C159.996 101.722 155.759 105.959 150.533 105.959C145.307 105.959 141.07 101.722 141.07 96.4955C141.07 91.269 145.307 87.0321 150.533 87.0321C155.759 87.0321 159.996 91.269 159.996 96.4955Z"
                                                            fill="#FF949B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M59.7398 61.8815L54.1072 147.925H120.29L125.922 61.8815H59.7398ZM55.3077 47.6864C50.3212 47.6864 46.1903 51.5558 45.8645 56.5316L39.6124 152.038C39.2551 157.496 43.5859 162.12 49.0556 162.12H124.722C129.708 162.12 133.839 158.25 134.165 153.275L140.417 57.768C140.774 52.3099 136.444 47.6864 130.974 47.6864H55.3077Z"
                                                            fill="#5CD6D2" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.764 119.59L65.2338 119.592L65.2336 114.861L114.764 114.859V119.59Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M93.2542 129.3L65.2338 129.301L65.2336 124.57L93.254 124.569L93.2542 129.3Z"
                                                            fill="#FFEFC7" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M123.05 105.762L124.241 87.5594C127.934 88.8495 130.582 92.3632 130.582 96.4955C130.582 101.06 127.35 104.87 123.05 105.762Z"
                                                            fill="#223E70" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M114.116 47.6864C118.063 48.5819 121.009 52.1114 121.009 56.3291V61.8144H65.5228V56.3391C65.5228 52.1163 68.4729 48.5825 72.4245 47.6864H114.116Z"
                                                            fill="#223E70" />
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13_210">
                                                        <rect width="200" height="200" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($fail_delivery as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <a
                                                        href="{{ route('admin.orders.info', $item->id) }}"><strong>{{ $detail->product_variant->product->SKU }}</strong></a><br>
                                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, H:i:s') }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                @foreach ($item->order_details as $detail)
                                                    <img src="{{ asset('uploads/products/images/' . $detail->product_variant->image) }}"
                                                        alt="Product Image" width="50" height="50"><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->status_orders as $statusOrder)
                                                    @if ($statusOrder->status_id == 1)
                                                        Đơn hàng xử lý
                                                    @elseif($statusOrder->status_id == 2)
                                                        Đơn hàng cần gửi đi
                                                    @elseif($statusOrder->status_id == 3)
                                                        Đơn hàng đã được gửi đi
                                                    @elseif($statusOrder->status_id == 4)
                                                        Đơn hàng đã hoàn thành
                                                    @elseif($statusOrder->status_id == 5)
                                                        Đơn hàng đã bị hủy
                                                    @else
                                                        Đơn hàng giao không thành công
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($item->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán online
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->total_payment, 0, ',', '.') }} đ</td>


                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
<script>
    function printAndReload(event, link) {
        event.preventDefault(); // Ngăn chặn reload mặc định

        // Mở file PDF trong tab mới
        let printWindow = window.open(link.href, '_blank');

        // Sau khi tab được đóng hoặc sau một khoảng thời gian, reload lại trang
        printWindow.onunload = function() {
            setTimeout(() => {
                window.location.reload();
            }, 1000); // Delay 1 giây để đảm bảo quá trình in được xử lý
        };
    }
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.status-tab');
        const contents = document.querySelectorAll('.tab-content');

        // Lấy tab active từ localStorage nếu có
        const activeTabId = localStorage.getItem('activeTab');

        if (activeTabId) {
            // Gán active cho tab và nội dung tương ứng
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                activeTab.classList.add('active');
                const activeContent = document.getElementById(activeTabId + '-content');
                if (activeContent) {
                    activeContent.classList.add('active');
                }
            }
        }

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                // Loại bỏ lớp 'active' khỏi tất cả các tab
                tabs.forEach(function(tab) {
                    tab.classList.remove('active');
                });

                // Ẩn tất cả các nội dung
                contents.forEach(function(content) {
                    content.classList.remove('active');
                });

                // Thêm lớp 'active' vào tab được click
                tab.classList.add('active');

                // Lấy ID của tab đang được click
                const tabId = tab.id;

                // Lưu trạng thái tab vào localStorage
                localStorage.setItem('activeTab', tabId);

                // Hiển thị nội dung tương ứng với tab được chọn
                const activeContent = document.getElementById(tabId + '-content');
                if (activeContent) {
                    activeContent.classList.add('active');
                }
            });
        });
    });
</script>
