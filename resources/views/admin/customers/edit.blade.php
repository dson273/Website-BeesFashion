@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa khách hàng
@endsection

@section('content')
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold"> Chỉnh sửa khách hàng </h1>
    <div class="card-body">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="mb-3 mt-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" value="{{ old('username', $customer->username) }}" disabled name="username" id="username" class="form-control @error('username') is-invalid @enderror">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label" for="full_name">Họ và tên</label>
                <input type="text" value="{{ old('full_name', $customer->full_name) }}" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" placeholder="Họ và tên...">
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label" for="email">Email</label>
                <input type="text" value="{{ old('email', $customer->email) }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email...">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label" for="phone">Số điện thoại</label>
                <input type="text" value="{{ old('phone', $customer->phone) }}" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Số điện thoại...">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control @error('address') is-invalid @enderror" name="address" cols="30" rows="2" placeholder="Nhập địa chỉ (Không bắt buộc)...">{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>

    </div>
</div>

@endsection
