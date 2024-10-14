@ -0,0 +1,68 @@
@extends('admin.layouts.master')

@section('title')
    Tạo mới thuộc tính
@endsection

@section('content')



<div class="row">
    <div class="col-md-4">
        <div class="card-body">
            <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới thuộc tính </h1>
            <form action="{{ route('admin.attributes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên thuộc tính</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mt-3 mb-3">
                    <label for="attribute_type_id" class="form-label">Loại</label>
                    <select name="attribute_type_id" id="attribute_type_id"
                                    class="form-select">
                                    <option value="" selected>Chọn Danh Mục</option>
                                    @foreach ($listAttributeTypes as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Tạo thuộc tính</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card-body">
            <h3>Danh sách</h3>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%">STT</th>
                            <th style="width: 70%">Tên</th>
                            <th style="width: 5%">Type</th>
                            <th style="width: 20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ( as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item ->type_name }}</td>
                                <td>
                                    <a href="{{ route('admin.attribute_types.edit', $item->id) }}" class="btn btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.attribute_types.destroy', $item->id) }}" class="d-inline" method="POST"
                                            onsubmit="return confirm('Bạn có đồng ý xóa hay không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
@endsection