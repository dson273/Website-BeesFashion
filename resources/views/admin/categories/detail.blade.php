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
                <div class="mb-2 ml-3">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-dark text-white text-decoration-none"><i
                            class="fas fa-arrow-left"></i> Quay lại</a>
                </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Chi Tiết Danh Mục</h6>
                {{-- <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Thêm danh mục con</a> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i
                    class="fas fa-plus"></i>
                    Thêm danh mục con
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả danh mục</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach ($childCategories as $index => $cate)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $cate->image ? asset('storage/uploads/categories/images/' . $cate->image) : asset('assets/images/icons/noimage.png') }}" 
                                             width="50px" >
                                        {{ $cate->name }}
                                    </td>
                                   
                                    <td>{{ $cate->description }}</td>
                                    <td>{{ $cate->is_active == 1 ? 'Hiển Thị' : 'Ẩn' }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $cate->id) }}" style="margin-right: 10px;"><img
                                            src="{{ asset('assets/images/icons/edit.svg') }}" alt="img"></a>
                                        <form action="{{ route('admin.categories.destroy', $cate->id) }}" class="d-inline" method="POST"
                                            onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="all: unset; cursor: pointer;">
                                                <img src="{{ asset('assets/images/icons/delete.svg') }}" alt="Delete">
                                            </button>
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
    @include('admin.categories.createchild')
@endsection
