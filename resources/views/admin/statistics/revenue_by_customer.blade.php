@extends('admin.layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Thống kê doanh thu</h1>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="revenueFilterForm" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kiểu thời gian</label>
                        <select name="time_type" class="form-control" id="timeTypeSelect">
                            <option value="daily">Theo ngày</option>
                            <option value="monthly" selected>Theo tháng</option>
                            <option value="yearly">Theo năm</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="dailySelect" style="display: none;">
                        <label class="form-label">Chọn ngày</label>
                        <input type="date" name="daily_date" class="form-control date-filter" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-4" id="monthlySelect">
                        <label class="form-label">Chọn tháng</label>
                        <input type="month" name="monthly_date" class="form-control date-filter" value="{{ now()->format('Y-m') }}">
                    </div>

                    <div class="col-md-4" id="yearlySelect" style="display: none;">
                        <label class="form-label">Chọn năm</label>
                        <select name="yearly_date" class="form-control date-filter">
                            @for ($year = now()->year; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ now()->year == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block w-100">Lọc dữ liệu</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Chi tiết khách hàng
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="customersTable">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Phân loại</th>
                                <th>Số đơn hàng</th>
                                <th>Tổng chi tiêu</th>
                                <th>Giá trị đơn TB</th>
                                <th>Đơn đầu tiên</th>
                                <th>Đơn gần nhất</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Spending Tiers -->
        <div class="row">
            <div class="col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Phân loại khách hàng theo chi tiêu
                    </div>
                    <div class="card-body">
                        <canvas id="customerTiersChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Chi tiết phân loại
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="spendingTiersTable">
                                <thead>
                                    <tr>
                                        <th>Phân loại</th>
                                        <th>Số lượng</th>
                                        <th>Tỷ lệ</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Chi tiết doanh thu theo thời gian
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="revenueTable">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Số khách hàng</th>
                                <th>Số đơn hàng</th>
                                <th>Tổng doanh thu</th>
                                <th>Giá trị đơn trung bình</th>
                                <th>Chi tiêu trung bình/khách</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-libs')
    <script src="{{ asset('js/admin/charts/getRenvenueCustomer.js') }}"></script>
@endsection
