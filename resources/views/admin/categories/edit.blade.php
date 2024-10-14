@extends('admin.layouts.master')

@section('title')
    Chỉnh sửa danh mục
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold"> Chỉnh sửa danh mục </h1>
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
            <form action="{{ route('admin.categories.update', $Cate->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" class="form-control" value="{{ $Cate->name }}">

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Ảnh</label>
                    <input type="file" name="image" class="form-control">
                    <img src="{{ Storage::url($Cate->image) }}" width="150px" alt="">

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Mô tả</label>
                    <textarea name="description" id="" cols="40" rows="4" class="form-control">{{ $Cate->description }}</textarea>

                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Thuộc danh mục</label>
                    <select name="parent_category_id" class="form-select" {{ $Cate->parent_category_id == '' }}>
                        <option value="">--Danh mục cha--</option>
                        @foreach ($cate_parent as $key => $value)
                            @if (!in_array($value->id, $sub_parent))
                                <option value="{{ $value->id }}" {{ $value->id == $Cate->parent_category_id ? 'selected' : '' }}>
                                    @php
                                        $str = '';
                                        for ($i = 0; $i < $value->level; $i++) {
                                            echo $str;
                                            $str .= '-- ';
                                        }
                                    @endphp
                                    {{ $value->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                
                
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ $Cate->is_active == '1' ? 'selected' : '' }}>Hiển Thị</option>
                        <option value="0" {{ $Cate->is_active == '0' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Chỉnh sửa</button>
                </div>
            </form>
        </div>
    </div>
@endsection
