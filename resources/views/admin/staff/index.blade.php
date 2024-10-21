@extends('admin.layouts.master')
@section('title')
    Quản lý nhân viên
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">List staffs</h1>
        <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                                    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                                        DataTables documentation</a>.</p> -->
        <p class="mb-2">Below is a list of staffs</p>
        <!-- DataTales Example -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data of all staffs</h6>
                <a href="{{ route('admin.staffs.create') }}" class="btn btn-success text-white text-decoration-none"><i
                        class="fas fa-plus"></i> Create</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot class="sticky-bottom">
                            <tr>
                                <th>#</th>
                                <th>Full name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($staffs as $key => $staff)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$staff->full_name ?? 'Đang cập nhật'}}</td>
                                    <td>{{ $staff->username }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{$staff->phone ?? 'Đang cập nhật'}}</td>
                                    <td>{{$staff->address ?? 'Đang cập nhật'}}</td>
                                    <td>Đang cập nhật</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="{{ route('admin.staffs.edit', $staff->id) }}">Edit</a>
                                        <form action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Xóa</button>
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
    <!-- Modal Khóa Khách Hàng -->
    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="banForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="banModalLabel">Khóa Khách Hàng</h5>
                        <button type="button" class="close" data-dismiss="modal"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        <label for="type">Loại khóa:</label>
                        <select name="type" id="type" class="form-select">
                            <option value="warn">Cảnh cáo</option>
                            <option value="ban">Khóa</option>
                        </select>

                        <label for="reason" class="mt-3">Lý do khóa:</label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận khóa</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
    <script>
        let selectedUserId = null; // Biến toàn cục để lưu ID khách hàng

        function showBanModal(userId) {
            selectedUserId = userId; // Lưu ID khách hàng
            // Đặt URL action cho form ban khách hàng
            document.getElementById('banForm').action = '/admin/customers/ban/' + selectedUserId;
            // Hiện modal
            var banModal = new bootstrap.Modal(document.getElementById('banModal'));
            banModal.show();
        }
    </script>

@endsection
