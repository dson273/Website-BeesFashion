@extends('admin.layouts.master')
@section('title')
Chi tiết sản phẩm
@endsection

@section('style-libs')
<!-- Custom styles for this page -->
<link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/admin/product/show.css')}}">


@endsection

@section('script-libs')
<!-- Page level plugins -->
<script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>


<script src="{{ asset('js/admin/product/show.js')}}"></script>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detail of
        @if ($productDetail!='')
        <b>{{$productDetail['name']}}</b>
        @endif
    </h1>
    <p class="mb-2">Below is the product detail</p>
    <div class="mb-2 d-flex justify-content-start">
        <a href="{{route('admin.products.index')}}" class="btn btn-secondary text-white text-decoration-none"><i class="fas fa-arrow-left mr-1"></i>Back</a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div>
            <div class="card-header py-3 d-flex flex-row justify-content-around align-items-center no-select cspt row row-cols-1 row-cols-lg-6">
                <div class="d-flex flex-column align-items-center border p-4 rounded font-weight-bold btn-danger m-1 col importantInformationDiv">
                    <span>
                        Revenue
                    </span>
                    <span>
                        {{ number_format($totalProfit, 0, ',', '.') }} VND
                    </span>
                </div>
                <div class="d-flex flex-column align-items-center border p-4 rounded font-weight-bold btn-primary m-1 col importantInformationDiv">
                    <span>
                        Views
                    </span>
                    <span>
                        @if ($productDetail!='')
                        {{$productDetail['view']}}
                        @endif
                    </span>
                </div>
                <div class="d-flex flex-column align-items-center border p-4 rounded font-weight-bold btn-success m-1 col importantInformationDiv">
                    <span>
                        Purchases
                    </span>
                    <span>
                        @if ($productDetail!='')
                        {{$productDetail['total_sold']}}
                        @endif
                    </span>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center border p-4 rounded font-weight-bold btn-info m-1 col importantInformationDiv">
                    <span>
                        Votes
                    </span>
                    <div id="productStarRating" hidden>{{$productStar}}</div>
                    <div id="productRate"></div>
                    <div align="center" style="font-size: 13px;">{{$variantVoted}}</div>
                </div>
                <div class="d-flex flex-column align-items-center border p-4 rounded font-weight-bold btn-dark m-1 col importantInformationDiv">
                    <span>
                        Total variations
                    </span>
                    <span>
                        @if ($productDetail!='')
                        {{$productDetail['product_variants_count']}}
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h4>Base information</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>SKU</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($productDetail!='')
                            <tr class="productItem">
                                <td>{{$productDetail['id']}}</td>
                                <td>{{$productDetail['SKU']}}</td>
                                <td>
                                    <img src="{{asset('uploads/products/images/'.$productDetail['mainImage'])}}" alt="" width="100" height="100">
                                </td>
                                <td>{{$productDetail['name']}}</td>
                                <td>
                                    @if($productDetail['is_active']==1)
                                    <span class="text-success">Đang hoạt động</span>
                                    @else
                                    <span class="text-danger">Ngừng bán</span>
                                    @endif
                                </td>
                                <td>{{$productDetail['created_at']}}</td>
                                <td>{{$productDetail['updated_at']}}</td>
                                <td rowspan="2">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="d-flex flex-row justify-content-center">
                                            @if($productDetail['is_active']==1)
                                            <a href="{{route('admin.products.index.changestatus',$productDetail['id'])}}" class="btn btn-danger btn-sm d-flex align-items-center"><i class="fas fa-lock fa-sm mr-1"></i>Inactive</a>
                                            @else
                                            <a href="{{route('admin.products.index.changestatus',$productDetail['id'])}}" class="btn btn-success btn-sm d-flex align-items-center"><i class="fas fa-lock-open fa-sm mr-1"></i>Active</a>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-row justify-content-center mt-2">
                                            <a href="{{route('admin.products.edit',$productDetail['id'])}}" class="btn btn-warning btn-sm d-flex align-items-center mr-1"><i class="fas fa-pen-to-square fa-sm mr-1"></i>Edit</a>
                                            <a href="" class="btn btn-primary btn-sm d-flex align-items-center mr-1"><i class="fas fa-file-export fa-sm mr-1"></i>Export</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" class="font-weight-bold">Description</td>
                                <td colspan="5" align="center" class="overflow-hidden p-5">{!!$productDetail['description'] !!}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div>
                    <h4>Product videos</h4>
                    @if ($productDetail->product_videos->isNotEmpty())
                    <div class="row row-cols-1 row-cols-lg-6">
                        @foreach ($productDetail->product_videos as $imageItem)
                        <div class="col mb-3">
                            <video src="{{ asset('uploads/products/videos/' . $imageItem->file_name) }}" width="200" controls="true"></video>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>Not found any videos</p>
                    @endif
                </div>
                <div>
                    <h4>Product gallery</h4>
                    @if ($productDetail->product_gallery->isNotEmpty())
                    <div class="row row-cols-1 row-cols-lg-6">
                        @foreach ($productDetail->product_gallery as $imageItem)
                        <div class="col mb-3">
                            <img src="{{ asset('uploads/products/images/' . $imageItem->file_name) }}" class="rounded" alt="" width="170" height="170">
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>Not found any images</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4>List variations</h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Purchases</th>
                            <th>Revenue</th>
                            <th>Regular price</th>
                            <th>Sale price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tfoot class="sticky-bottom">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Purchases</th>
                            <th>Revenue</th>
                            <th>Regular price</th>
                            <th>Sale price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if ($productVariants!='')
                        @foreach ($productVariants as $key => $productVariant)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$productVariant->id}}</td>
                            <td>{{$productVariant->SKU}}</td>
                            <td>
                                <img src="{{asset('uploads/products/images/'.$productVariant->image)}}" alt="" width="100" height="100">
                            </td>
                            <td>{{$productVariant->name}}</td>
                            <td>{{$productVariant->total_sold}}</td>
                            <td>{{number_format($productVariant->total_profit,0,',','.')}} VND</td>
                            <td>{{$productVariant->regular_price}}</td>
                            <td>{{$productVariant->sale_price}}</td>
                            <td>{{$productVariant->stock}}</td>
                            <td>
                                @if($productVariant->is_active==1)
                                <span class="text-success">Đang hoạt động</span>
                                @else
                                <span class="text-danger">Ngừng bán</span>
                                @endif
                            </td>
                            <td>{{$productVariant->created_at}}</td>
                            <td>{{$productVariant->updated_at}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" align="center">Sản phẩm này không có biến thể!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection