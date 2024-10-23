@extends('user.layouts.master')

@section('content')
    <!--Container Content -->
    <main>
        <!-- Banner -->
        <section class="section-space">
            <div class="custom-container container ">
                <!-- Carousel Wrapper -->
                <div id="bannerCarousel" class="carousel slide " data-bs-ride="carousel">
                    <div class="carousel-inner ">
                        <!-- Slide 1 -->
                        @foreach ($sliders as $slider)
                            @foreach ($slider->banner_images as $key => $banner_image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row">
                                        <a href="#">
                                            <img class="img-fluid" src="{{ asset('storage/' . $banner_image->file_name) }}"
                                                alt="Banner Image">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <!-- Slide 2 -->
                    {{-- <div class="carousel-item  ">
                            <div class="row ">
                                <a href="#">
                                    <img class="img-fluid" src="{{ asset('assets/images/banner/b-2.jpg') }}" alt="">
                                </a>
                            </div>
                        </div> --}}
<!-- Indicators/dots -->
<div class="carousel-indicators">
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
</div>
<!-- Carousel Controls -->
<button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>

                </div>
            </div>
        </section>
        <!-- End Banner -->






        <!-- Category -->
        <section class="section-t-space">
            <div class="container-fluid fashion-images">
                <div class="swiper fashion-images-slide">
                    <div class="swiper-wrapper ratio_square-2">
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/1.png') }}" alt=""></a>
                            </div>
                            <h5>Top Wear</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/2.png') }}" alt=""></a>
                            </div>
                            <h5>dresses</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/3.png') }}" alt=""></a>
                            </div>
                            <h5>bottom</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/4.png') }}" alt=""></a>
                            </div>
                            <h5>inner/sleep</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/5.png') }}" alt=""></a>
                            </div>
                            <h5>footwear</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/6.png') }}" alt=""></a>
                            </div>
                            <h5>sports/active</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/7.png') }}" alt=""></a>
                            </div>
                            <h5>Mini dresses</h5>
                        </div>
                        <div class="swiper-slide">
                            <div class="fashion-box"><a href="product-select.html"> <img class="img-fluid"
                                        src="{{ asset('assets/images/fashion/category/3.png') }}" alt=""></a>
                            </div>
                            <h5>footwear</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End category -->

        <!-- Fashikart specials -->
        <section class="section-t-space">
            <div class="custom-container container product-contain">
                <div class="title">
                    <h3>Fashikart specials</h3>

                </div>
                <div class="row trending-products">
                    <div class="col-12">
                        <div class="theme-tab-1">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#features-products"
                                        role="tab" aria-controls="features-products" aria-selected="true">
                                        <h6>Sản phẩm bán chạy</h6>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#latest-products"
                                        role="tab" aria-controls="latest-products" aria-selected="false">
                                        <h6>Sản phẩm có lượt xem nhiều</h6>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#seller-products"
                                        role="tab" aria-controls="seller-products" aria-selected="false">
                                        <h6>Sản phẩm mới</h6>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-12 ratio_square">
                                <div class="tab-content">
                                    <!-- Sản phẩm bán chạy -->
                                    <div class="tab-pane fade show active" id="features-products" role="tabpanel"
                                        tabindex="0">
                                        <div class="row g-4">
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><img
                                                                src="{{ asset('assets/images/product/3.png') }}"
                                                                alt="lable"><span>on <br>Sale!</span></div>
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/1.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>4.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Greciilooks Women's Stylish Top</h6>
                                                        </a>
                                                        <p>$100.00 <del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><img
                                                                src="{{ asset('assets/images/product/2.png') }}"
                                                                alt="lable"><span>on <br>Sale!</span></div>
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/2.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/3.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                        <div class="countdown">
                                                            <ul class="clockdiv1">
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="days"></div>
                                                                    </div>
                                                                    <span class="title">Days</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="hours"></div>
                                                                    </div>
                                                                    <span class="title">Hours</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="minutes"></div>
                                                                    </div>
                                                                    <span class="title">Min</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="seconds"></div>
                                                                    </div>
                                                                    <span class="title">Sec</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>2.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Beautiful Lycra Solid Women's High Zipper </h6>
                                                        </a>
                                                        <p>$1300 <del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/4.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sản phẩm có lượt xem nhiều -->
                                    <div class="tab-pane fade" id="latest-products" role="tabpanel" tabindex="0">
                                        <div class="row g-4">
                                            @foreach ($newProducts as $Product)
                                                <div class="col-xxl-3 col-md-4 col-6">
                                                    <div class="product-box">
                                                        <div class="img-wrapper">
                                                            <div class="label-block"><img
                                                                    src="{{ asset('assets/images/product/3.png') }}"
                                                                    alt="lable"><span>on <br>Sale!</span></div>
                                                            <div class="product-image"><a href="product-detail.html"> <img
                                                                        class="bg-img"
                                                                        src="{{ asset('assets/images/product/product-4/17.jpg') }}"
                                                                        alt="product"></a></div>
                                                            <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                    href="javascript:void(0)" tabindex="0"><i
                                                                        class="iconsax" data-icon="heart"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Add to Wishlist"></i></a><a
                                                                    href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#quick-view" tabindex="0"><i
                                                                        class="iconsax" data-icon="eye"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Quick View"></i></a></div>
                                                        </div>
                                                        <div class="product-detail">
                                                            <div class="add-button"><a href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#addtocart"
                                                                    title="add product" tabindex="0"><i
                                                                        class="fa-solid fa-plus"></i> Add To
                                                                    Cart</a>
                                                            </div>
                                                            <div class="color-box">
                                                                <ul class="color-variant">
                                                                    <li class="bg-color-purple"></li>
                                                                    <li class="bg-color-blue"></li>
                                                                    <li class="bg-color-red"></li>
                                                                    <li class="bg-color-yellow"></li>
                                                                </ul>
                                                                <span>4.5 <i class="fa-solid fa-star"></i></span>
                                                            </div>
                                                            <a href="product-detail.html">
                                                                <h6>{{ $Product->name }}</h6>
                                                            </a>


                                                            <p>{{ $Product->product_variants->first()->sale_price }}
                                                                <del>$140.00</del>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><img
                                                                src="{{ asset('assets/images/product/2.png') }}"
                                                                alt="lable"><span>on <br>Sale!</span></div>
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/18.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/19.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                        <div class="countdown">
                                                            <ul class="clockdiv3">
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="days"></div>
                                                                    </div>
                                                                    <span class="title">Days</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="hours"></div>
                                                                    </div>
                                                                    <span class="title">Hours</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="minutes"></div>
                                                                    </div>
                                                                    <span class="title">Min</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="seconds"></div>
                                                                    </div>
                                                                    <span class="title">Sec</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>2.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Beautiful Lycra Solid Women's High Zipper </h6>
                                                        </a>
                                                        <p>$1300 <del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/20.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <!-- Sản phẩm mới -->
                                    <div class="tab-pane fade" id="seller-products" role="tabpanel" tabindex="0">
                                        <div class="row g-4">
                                            @foreach ($topProducts as $Product)
                                                <div class="col-xxl-3 col-md-4 col-6">
                                                    <div class="product-box">
                                                        <div class="img-wrapper">
                                                            <div class="label-block"><img
                                                                    src="{{ asset('assets/images/product/3.png') }}"
                                                                    alt="lable"><span>on <br>Sale!</span></div>
                                                            <div class="product-image"><a href="product-detail.html"> <img
                                                                        class="bg-img"
                                                                        src="{{ asset('assets/images/product/product-4/17.jpg') }}"
                                                                        alt="product"></a></div>
                                                            <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                    href="javascript:void(0)" tabindex="0"><i
                                                                        class="iconsax" data-icon="heart"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Add to Wishlist"></i></a><a
                                                                    href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#quick-view" tabindex="0"><i
                                                                        class="iconsax" data-icon="eye"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Quick View"></i></a></div>
                                                        </div>
                                                        <div class="product-detail">
                                                            <div class="add-button"><a href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#addtocart"
                                                                    title="add product" tabindex="0"><i
                                                                        class="fa-solid fa-plus"></i> Add To
                                                                    Cart</a>
                                                            </div>
                                                            <div class="color-box">
                                                                <ul class="color-variant">
                                                                    <li class="bg-color-purple"></li>
                                                                    <li class="bg-color-blue"></li>
                                                                    <li class="bg-color-red"></li>
                                                                    <li class="bg-color-yellow"></li>
                                                                </ul>
                                                                <span>4.5 <i class="fa-solid fa-star"></i></span>
                                                            </div>
                                                            <a href="product-detail.html">
                                                                <h6>{{ $Product->name }}</h6>
                                                            </a>


                                                            <p>{{ $Product->product_variants->first()->sale_price }}
                                                                <del>$140.00</del>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><img
                                                                src="{{ asset('assets/images/product/2.png') }}"
                                                                alt="lable"><span>on <br>Sale!</span></div>
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/18.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/19.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                        <div class="countdown">
                                                            <ul class="clockdiv3">
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="days"></div>
                                                                    </div>
                                                                    <span class="title">Days</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="hours"></div>
                                                                    </div>
                                                                    <span class="title">Hours</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="minutes"></div>
                                                                    </div>
                                                                    <span class="title">Min</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="seconds"></div>
                                                                    </div>
                                                                    <span class="title">Sec</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>2.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Beautiful Lycra Solid Women's High Zipper </h6>
                                                        </a>
                                                        <p>$1300 <del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-4 col-6">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="product-image"><a href="product-detail.html"> <img
                                                                    class="bg-img"
                                                                    src="{{ asset('assets/images/product/product-4/20.jpg') }}"
                                                                    alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a class="wishlist-icon"
                                                                href="javascript:void(0)" tabindex="0"><i
                                                                    class="iconsax" data-icon="heart" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Add to Wishlist"></i></a><a
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" tabindex="0"><i
                                                                    class="iconsax" data-icon="eye" aria-hidden="true"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Quick View"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div class="add-button"><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#addtocart" title="add product"
                                                                tabindex="0"><i class="fa-solid fa-plus"></i> Add To
                                                                Cart</a>
                                                        </div>
                                                        <div class="color-box">
                                                            <ul class="color-variant">
                                                                <li class="bg-color-purple"></li>
                                                                <li class="bg-color-blue"></li>
                                                                <li class="bg-color-red"></li>
                                                                <li class="bg-color-yellow"></li>
                                                            </ul>
                                                            <span>3.5 <i class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <a href="product-detail.html">
                                                            <h6>Dennis Lingo Men Casual Shirt</h6>
                                                        </a>
                                                        <p>$120.00<del>$140.00</del></p>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Fashikart specials -->

        <!-- Product advertising -->
        <section class="section-t-space">
            <div class="custom-container container best-seller">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <div class="best-seller-img ratio_square-3"><a href="product-select.html"> <img
                                            class="bg-img"
                                            src="{{ asset('assets/images/layout-4/main-category/1.png') }}"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="col-md-7 ratio_landscape">
                                <div class="style-content">
                                    <h6>Wear Your Style</h6>
                                    <h2>Create New Version Of Yourself</h2>
                                    <h4>About Online Fashion Purchases</h4>
                                    <div class="link-hover-anim underline">
                                        <a class="btn btn_underline link-strong link-strong-unhovered"
                                            href="product-select.html">
                                            Shop Collection
                                        </a>
                                        <a class="btn btn_underline link-strong link-strong-hovered"
                                            href="product-select.html">
                                            Shop Collection
                                        </a>
                                    </div>
                                </div>
                                <a href="product-select.html"> <img class="bg-img"
                                        src="{{ asset('assets/images/layout-4/main-category/2.jpg') }}"
                                        alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 d-none d-xl-block">
                        <div class="best-seller-box">
                            <div class="offer-banner">
                                <a href="product-select.html">
                                    <h2>Extra 15% OFF</h2>
                                    <span> </span>
                                    <p>Designer Brand Season off In-store & Online for a limited Time</p>
                                    <div class="btn">
                                        <h6>Use Code: <span>KHUTRD***</span></h6>
                                    </div>
                                </a>
                            </div>
                            <div class="best-seller-content">
                                <h3>Make You Look Comfortable and Luxurious</h3>
                                <span> </span>
                                <div class="link-hover-anim underline">
                                    <a class="btn btn_underline link-strong link-strong-unhovered"
                                        href="product-select.html">
                                        Shop Collection
                                    </a>
                                    <a class="btn btn_underline link-strong link-strong-hovered"
                                        href="product-select.html">
                                        Shop Collection
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product advertising -->

        <!-- Trending Products -->
        <section class="section-t-space">
            <div class="custom-container container product-contain">
                <div class="title">
                    <h3>Trending Products</h3>
                </div>
                <div class="swiper fashikart-slide">
                    <div class="swiper-wrapper trending-products ratio_square">
                        <div class="swiper-slide product-box">
                            <div class="img-wrapper">
                                <div class="label-block"><img src="{{ asset('assets/images/product/2.png') }}"
                                        alt="lable"><span>on
                                        <br>Sale!</span>
                                </div>
                                <div class="product-image"><a href="#"> <img class="bg-img"
                                            src="{{ asset('assets/images/product/product-4/7.jpg') }}"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a class="wishlist-icon" href="javascript:void(0)"
                                        tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a><a
                                        href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                            </div>
                            <div class="product-detail">
                                <div class="add-button"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="add product" tabindex="0"><i
                                            class="fa-solid fa-plus"></i> Add To Cart</a>
                                </div>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <span>4.5 <i class="fa-solid fa-star"></i></span>
                                </div>
                                <a href="#">
                                    <h6>ASIAN Women's Barfi-02 Shoes</h6>
                                </a>
                                <p>$100.00 <del>$140.00</del></p>
                            </div>
                        </div>
                        <div class="swiper-slide product-box">
                            <div class="img-wrapper">
                                <div class="product-image"><a href="#"> <img class="bg-img"
                                            src="{{ asset('assets/images/product/product-4/8.jpg') }}"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a class="wishlist-icon" href="javascript:void(0)"
                                        tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a><a
                                        href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                                <div class="countdown">
                                    <ul class="clockdiv4">
                                        <li>
                                            <div class="timer">
                                                <div class="days"></div>
                                            </div>
                                            <span class="title">Days</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="hours"></div>
                                            </div>
                                            <span class="title">Hours</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="minutes"></div>
                                            </div>
                                            <span class="title">Min</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="seconds"></div>
                                            </div>
                                            <span class="title">Sec</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-detail">
                                <div class="add-button"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="add product" tabindex="0"><i
                                            class="fa-solid fa-plus"></i> Add To Cart</a>
                                </div>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <span>3.5 <i class="fa-solid fa-star"></i></span>
                                </div>
                                <a href="#">
                                    <h6>Women Rayon Solid Hat</h6>
                                </a>
                                <p>$120.00<del>$140.00</del></p>
                            </div>
                        </div>
                        <div class="swiper-slide product-box">
                            <div class="img-wrapper">
                                <div class="label-block"><img src="{{ asset('assets/images/product/3.png') }}"
                                        alt="lable"><span>on
                                        <br>Sale!</span>
                                </div>
                                <div class="product-image"><a href="#"> <img class="bg-img"
                                            src="{{ asset('assets/images/product/product-4/9.jpg') }}"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a class="wishlist-icon" href="javascript:void(0)"
                                        tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a><a
                                        href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                            </div>
                            <div class="product-detail">
                                <div class="add-button"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="add product" tabindex="0"><i
                                            class="fa-solid fa-plus"></i> Add To Cart</a>
                                </div>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <span>2.5 <i class="fa-solid fa-star"></i></span>
                                </div>
                                <a href="#">
                                    <h6>OJASS Men's Solid Regular Jacket</h6>
                                </a>
                                <p>$1300 <del>$140.00</del></p>
                            </div>
                        </div>
                        <div class="swiper-slide product-box">
                            <div class="img-wrapper">
                                <div class="product-image"><a href="#"> <img class="bg-img"
                                            src="{{ asset('assets/images/product/product-4/10.jpg') }}"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a class="wishlist-icon" href="javascript:void(0)"
                                        tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a><a
                                        href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                                <div class="countdown">
                                    <ul class="clockdiv5">
                                        <li>
                                            <div class="timer">
                                                <div class="days"></div>
                                            </div>
                                            <span class="title">Days</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="hours"></div>
                                            </div>
                                            <span class="title">Hours</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="minutes"></div>
                                            </div>
                                            <span class="title">Min</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="seconds"></div>
                                            </div>
                                            <span class="title">Sec</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-detail">
                                <div class="add-button"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="add product" tabindex="0"><i
                                            class="fa-solid fa-plus"></i> Add To Cart</a>
                                </div>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <span>3.5 <i class="fa-solid fa-star"></i></span>
                                </div>
                                <a href="#">
                                    <h6>Fiesto Fashion Women's Handbag</h6>
                                </a>
                                <p>$120.00<del>$140.00</del></p>
                            </div>
                        </div>
                        <div class="swiper-slide product-box">
                            <div class="img-wrapper">
                                <div class="product-image"><a href="#"> <img class="bg-img"
                                            src="{{ asset('assets/images/product/product-4/3.jpg') }}"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a class="wishlist-icon" href="javascript:void(0)"
                                        tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a><a
                                        href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                            </div>
                            <div class="product-detail">
                                <div class="add-button"><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="add product" tabindex="0"><i
                                            class="fa-solid fa-plus"></i> Add To Cart</a>
                                </div>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <span>2.5 <i class="fa-solid fa-star"></i></span>
                                </div>
                                <a href="#">
                                    <h6>Beautiful Lycra Solid Women's High Zipper </h6>
                                </a>
                                <p>$1300 <del>$140.00</del></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>
        <!-- End Trending Products -->

        <!-- Blog -->
        <section class="section-t-space">
            <div class="custom-container container">
                <div class="title">
                    <h3>Latest Blog</h3>
                    <svg>
                        <use href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#main-line"></use>
                    </svg>
                </div>
                <div class="swiper blog-slide">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="blog-main">
                                <div class="blog-box ratio3_2"><a class="blog-img" href="blog-details.html"><img
                                            class="bg-img" src="{{ asset('assets/images/blog/layout-4/1.jpg') }}"
                                            alt=""></a></div>
                                <div class="blog-txt">
                                    <p>By: Admin / 26th aug 2020</p>
                                    <a href="blog-details.html">
                                        <h5>Many desktop publishing pack-ages abd page editor...</h5>
                                    </a>
                                    <div class="link-hover-anim underline">
                                        <a class="btn btn_underline link-strong link-strong-unhovered" href="#">
                                            Read
                                            More
                                            <svg>
                                                <use
                                                    href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                                </use>
                                            </svg>
                                        </a>
                                        <a class="btn btn_underline link-strong link-strong-hovered" href="#">
                                            Read More
                                            <svg>
                                                <use
                                                    href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                                </use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-main">
                            <div class="blog-box ratio_55"><a class="blog-img" href="blog-details.html"><img
                                        class="bg-img" src="{{ asset('assets/images/blog/layout-4/2.jpg') }}"
                                        alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="blog-details.html">
                                    <h5>Many desktop publishing pack-ages abd page editor...</h5>
                                </a>
                                <div class="link-hover-anim underline">
                                    <a class="btn btn_underline link-strong link-strong-unhovered" href="#">
                                        Read More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                    <a class="btn btn_underline link-strong link-strong-hovered" href="#">
                                        Read
                                        More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-main">
                            <div class="blog-box ratio3_2"><a class="blog-img" href="blog-details.html"><img
                                        class="bg-img" src="{{ asset('assets/images/blog/layout-4/3.jpg') }}"
                                        alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="blog-details.html">
                                    <h5>Many desktop publishing pack-ages abd page editor...</h5>
                                </a>
                                <div class="link-hover-anim underline">
                                    <a class="btn btn_underline link-strong link-strong-unhovered" href="#">
                                        Read More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                    <a class="btn btn_underline link-strong link-strong-hovered" href="#">
                                        Read
                                        More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-main">
                            <div class="blog-box ratio_55"><a class="blog-img" href="blog-details.html"><img
                                        class="bg-img" src="{{ asset('assets/images/blog/layout-4/4.jpg') }}"
                                        alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="blog-details.html">
                                    <h5>Many desktop publishing pack-ages abd page editor...</h5>
                                </a>
                                <div class="link-hover-anim underline">
                                    <a class="btn btn_underline link-strong link-strong-unhovered" href="#">
                                        Read More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                    <a class="btn btn_underline link-strong link-strong-hovered" href="#">
                                        Read
                                        More
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End blog -->

        <!-- Thương hiệu -->
        <section class="section-b-space">
            <div class="custom-container container">
                <div class="swiper logo-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/1.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/2.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/3.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/4.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/5.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/6.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/7.png') }}" alt="logo"></a></div>
                        <div class="swiper-slide"><a href="product-select.html"> <img
                                    src="{{ asset('assets/images/logos/3.png') }}" alt="logo"></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End thương hiệu -->

        <!-- Modal quikview -->
        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/1.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/2.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/3.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/4.jpg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/5.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/6.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/7.jpg') }}" alt="">
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="{{ asset('assets/images/pro/8.jpg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h3>Women Pink Shirt</h3>
                                    <h5>$32.96<del>$50.12</del></h5>
                                    <ul class="color-variant">
                                        <li class="bg-color-brown"></li>
                                        <li class="bg-color-chocolate"></li>
                                        <li class="bg-color-coffee"></li>
                                        <li class="bg-color-black"></li>
                                    </ul>
                                    <div class="border-product">
                                        <h6>Product details</h6>
                                        <p>Western yoke on an Indigo shirt made of 100% cotton. Ideal for informal
                                            gatherings, this top will ensure your comfort and style throughout the day.
                                        </p>
                                    </div>
                                    <div class="product-description">
                                        <div class="size-box">
                                            <ul>
                                                <li class="active"><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                            </ul>
                                        </div>
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="quantity"><button class="minus" type="button"><i
                                                    class="fa-solid fa-minus"></i></button><input type="number"
                                                value="1" min="1" max="20"><button class="plus"
                                                type="button"><i class="fa-solid fa-plus"></i></button></div>
                                    </div>
                                    <div class="product-buttons"><a class="btn btn-solid" href="cart.html">Add to
                                            cart</a><a class="btn btn-solid" href="product-detail.html">View
                                            detail</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End model quikview -->

        <!-- Modal add cart -->
        <div class="modal theme-modal fade cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal1">
                        <div class="custom-container container">
                            <div class="row">
                                <div class="col-12 px-0">
                                    <div class="modal-bg addtocart">
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="d-flex">
                                            <a href="#"><img class="img-fluid blur-up lazyload pro-img"
                                                    src="{{ asset('assets/images/modal/0.jpg') }}" alt=""></a>
                                            <div class="add-card-content align-self-center text-center">
                                                <a href="#">
                                                    <h6><i class="fa-solid fa-check"> </i>Item <span>men full
                                                            sleeves</span><span> successfully added to your Cart</span>
                                                    </h6>
                                                </a>
                                                <div class="buttons"><a class="view-cart btn btn-solid"
                                                        href="cart.html">Your cart</a><a class="checkout btn btn-solid"
                                                        href="check-out.html">Check
                                                        out</a><a class="continue btn btn-solid"
                                                        href="index.html">Continue shopping</a></div>
                                                <div class="upsell_payment"><img class="img-fluid blur-up lazyload"
                                                        src="{{ asset('assets/images/payment_cart.png') }}"
                                                        alt=""></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-upsell">
                                        <h5>Products Loved by Our Customers</h5>
                                        <svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#main-line">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/1.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/2.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/3.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/4.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/5.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                    <div class="card-img">
                                        <img src="{{ asset('assets/images/modal/6.jpg') }}" alt="user">
                                        <a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal add cart -->

        <!-- Modal cart right -->
        <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h4>
                <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body theme-scrollbar">
                <ul class="offcanvas-cart">
                    <li>
                        <a href="#"> <img src="{{ asset('assets/images/cart/1.jpg') }}" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control">
                                    <button class="btn-control__remove" id="btn-remove">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity-previous">2</div>
                                        <div id="quantity-current">3</div>
                                        <div id="quantity-next">4</div>
                                    </div>
                                    <button class="btn-control__add" id="btn-add">+</button>
                                </div>
                            </div>
                        </div>
                        <i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('assets/images/cart/2.jpg') }}" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total1">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control">
                                    <button class="btn-control__remove" id="btn-remove1">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity1-previous">2</div>
                                        <div id="quantity1-current">3</div>
                                        <div id="quantity1-next">4</div>
                                    </div>
                                    <button class="btn-control__add" id="btn-add1">+</button>
                                </div>
                            </div>
                        </div>
                        <i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('assets/images/cart/3.jpg') }}" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total2">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control">
                                    <button class="btn-control__remove" id="btn-remove2">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity2-previous">2</div>
                                        <div id="quantity2-current">3</div>
                                        <div id="quantity2-next">4</div>
                                    </div>
                                    <button class="btn-control__add" id="btn-add2">+</button>
                                </div>
                            </div>
                        </div>
                        <i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li>
                        <a href="#"> <img src="{{ asset('assets/images/cart/4.jpg') }}" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total3">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control">
                                    <button class="btn-control__remove" id="btn-remove3">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity3-previous">2</div>
                                        <div id="quantity3-current">3</div>
                                        <div id="quantity3-next">4</div>
                                    </div>
                                    <button class="btn-control__add" id="btn-add3">+</button>
                                </div>
                            </div>
                        </div>
                        <i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-footer">
                <p>Spend <span>$ 14.81 </span>more and enjoy <span>FREE SHIPPING!</span></p>
                <div class="footer-range-slider">
                    <div class="progress" role="progressbar" aria-label="Animated striped example"
                        aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated theme-default"
                            style="width: 46%"></div>
                    </div>
                </div>
                <div class="price-box">
                    <h6>Total :</h6>
                    <p>$ 49.59 USD</p>
                </div>
                <div class="cart-button"> <a class="btn btn_outline" href="cart.html"> View Cart</a><a
                        class="btn btn_black" href="check-out.html"> Checkout</a></div>
            </div>
        </div>
        <!-- End modal cart right -->

        <!-- Seach -->
        <div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1"
            aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header"><button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
            <div class="offcanvas-body theme-scrollbar">
                <div class="container">
                    <h3>What are you trying to find?</h3>
                    <div class="search-box"> <input type="search" name="text" placeholder="I'm looking for…"><i
                            class="iconsax" data-icon="search-normal-2"></i>
                    </div>
                    <h4>Popular Searches</h4>
                    <ul class="rapid-search">
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Jeans
                                Women</a>
                        </li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Blazer
                                Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Jeans
                                Men</a>
                        </li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Blazer
                                Men</a>
                        </li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>T-Shirts
                                Men</a></li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Shoes
                                Men</a>
                        </li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>T-Shirts
                                Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Bags</a>
                        </li>
                        <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Sneakers
                                Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Dresses</a>
                        </li>
                    </ul>
                    <h4>You Might Like</h4>
                    <div class="row gy-4 ratio_square-2 preemptive-search">
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/1.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="product-detail.html">
                                            <h6> Women's Stylish Top</h6>
                                        </a>
                                        <p>$50.00 </p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4+</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/2.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="product-detail.html">
                                            <h6> Women's Stylish Top</h6>
                                        </a>
                                        <p>$95.00 <del>$140.00</del></p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>3+</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/3.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="product-detail.html">
                                            <h6> Women's Stylish Top</h6>
                                        </a>
                                        <p>$80.00 <del>$140.00</del></p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/4.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="product-detail.html">
                                            <h6> Women's Stylish Top</h6>
                                        </a>
                                        <p>$90.00 </p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>2+</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/5.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                        <a href="product-detail.html">
                                            <h6> Women's Stylish Top</h6>
                                        </a>
                                        <p>$180.00 <del>$140.00</del></p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4+</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="{{ asset('assets/images/product/product-2/blazers/6.jpg') }}"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <a href="product-detail.html">
                                        <h6> Women's Stylish Top</h6>
                                    </a>
                                    <p>$120.00 </p>
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4+</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End seach -->

        <!-- <div class="wrapper">
                                    <div class="title-box">
                                        <img src="{{ asset('assets/images/other-img/cookie.png') }}" alt="">
                                        <h3>Cookies Consent</h3>
                                    </div>
                                    <div class="info">
                                        <p>We use cookies to improve our site and your shopping experience. By continuing to browse our site you
                                            accept our cookie policy.
                                        </p>
                                    </div>
                                    <div class="buttons"><button class="button btn btn_outline sm" id="acceptBtn">Accept</button><button
                                            class="button btn btn_black sm">Decline</button></div>
                                </div> -->

        <!-- <div class="modal theme-modal newsletter-modal newsletter-4 fade" id="newsletter" tabindex="-1" role="dialog"
                                    aria-modal="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="modal-body p-0">
                                                <div class="news-latter-box">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6">
                                                            <div class="newslwtter-content">
                                                                <h2>Stay Fashionable</h2>
                                                                <span>Stay Informed</span>
                                                                <h4>Subscriber to Our Newsletter!</h4>
                                                                <p>Keep up to date so you don't miss any new updates or goods we reveal.</p>
                                                                <div class="form-floating"><input type="text" placeholder="Enter Your Name.."></div>
                                                                <div class="form-floating"><input type="email" placeholder="Enter Your Email..">
                                                                </div>
                                                                <button class="btn btn-submit" type="submit" data-bs-dismiss="modal"
                                                                    aria-label="Close">Submit</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-none d-lg-block">
                                                            <div class="newslwtter-img"> <img class="img-fluid"
                                                                    src="{{ asset('assets/images/other-img/news-latter4.png') }}" alt=""></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div> -->
    </main>
    <!-- End container content -->
@endsection
