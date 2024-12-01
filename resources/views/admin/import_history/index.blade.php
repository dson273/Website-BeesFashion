@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lịch sử nhập hàng</h6>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Nhập hàng
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU / Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Người nhập</th>
                                <th>Thời gian nhập</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>SKU / Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Người nhập</th>
                                <th>Thời gian nhập</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($importHistories as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_variant->SKU }} / {{ $item->product_variant->product->name }}</td>
                                    <td><img src="{{ asset('uploads/products/images/' . $item->product_variant->image) }}"
                                            width="100px" alt=""></td>
                                    <td>{{ number_format($item->import_price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $item->user ? $item->user->full_name : 'Fail' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y, H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @include('admin.import_history.create')
@endsection
