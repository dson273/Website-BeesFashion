@extends('admin.layouts.master')

@section('title')
    Tạo mới danh mục sản phẩm
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới danh mục </h1>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" class="form-control">

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Ảnh</label>
                    <input type="file" name="image" class="form-control">

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Mô tả</label>
                    <textarea name="description" id="" cols="40" rows="4" class="form-control"></textarea>

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Phân loại</label>
                    <select name="fixed" class="form-control">
                        <option value="1" selected>Danh mục thường</option>
                        <option value="0">Danh mục sản phẩm bán chạy</option>
                    </select>
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Thuộc danh mục</label>
                    <select name="parent_category_id" class="form-control">
                        <option value="" selected>--Danh mục cha--</option>
                        @foreach ($cate_parent as $key => $value)
                            <option value="{{ $value->id }}">
                                @php
                                    $str = '';
                                    for ($i = 0; $i < $value->level; $i++) {
                                        echo $str;
                                        $str .= '-- ';
                                    }
                                @endphp
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" selected>Hiển Thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection
