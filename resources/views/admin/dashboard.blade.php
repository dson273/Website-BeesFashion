@extends('admin.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <!-- Main Content -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        {{-- <div class="row mb-4">
            <form class="col-4">
                <div class="form-group">
                    <select class="form-control" id="select-time">
                        <option value="">Chọn thời gian thống kê</option>
                        <option value="day">Thống kê theo ngày</option>
                        <option value="month">Thống kê theo tháng</option>
                        <option value="year">Thống kê theo năm</option>
                    </select>
                </div>
            </form>
            <div class="col-8">
                <form action="" method="post" id="revenue" class="px-2">

                </form>
            </div>
        </div> --}}

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Shop</h6>
            </div>
            <div class="row mx-2 mt-4">
                <!-- Tổng sản phẩm của shop -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng sản phẩm
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalProducts">{{ $totalProducts ?? 0 }}</div>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.products.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-shirt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng lượt xem -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tổng lượt xem
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalView">{{ $totalView ?? 0 }}</div>
                                    <a class="btn btn-outline-info btn-sm" href="{{ route('admin.statistics.product_views') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng đơn hàng đã hoàn thành -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-new border-left-success shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Tổng đơn hàng
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalOrders">{{ $totalOrders ?? 0 }}</div>
                                    <a class="btn btn-outline-success btn-sm" href="{{ route('admin.orders.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng người dùng -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Tổng người dùng
                                    </div>
                                    <div class="h5 mb-1 font-weight-bold text-gray-800" id="totalUsers">{{ $totalUsers ?? 0 }}</div>
                                    <a class="btn btn-outline-warning btn-sm" href="{{ route('admin.customers.index') }}">Xem chi tiết<i class="fas fa-arrow-right ml-1 fa-sm"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-user-plus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <!-- Card Header -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Doanh thu BeesFashion</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle btn btn-sm btn-outline-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Thời gian mẫu:</div>
                                <button class="dropdown-item" onclick="fetchChartData('today')">Hôm nay</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_week')">Tuần này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_month')">Tháng này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_quarter')">Quý này</button>
                                <button class="dropdown-item" onclick="fetchChartData('this_year')">Năm nay</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_week')">Tuần trước</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_month')">Tháng trước</button>
                                <button class="dropdown-item" onclick="fetchChartData('last_year')">Năm trước</button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <form id="filterForm" class="mb-4">
                            <div class="row">
                                <!-- Ngày bắt đầu -->
                                <div class="col-md-5">
                                    <label for="startDate" class="form-label">Từ ngày:</label>
                                    <input type="date" id="startDate" name="start_date" class="form-control" required>
                                </div>
                                <!-- Ngày kết thúc -->
                                <div class="col-md-5">
                                    <label for="endDate" class="form-label">Đến ngày:</label>
                                    <input type="date" id="endDate" name="end_date" class="form-control" required>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button type="button" class="btn btn-primary mt-3" onclick="applyCustomFilter()">Lọc</button>
                                </div>
                            </div>
                        </form>

                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Dữ liệu đơn hàng</h6>
            </div>
            <div class="row mx-2 mt-4">
                <!-- Tổng sản phẩm của shop -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Đơn đã hoàn thành
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-chart-simple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng đơn hàng đã hoàn thành -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Đơn chờ xác nhận
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalOrders">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-chart-simple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng doanh thu -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Đơn bị huỷ
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCartItems">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-chart-simple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tổng lượt xem -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Đơn bị hoàn
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalViews">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-chart-simple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- End of Main Content -->
@endsection

@section('script-libs')
    <script src="{{ asset('js/admin/charts/getRevenueShop.js') }}"></script>
@endsection
