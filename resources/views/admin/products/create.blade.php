@extends('admin.layouts.master')

@section('title')
Tạo mới sản phẩm
@endsection

@section('content')
<div class="mb-2 ml-3">
    <a href="{{route('admin.products.index')}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới sản phẩm </h1>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex flex-row">
                <div class="w-50">
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Mã sản phẩm</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control">
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
                </div>
                <div class="ml-3 w-50">
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Ảnh</label>
                        <input type="file" name="cover" class="form-control">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection