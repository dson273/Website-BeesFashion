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
                <h6 class="m-0 font-weight-bold text-primary">Danh sách vouchers</h6>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Thêm vouchers mới
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên Voucher</th>
                                <th>Mã Voucher</th>
                                <th>Ảnh Voucher</th>
                                <th>Giá Trị Giảm</th>
                                <th>Số Lượng</th>
                                <th>Loại Voucher</th>
                                <th>Giá Tối Thiểu</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên Voucher</th>
                                <th>Mã Voucher</th>
                                <th>Ảnh Voucher</th>
                                <th>Giá Trị Giảm</th>
                                <th>Số Lượng</th>
                                <th>Loại Voucher</th>
                                <th>Giá Tối Thiểu</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($listVouchers as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td><img src="{{ asset('storage/uploads/vouchers/images/' . $item->image) }}"
                                            width="100px" alt=""></td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        @if ($item->type === 'fixed')
                                            Cố định
                                        @elseif ($item->type === 'percent')
                                            Phần trăm
                                        @elseif ($item->type === 'free_ship')
                                            Miễn phí vận chuyển
                                        @else
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>{{ $item->minimum_order_value }}</td>
                                    <td>{{ $item->start_date }}</td>
                                    <td>{{ $item->end_date }}</td>
                                    <td>{{ $item->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td>
                                        <a href="{{ route('admin.vouchers.show', $item->id) }}" class="btn btn-success"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route($item->is_active ? 'admin.vouchers.offactive' : 'admin.vouchers.onactive', $item->id) }}"
                                            class="btn {{ $item->is_active ? 'btn-danger' : 'btn-success' }}">
                                            <i class="fa {{ $item->is_active ? 'fa-power-off' : 'fa-power-off' }}"></i>
                                        </a>
                                        <a href="{{ route('admin.vouchers.edit', $item->id) }}" class="btn btn-warning"><i
                                                class="fa fa-wrench"></i></a>
                                        <form action="{{ route('admin.vouchers.destroy', $item->id) }}" class="d-inline"
                                            method="POST" onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @include('admin.vouchers.create')
@endsection
