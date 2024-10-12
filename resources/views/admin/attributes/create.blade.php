@ -0,0 +1,68 @@
@extends('admin.layouts.master')

@section('title')
    Tạo mới thuộc tính
@endsection

@section('content')
    <div class="card shadow mb-4">
        <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Tạo mới thuộc tính </h1>
        <div class="card-body">
            <form action="{{ route('admin.attributes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Tên thuộc tính</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Loại</label>
                    <select class="form-select" aria-label="Default select example" id="inputname" name="type">
                        <option value="color">Màu sắc</option>
                        <option value="size">Kích cỡ</option>
                    </select>
                </div>
                
                



                <div class="mt-3 mb-3 value1">
                    <label for="">Giá trị màu sắc</label>
                    <input type="color" name="value" id="v1" class="form-control" id="slug" placeholder="Chọn màu sắc">
                </div>
                
                <div class="mt-3 mb-3 value2" style="display:none">
                    <label for="">Giá trị kích cỡ</label>
                    <input type="text" name="" id="v2" class="form-control" id="slug" placeholder="Nhập kích cỡ (M, N, XL,...)">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Tạo thuộc tính</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
            // Kiểm tra giá trị đã chọn và điều chỉnh hiển thị/ẩn
            $('#inputname').change(function() {
                var selectedValue = $('#inputname').val();
                if (selectedValue === 'size') {
                    $('.value2').show();
                    $('#v2').attr({
                        name : 'value',
                    });
                    $('.value1').hide();
                    $('#v1').attr({
                        name : '',
                    });
                } else if (selectedValue === 'color') {
                    $('.value2').hide();
                    $('#v2').attr({
                        name : '',
                    });
                    $('.value1').show();
                    $('#v1').attr({
                        name : 'value',
                    });
                }
            });
    </script>
@endsection