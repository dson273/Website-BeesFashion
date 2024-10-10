@extends('admin.layouts.master')

@section('title')
Tạo mới danh mục sản phẩm
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới danh mục </h1>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Ảnh</label>
                    <input type="file" name="cover" class="form-control">
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Mô tả</label>
                    <textarea name="description" id="" cols="40" rows="4" class="form-control"></textarea>
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Trạng thái</label>
                    <input type="checkbox" name="is_active" class="form-input">
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Tạo mới</button>
                </div>

            </form>
        </div>
    </div>
@endsection

