@extends('admin.layouts.master')
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
<h1 class="h2 mt-3 mb-4 text-center text-gray-800 fw-bold">History of being banned - opening a ban: {{ $staff->full_name }}</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách lịch sử ban/unban</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Activity type</th>
                        <th>Reason</th>
                        <th>Time</th>
                        <th>Effective status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($banHistory as $key => $history)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{!! $history->status == 0 ? '<span class="badge text-light bg-danger">Ban</span>' : '<span class="badge bg-success text-light">Unban</span>' !!}</td>
                            <td>{{ $history->reason }}</td>
                            <td>{{ $history->created_at }}</td>
                            <td>{!! $history->is_active == 1 ? '<span class="badge text-light bg-success">Effective</span>' : '<span class="badge bg-danger text-light">Invalid</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div>
                <a href="{{ route('admin.staffs.index') }}" class="btn btn-secondary text-white text-decoration-none"><i class="fa-solid fa-arrow-left mr-1"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>

@endsection
