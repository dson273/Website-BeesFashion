@extends('admin.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="startDate" class="form-label">Ngày bắt đầu</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">Ngày kết thúc</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button id="filterDate" class="btn btn-primary">Lọc</button>
            </div>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Tổng doanh thu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng doanh thu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalRevenue">0 ₫</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tổng đơn hàng -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tổng đơn hàng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalOrders">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm trong giỏ hàng -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Sản phẩm trong giỏ
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCartItems">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tổng lượt xem -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tổng lượt xem
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalViews">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-eye fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Biểu đồ doanh thu -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ doanh thu theo thương hiệu -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo thương hiệu</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="brandRevenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Top sản phẩm xem nhiều -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top sản phẩm xem nhiều</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="topViewedProducts">
                            <!-- Dynamic content will be loaded here -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Top doanh thu sản phẩm -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top doanh thu sản phẩm</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie">
                            <canvas id="productRevenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top khách hàng -->
        <div class="row">
            <!-- Top khách hàng -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top khách hàng</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="topCustomers">
                            <!-- Dynamic content will be loaded here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-libs')

@endsection
