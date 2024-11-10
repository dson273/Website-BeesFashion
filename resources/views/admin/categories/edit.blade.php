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
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Cập nhật danh mục</h6>
            </div>

            <div class="card-body">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $Cate->id) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" value="{{ $Cate->name }}">

                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Ảnh</label>
                            <input type="file" name="image" class="form-control">
                            <img src="{{ asset('storage/uploads/categories/images/' . $Cate->image) }}" width="150px"
                                alt="">

                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Mô tả</label>
                            <textarea name="description" id="" cols="40" rows="4" class="form-control">{{ $Cate->description }}</textarea>

                        </div>

                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Thuộc danh mục</label>
                            <select name="parent_category_id" class="form-control" {{ $Cate->parent_category_id == '' }}>
                                <option value="">Danh mục cha</option>
                                {!! $htmlOption !!}
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="is_active" class="form-label">Kích Hoạt</label>
                            <input type="checkbox" name="is_active" value="1" {{ $Cate->is_active ? 'checked' : '' }}>

                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
