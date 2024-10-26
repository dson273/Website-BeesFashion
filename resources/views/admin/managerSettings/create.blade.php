@extends('admin.layouts.master')

@section('content')
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Thêm chức năng</h1>
    <div class="card-body">
        <form action="{{ route('admin.managerSettings.store') }}" method="POST">
            @csrf
            <div class=" mb-3">
                <label for="manager_name" class="form-label">Tên chức năng</label>
                <input type="text" name="manager_name" class="form-control @error('manager_name') is-invalid @enderror" value="{{ old('manager_name') }}" placeholder="Nhập tên chức năng">
                @error('manager_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 mb-3">
                <label for="parent_manager_setting_id" class="form-label">Chức năng cha</label>
                <select name="parent_manager_setting_id" class="form-control">
                    <option value="">Không có</option>
                    @foreach ($parentSettings as $parentSetting)
                        <option value="{{$parentSetting->id}}">{{$parentSetting->manager_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Thêm</button>
            </div>
        </form>

    </div>
</div>
@endsection