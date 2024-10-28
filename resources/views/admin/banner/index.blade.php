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
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Banner trang web</h6>
                <a href="{{ route('admin.banner.create') }}" class="btn btn-success text-white text-decoration-none"><i
                        class="fas fa-plus"></i> Thêm mới banner</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên Banner</th>                              
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên Banner</th>                              
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->name }}</td>
                                    <td>
                                        @if ($banner->banner_images->isNotEmpty())
                                            @foreach ($banner->banner_images as $banner_image)
                                                <img src="{{ asset('storage/' . $banner_image->file_name) }}"
                                                    alt="Banner Image" style="max-width: 100px;">
                                            @endforeach
                                        @else
                                            <span>Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td>
                                        @if($banner->is_active == 1)
                                        <a href="{{ route('admin.banner.offactive', $banner->id) }}" class="btn btn-danger"><i class="fa fa-eye-slash"></i></a>
                                    @else
                                        <a href="{{ route('admin.banner.onactive', $banner->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                    @endif
                                        <a href="{{ route('admin.banner.edit', $banner->id) }}"
                                            class="btn btn-warning"><i class="fa fa-wrench"></i></a>
                                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
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
