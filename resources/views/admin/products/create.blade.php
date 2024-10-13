@extends('admin.layouts.master')

@section('title')
Tạo mới sản phẩm
@endsection

@section('style-libs')
<link rel="stylesheet" href="{{asset('css/admin/product/create.css')}}">
@endsection

@section('script-libs')
<script src="{{asset('js/admin/product/create.js')}}"></script>
@endsection

@section('content')
<div class="mb-2 ml-3">
    <a href="{{route('admin.products.index')}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới sản phẩm </h1>
    <div class="card-body">
        <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
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
                    <div class="d-flex justify-content-between">
                        <label for="" class="form-label">Hình ảnh</label>
                        <span class="text-dange" id="removeAllBtn">Remove all</span>
                    </div>
                    <div class="row row-cols-5" id="imagePreview">
                        <div class="col mb-2">
                            <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                <div class="form-group text-center">
                                    <label for="fileUpload" class="form-label" style="cursor: pointer;">
                                        <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                        </svg>
                                        <div class="mt-2">Click to upload</div>
                                    </label>
                                    <input type="file" class="form-control d-none" id="fileUpload" name="images[]" multiple accept="image/*" onchange="previewImages(this)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection