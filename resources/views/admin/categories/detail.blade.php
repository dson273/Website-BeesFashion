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
                <h6 class="m-0 font-weight-bold text-primary">Danh Mục Sản Phẩm</h6>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Thêm</a>

            </div>
          
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Hình Ảnh</th>
                                <th>Mô tả danh mục</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Hình Ảnh</th>
                                <th>Mô tả danh mục</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($childCategories as $index => $cate)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $cate->name }}</td>
                                    <td><img src="{{ Storage::url($cate->image) }}" width="150px" alt=""></td>
                                    <td>{{ $cate->description }}</td>
                                    <td>{{ $cate->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $cate->id) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('admin.categories.destroy', $cate->id) }}" class="d-inline" method="POST"
                                            onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
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
@endsection
