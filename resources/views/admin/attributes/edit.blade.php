@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa thuộc tính
@endsection
@section('content')
    <div class="row">
        <!-- Phần form thêm mới -->
        <div class="card shadow col-md-4">
            <h1 class="h3 mt-3 text-center fw-bold">Chỉnh sửa thuộc tính</h1>
            <div class="card-body">
                <form action="{{ route('admin.attributes.update', $AttributesID->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-3 mb-3">
                        <label for="" class="form-label">Tên thuộc tính</label>
                        <input type="text" name="name" class="form-control" value="{{ $AttributesID->name }}">
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="attribute_type_id" class="form-label">Loại</label>
                        <select name="attribute_type_id" id="attribute_type_id" class="form-select form-select-sm mb-3"
                            aria-label="small select example"  >
                            @if ($listAttributeTypes->isEmpty())
                                <option value="">Không có loại thuộc tính nào</option>
                            @else
                                <option value="" >Chọn loại thuộc tính</option>
                                @foreach ($listAttributeTypes as $item)
                                    <option value="{{ $item->id }}">
                                        {{  $item->type_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Chỉnh sửa thuộc tính</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Phần danh sách -->

        <div class=" card shadow col-md-8">
            <div class="card-body">
                <h3>Danh sách thuộc tính</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th style="width: 75%">Tên</th>
                                <th style="width: 5%">Loại</th>
                                <th style="width: 20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listAttribute as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a
                                            href="{{ route('admin.attribute_values.show', $item->id) }}">{{ $item->name }}</a>
                                    </td>
                                    <td>{{ $item->attribute_type->type_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.attributes.edit', $item->id) }}" class="btn btn-warning"><i
                                                class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.attributes.destroy', $item->id) }}" class="d-inline"
                                            method="POST" onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
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
@endsection