@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Yêu thích</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="{{ route('/') }}">Home</a></li>
                                <li class="breadcrumb-item active"> <a href="{{ route('/') }}">Sản phẩm yêu thích</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container wishlist-box">
                <div class="product-tab-content ratio1_3">
                    <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                                   
                    </div>
                </div>
            </div>
        </section>
        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"><button class="btn-close" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/1.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/2.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/3.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/4.jpg" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/5.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/6.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/7.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/8.jpg" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h3>Women Pink Shirt</h3>
                                    <h5>$32.96</h5>
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <div class="border-product">
                                        <h6>Product details</h6>
                                        <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium
                                            doloremque laudantium</p>
                                    </div>
                                    <div class="product-description">
                                        <div class="size-box">
                                            <ul>
                                                <li class="active"><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li> <a href="#">xl</a></li>
                                            </ul>
                                        </div>
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="qty-box">
                                            <div class="input-group"><button class="btn quantity-left-minus"
                                                    type="button" data-type="minus" data-field=""><i
                                                        class="fa-solid fa-angle-left"></i></button><input
                                                    class="form-control input-number" type="text" name="quantity"
                                                    value="1"><button class="btn quantity-right-plus" type="button"
                                                    data-type="plus" data-field=""><i
                                                        class="fa-solid fa-angle-right"></i></button></div>
                                        </div>
                                    </div>
                                    <div class="product-buttons"><a class="btn btn-solid" href="cart.html">Add to
                                            cart</a><a class="btn btn-solid" href="product.html">View detail</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End container content -->
@endsection
@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user/fovorite.js') }}"></script>
@endsection