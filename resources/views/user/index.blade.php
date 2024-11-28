@extends('user.layouts.master')

@section('script-libs')
    <script src="{{ asset('js/user/home.js') }}"></script>
@endsection

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
                                            <img class="img-fluid"
                                                src="{{ asset('storage/uploads/banners/images/id_' . $slider->id . '/' . $banner_image->file_name) }}"
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
                        @foreach ($sliders as $slider)
                            @foreach ($slider->banner_images as $key => $banner_image)
                                <button type="button" data-bs-target="#bannerCarousel"
                                    data-bs-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        @endforeach
                    </div>
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel"
                        data-bs-slide="next">
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
                        @foreach ($categoryLimit as $item)
                            <div class="swiper-slide">
                                <div class="fashion-box"><a href="#"> <img class="img-fluid"
                                            src="{{ asset('storage/uploads/categories/images/' . $item->image) }}"
                                            alt=""></a>
                                </div>
                                <h5>{{ $item->name }}</h5>
                            </div>
                        @endforeach
                        {{-- <div class="swiper-slide">
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
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- End category -->
        <section class="section-t-space">
            <div class="custom-container container product-contain">
                <div class="title">
                    <h3>ƯU ĐÃI BLACK FRIDAY ĐỘC QUYỀN ONLINE</h3>
                </div>
                <div class="detail-content MuiBox-root css-0">
                    <div class="block-voucher">
                        <div class="voucher-items-list">
                            @foreach ($vouchers as $item)
                                <div class="voucher-item">
                                    <div class="voucher-item-info">
                                        <div class="voucher-item-detail">
                                            <div class="voucher-item-des">
                                                <strong>
                                                    <span style="font-size: 12pt;">
                                                        <span style="color: #ba372a;">{{ $item->name }}
                                                        </span>
                                                        <br>
                                                    </span>
                                                </strong>
                                            </div>
                                            <div class="voucher-item-des"><span style="font-size: 10pt; color:black">Nhập mã
                                                    <strong><span
                                                            style="font-size: 12pt; color:black">{{ $item->code }}</span></strong><span
                                                        style="color: #e03e2d;"><strong><br></strong></span></span></div>
                                            <div class="voucher-item-des"><span style="font-size: 10pt; color:black">Cho đơn
                                                    hàng từ
                                                    {{ number_format($item->minimum_order_value / 1000) . 'K' }}</span>
                                            </div>
                                            <div class="voucher-item-date"><span class="expire"
                                                    style="font-size: 10pt; color:#ba372a">Hạn
                                                    sử dụng:
                                                    {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="voucher-item-action">
                                            <div class="action"><span class="copy-content"
                                                    style="cursor: pointer; font-size: 10pt; color:#ba372a"
                                                    data-code="{{ $item->code }}" data-copied-text="Đã chép">Sao
                                                    chép</span></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="voucher-item">
                                <div class="voucher-item-info">
                                    <div class="voucher-item-detail">
                                        <div class="voucher-item-title"><strong><span style="font-size: 12pt;"><span
                                                        style="color: #ba372a;">GIẢM THÊM 111K</span><br></span></strong>
                                        </div>
                                        <div class="voucher-item-des"><span style="font-size: 10pt;">Nhập mã <strong><span
                                                        style="font-size: 12pt;">HPBD111</span></strong><span
                                                    style="color: #e03e2d;"><strong><br></strong></span></span></div>
                                        <div class="voucher-item-des"><span style="font-size: 10pt;">Cho đơn hàng từ
                                                888K</span></div>
                                        <div class="voucher-item-date"><span class="expire" style="font-size: 10pt;">Hạn
                                                sử dụng: 21/11/2024</span></div>
                                    </div>
                                    <div class="voucher-item-action">
                                        <div class="action"><span class="copy-content"
                                                style="cursor: pointer; font-size: 10pt;" data-code="HPBD111"
                                                data-copied-text="Đã chép">Sao Chép</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="voucher-item">
                                <div class="voucher-item-info">
                                    <div class="voucher-item-detail">
                                        <div class="voucher-item-title"><strong><span style="font-size: 12pt;"><span
                                                        style="color: #ba372a;">TẶNG NGAY 80K</span><br></span></strong>
                                        </div>
                                        <div class="voucher-item-des"><span style="font-size: 10pt;">Nhập mã
                                            </span><strong><span style="font-size: 10pt;"><span
                                                        style="font-size: 12pt;">HAPPY80</span></span></strong><span
                                                style="color: #e03e2d;"><strong><span
                                                        style="font-size: 10pt;"><br></span></strong></span></div>
                                        <div class="voucher-item-des"><span style="font-size: 10pt;">Cho đơn hàng từ
                                                650K</span></div>
                                        <div class="voucher-item-date"><span class="expire" style="font-size: 10pt;">Hạn
                                                sử dụng: 21/11/2024</span></div>
                                    </div>
                                    <div class="voucher-item-action">
                                        <div class="action"><span class="copy-content"
                                                style="cursor: pointer; font-size: 10pt;" data-code="HAPPY80"
                                                data-copied-text="Đã chép">Sao Chép</span></div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#seller-products"
                                        role="tab" aria-controls="seller-products" aria-selected="false">
                                        <h6>Sản phẩm mới nhất</h6>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-products"
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
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-12 ratio_square">
                                <div class="tab-content">
                                    <!-- Sản phẩm mới -->
                                    <div class="tab-pane fade show active" id="seller-products" role="tabpanel"
                                        tabindex="0">
                                        <div class="row g-4">
                                            @foreach ($newProducts as $product)
                                                <div class="col-xxl-3 col-md-4 col-6">
                                                    <div class="product-box" data-product-id={{ $product->id }}>
                                                        <div class="img-wrapper">

                                                            <div class="label-block"><img
                                                                    src="{{ asset('assets/images/product/3.png') }}"
                                                                    alt="lable"><span>on <br>Sale!</span></div>
                                                            <div class="product-image">
                                                                @if ($product)
                                                                    <a
                                                                        href="{{ route('product.detail', $product->SKU) }}">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @else
                                                                    <a href="#">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="cart-info-icon">
                                                                <a class="wishlist-icon" href="javascript:void(0)"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="heart"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Add to Wishlist"></i>
                                                                </a>
                                                                {{-- <a href="javascript:void(0)" class="quick-view-btn"
                                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="eye" aria-hidden="true"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-title="Quick View"></i>
                                                                </a> --}}
                                                            </div>
                                                        </div>
                                                        <div class="product-detail">

                                                            <div class="add-button">
                                                                <a href="javascript:void(0)" class="add-to-cart quick-view-btn"
                                                                    data-product-id="{{ $product->id }}"
                                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                                    tabindex="0">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </div>

                                                            {{-- <div class="list-size" data-product-id="{{ $product->id }}">
                                                                <ul>
                                                                    @php
                                                                        $displayedSizes = [];
                                                                    @endphp

                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                                $sizeName = $attributeValue->name;
                                                                            @endphp

                                                                            @if ($attributeValue->attribute->attribute_type != null && strtolower($attributeValue->attribute->attribute_type->type_name) == 'button')
                                                                                @if (!in_array($sizeName, $displayedSizes))
                                                                                    @php
                                                                                        // Kiểm tra số lượng tồn kho
                                                                                        $stock = $variant->stock; // Giả sử bạn có trường stock trong variant
                                                                                    @endphp

                                                                                    <li data-size="{{ $attributeValue->id }}"
                                                                                        class="size-item {{ $stock <= 0 ? 'unactive' : '' }}">
                                                                                        <button type="button"
                                                                                            class="btn bt-large">
                                                                                            {{ $sizeName }}
                                                                                        </button>
                                                                                    </li>

                                                                                    @php
                                                                                        $displayedSizes[] = $sizeName;
                                                                                    @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                            </div> --}}

                                                            <div class="color-box">
                                                                @php
                                                                    $displayedColors = []; // Mảng lưu màu đã hiển thị
                                                                @endphp
                                                                <ul class="color-variant"
                                                                    style="list-style-type: none; padding: 0;">
                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                            @endphp

                                                                            @if (!empty($attributeValue->value) && !in_array($attributeValue->value, $displayedColors))
                                                                                <li class="color-item"
                                                                                    data-color="{{ $attributeValue->id }}"
                                                                                    style="background-color:{{ $attributeValue->value }};">
                                                                                    <a href="javascript:void(0)"
                                                                                        class="color-picker"></a>
                                                                                </li>
                                                                                @php
                                                                                    $displayedColors[] =
                                                                                        $attributeValue->value; // Thêm màu vào mảng
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                                <span>4.5 <i class="fa-solid fa-star"></i></span>

                                                            </div>


                                                            @if ($product)
                                                                <a href="{{ route('product.detail', $product->SKU) }}">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @else
                                                                <a href="#">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @endif
                                                            <p>
                                                                {{ $product->priceRange }}
                                                            </p>
                                                        </div>


                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Sản phẩm bán chạy -->
                                    <div class="tab-pane fade" id="features-products" role="tabpanel" tabindex="0">
                                        <div class="row g-4">
                                            @foreach ($products as $product)
                                                <div class="col-xxl-3 col-md-4 col-6">
                                                    <div class="product-box" data-product-id={{ $product->id }}>
                                                        <div class="img-wrapper">

                                                            <div class="label-block"><img
                                                                    src="{{ asset('assets/images/product/3.png') }}"
                                                                    alt="lable"><span>on <br>Sale!</span></div>
                                                            <div class="product-image">
                                                                @if ($product)
                                                                    <a
                                                                        href="{{ route('product.detail', $product->SKU) }}">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @else
                                                                    <a href="#">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="cart-info-icon">
                                                                <a class="wishlist-icon" href="javascript:void(0)"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="heart"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Add to Wishlist"></i>
                                                                </a>
                                                                <a href="javascript:void(0)" class="quick-view-btn"
                                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="eye" aria-hidden="true"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-title="Quick View"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-detail">
                                                            <div class="add-button">
                                                                <a href="javascript:void(0)" class="add-to-cart"
                                                                    data-product-id="{{ $product->id }}"
                                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                                    tabindex="0">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </div>

                                                            {{-- <div class="list-size" data-product-id="{{ $product->id }}">
                                                                <ul>
                                                                    @php
                                                                        $displayedSizes = [];
                                                                    @endphp

                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                                $sizeName = $attributeValue->name;
                                                                            @endphp

                                                                            @if ($attributeValue->attribute->name == 'Size' && is_null($attributeValue->value))
                                                                                @if (!in_array($sizeName, $displayedSizes))
                                                                                    @php
                                                                                        // Kiểm tra số lượng tồn kho
                                                                                        $stock = $variant->stock; // Giả sử bạn có trường stock trong variant
                                                                                    @endphp

                                                                                    <li data-size="{{ $attributeValue->id }}"
                                                                                        class="size-item {{ $stock <= 0 ? 'unactive' : '' }}">
                                                                                        <button type="button"
                                                                                            class="btn bt-large">
                                                                                            {{ $sizeName }}
                                                                                        </button>
                                                                                    </li>

                                                                                    @php
                                                                                        $displayedSizes[] = $sizeName;
                                                                                    @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                            </div> --}}

                                                            <div class="color-box">
                                                                @php
                                                                    $displayedColors = []; // Mảng lưu màu đã hiển thị
                                                                @endphp
                                                                <ul class="color-variant"
                                                                    style="list-style-type: none; padding: 0;">
                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                            @endphp

                                                                            @if (!empty($attributeValue->value) && !in_array($attributeValue->value, $displayedColors))
                                                                                <li class="color-item"
                                                                                    data-color="{{ $attributeValue->id }}"
                                                                                    style="background-color:{{ $attributeValue->value }};">
                                                                                    <a href="javascript:void(0)"
                                                                                        class="color-picker"></a>
                                                                                </li>
                                                                                @php
                                                                                    $displayedColors[] =
                                                                                        $attributeValue->value; // Thêm màu vào mảng
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                                <span>4.5 <i class="fa-solid fa-star"></i></span>

                                                            </div>


                                                            @if ($product)
                                                                <a href="{{ route('product.detail', $product->SKU) }}">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @else
                                                                <a href="#">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @endif
                                                            <p>
                                                                {{ $product->priceRange }}
                                                            </p>
                                                        </div>


                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Sản phẩm có lượt xem nhiều -->
                                    <div class="tab-pane fade" id="latest-products" role="tabpanel" tabindex="0">
                                        <div class="row g-4">
                                            @foreach ($topProducts as $product)
                                                <div class="col-xxl-3 col-md-4 col-6">
                                                    <div class="product-box" data-product-id={{ $product->id }}>
                                                        <div class="img-wrapper">

                                                            <div class="label-block"><img
                                                                    src="{{ asset('assets/images/product/3.png') }}"
                                                                    alt="lable"><span>on <br>Sale!</span></div>
                                                            <div class="product-image">
                                                                @if ($product)
                                                                    <a
                                                                        href="{{ route('product.detail', $product->SKU) }}">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @else
                                                                    <a href="#">
                                                                        <img class="bg-img"
                                                                            src="{{ asset('uploads/products/images/' . $product->product_files[0]->file_name) }}"
                                                                            alt="Product Image">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="cart-info-icon">
                                                                <a class="wishlist-icon" href="javascript:void(0)"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="heart"
                                                                        aria-hidden="true" data-bs-toggle="tooltip"
                                                                        data-bs-title="Add to Wishlist"></i>
                                                                </a>
                                                                <a href="javascript:void(0)" class="quick-view-btn"
                                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                                    tabindex="0">
                                                                    <i class="iconsax" data-icon="eye" aria-hidden="true"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-title="Quick View"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-detail">
                                                            <div class="add-button">
                                                                <a href="javascript:void(0)" class="add-to-cart"
                                                                    data-product-id="{{ $product->id }}">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </div>

                                                            <div class="list-size" data-product-id="{{ $product->id }}">
                                                                <ul>
                                                                    @php
                                                                        $displayedSizes = [];
                                                                    @endphp

                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                                $sizeName = $attributeValue->name;
                                                                            @endphp

                                                                            @if ($attributeValue->attribute->name == 'Size' && is_null($attributeValue->value))
                                                                                @if (!in_array($sizeName, $displayedSizes))
                                                                                    @php
                                                                                        // Kiểm tra số lượng tồn kho
                                                                                        $stock = $variant->stock; // Giả sử bạn có trường stock trong variant
                                                                                    @endphp

                                                                                    <li data-size="{{ $attributeValue->id }}"
                                                                                        class="size-item {{ $stock <= 0 ? 'unactive' : '' }}">
                                                                                        <button type="button"
                                                                                            class="btn bt-large">
                                                                                            {{ $sizeName }}
                                                                                        </button>
                                                                                    </li>

                                                                                    @php
                                                                                        $displayedSizes[] = $sizeName;
                                                                                    @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                            <div class="color-box">
                                                                @php
                                                                    $displayedColors = []; // Mảng lưu màu đã hiển thị
                                                                @endphp
                                                                <ul class="color-variant"
                                                                    style="list-style-type: none; padding: 0;">
                                                                    @foreach ($product->product_variants as $variant)
                                                                        @foreach ($variant->variant_attribute_values as $variantAttributeValue)
                                                                            @php
                                                                                $attributeValue =
                                                                                    $variantAttributeValue->attribute_value;
                                                                            @endphp

                                                                            @if (!empty($attributeValue->value) && !in_array($attributeValue->value, $displayedColors))
                                                                                <li class="color-item"
                                                                                    data-color="{{ $attributeValue->id }}"
                                                                                    style="background-color:{{ $attributeValue->value }};">
                                                                                    <a href="javascript:void(0)"
                                                                                        class="color-picker"></a>
                                                                                </li>
                                                                                @php
                                                                                    $displayedColors[] =
                                                                                        $attributeValue->value; // Thêm màu vào mảng
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </ul>
                                                                <span>4.5 <i class="fa-solid fa-star"></i></span>

                                                            </div>


                                                            @if ($product)
                                                                <a href="{{ route('product.detail', $product->SKU) }}">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @else
                                                                <a href="#">
                                                                    <h6>{{ $product->name }}</h6>
                                                                </a>
                                                            @endif
                                                            <p>
                                                                {{ $product->priceRange }}
                                                            </p>
                                                        </div>


                                                    </div>
                                                </div>
                                            @endforeach
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
                                <div class="add-button"><a href="#"><i class="fa-regular fa-eye"></i> View
                                        details</a>
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
                                <div class="add-button"><a href="#"><i class="fa-regular fa-eye"></i> View
                                        details</a>
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
                                <div class="add-button"><a href="#"><i class="fa-regular fa-eye"></i> View
                                        details</a>
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
                                <div class="add-button"><a href="#"><i class="fa-regular fa-eye"></i> View
                                        details</a>
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
                                <div class="add-button"><a href="#"><i class="fa-regular fa-eye"></i> View
                                        details</a>
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
                                <div class="blog-box ratio3_2"><a class="blog-img" href="#"><img class="bg-img"
                                            src="{{ asset('assets/images/blog/layout-4/1.jpg') }}" alt=""></a>
                                </div>
                                <div class="blog-txt">
                                    <p>By: Admin / 26th aug 2020</p>
                                    <a href="#">
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
                            <div class="blog-box ratio_55"><a class="blog-img" href="#"><img class="bg-img"
                                        src="{{ asset('assets/images/blog/layout-4/2.jpg') }}" alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="#">
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
                            <div class="blog-box ratio3_2"><a class="blog-img" href="#"><img class="bg-img"
                                        src="{{ asset('assets/images/blog/layout-4/3.jpg') }}" alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="#">
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
                            <div class="blog-box ratio_55"><a class="blog-img" href="#"><img class="bg-img"
                                        src="{{ asset('assets/images/blog/layout-4/4.jpg') }}" alt=""></a></div>
                            <div class="blog-txt">
                                <p>By: Admin / 26th aug 2020</p>
                                <a href="#">
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
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/1.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/2.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/3.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/4.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/5.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/6.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/7.png') }}"
                                    alt="logo"></a></div>
                        <div class="swiper-slide"><a href="#"> <img src="{{ asset('assets/images/logos/3.png') }}"
                                    alt="logo"></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End thương hiệu -->

        <!-- Modal quikview -->
        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true" data-product-id="" data-variant-id="">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" id="close_modal"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide">
                                                <img class="img-fluid" id="product-image" src="" alt="Product Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <!-- Dữ liệu các ảnh khác sẽ được cập nhật qua JS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h4 id="product-name"></h4>
                                    <p id="product-sku"></p>
                                    <h4 id="product-price" style="color: #ba372a"></h4>
        
                                    <!-- Hiển thị danh sách thuộc tính -->
                                    <div class="blink-border attributes-container" id="attributes-container">
                                        <!-- Các thuộc tính sẽ được cập nhật qua JS -->
                                    </div>
        
                                    <div class="border-product">
                                        <h6>Mô tả sản phẩm</h6>
                                        <p id="product-description"></p>
                                    </div>
                                    <div class="product-description">
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="quantity">
                                            <button class="reduce" type="button"><i class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="quantity" value="1" min="1" max="10">
                                            <button class="increment" type="button"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="product-buttons">
                                        <a class="btn btn-solid" href="#" id="add-to-cart-btn">Add to cart</a>
                                        <a class="btn btn-solid" href="#">View detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- End model quikview -->

        {{-- <div class="wrapper">
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
        </div> --}}

        {{-- Modal thu thập thông tin --}}
        {{-- <div class="modal theme-modal newsletter-modal newsletter-4 fade" id="newsletter" tabindex="-1" role="dialog"
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
                                        <div class="form-floating"><input type="text" placeholder="Enter Your Name..">
                                        </div>
                                        <div class="form-floating"><input type="email"
                                                placeholder="Enter Your Email..">
                                        </div>
                                        <button class="btn btn-submit" type="submit" data-bs-dismiss="modal"
                                            aria-label="Close">Submit</button>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none d-lg-block">
                                    <div class="newslwtter-img"> <img class="img-fluid"
                                            src="{{ asset('assets/images/other-img/news-latter4.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End seach -->
    </div> --}}
        <div class="add-card-size" id="fancybox-add-to-cart">
            <div class="thank-you__icon"><svg width="160" height="160" viewBox="0 0 160 160" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M56.7833 20.1167C62.9408 13.9592 71.2921 10.5 80 10.5C84.3117 10.5 88.5812 11.3493 92.5648 12.9993C96.5483 14.6493 100.168 17.0678 103.217 20.1167C106.266 23.1655 108.684 26.785 110.334 30.7686C111.984 34.7521 112.833 39.0216 112.833 43.3333V62.8333H47.1667V43.3333C47.1667 34.6254 50.6259 26.2741 56.7833 20.1167ZM46.1667 62.8333V43.3333C46.1667 34.3602 49.7312 25.7545 56.0762 19.4096C62.4212 13.0646 71.0268 9.5 80 9.5C84.4431 9.5 88.8426 10.3751 92.9474 12.0754C97.0523 13.7757 100.782 16.2678 103.924 19.4096C107.065 22.5513 109.558 26.281 111.258 30.3859C112.958 34.4907 113.833 38.8903 113.833 43.3333V62.8333H133.333C133.582 62.8333 133.793 63.0163 133.828 63.2626L147.162 156.596C147.182 156.739 147.139 156.885 147.044 156.994C146.949 157.104 146.812 157.167 146.667 157.167H13.3333C13.1884 157.167 13.0506 157.104 12.9556 156.994C12.8606 156.885 12.8179 156.739 12.8384 156.596L26.1717 63.2626C26.2069 63.0163 26.4178 62.8333 26.6667 62.8333H46.1667ZM113.333 63.8333H46.6667H27.1003L13.9098 156.167H146.09L132.9 63.8333H113.333Z"
                        fill="#212121"></path>
                    <path
                        d="M107.205 91.3663L80.4451 121.251L64.5853 106.174L62 108.893L80.6618 126.634L110 93.8694L107.205 91.3663Z"
                        fill="black"></path>
                </svg>
            </div>
            <p class="notify__add-to-cart--success text-uppercase">Thêm vào giỏ hàng thành công !</p>
        </div>

    </main>
    <!-- End container content -->
@endsection
