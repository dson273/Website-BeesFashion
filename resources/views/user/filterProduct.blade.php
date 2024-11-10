@extends('user.layouts.master')
@yield('css.app.css')
@section('content')
    {{-- <style>
        .range-slider {
            position: relative;
            width: 100%;
        }

        .price-display {
            position: absolute;
            font-weight: bold;
            transform: translateX(-50%);
            white-space: nowrap;
            background-color: white;
            padding: 2px 5px;
            border-radius: 5px;
            font-size: 12px;
        }

        #min-price-display {
            top: -25px;
            /* Hiển thị ở trên thanh trượt */
        }

        #max-price-display {
            top: 25px;
            /* Hiển thị ở dưới thanh trượt */
        }

        .range-slider-input {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 5px;
            background: linear-gradient(to right, #ddd 0%, #ddd 50%, #4CAF50 50%, #4CAF50 50%, #ddd 50%, #ddd 100%);
            outline: none;
            position: absolute;
            opacity: 0.8;
            transition: opacity .2s;
            pointer-events: none;
        }

        .range-slider-input:not(:last-of-type) {
            pointer-events: all;
        }

        .range-slider-input::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background-color: #4CAF50;
            cursor: pointer;
            border-radius: 50%;
            position: relative;
            z-index: 2;
        }

        .range-slider-input::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background-color: #4CAF50;
            cursor: pointer;
            border-radius: 50%;
            position: relative;
            z-index: 2;
        }
    </style> --}}
    <div class="tap-top">
        <div><i class="fa-solid fa-angle-up"></i></div>
    </div>
    <span class="cursor">
        <span class="cursor-move-inner">
            <span class="cursor-inner"></span>
        </span>
        <span class="cursor-move-outer">
            <span class="cursor-outer"></span>
        </span>
    </span>

    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Bộ sản phẩm</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active"> <a href="{{ route('/') }}">Bộ sản phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-3">
                    <div class="custom-accordion theme-scrollbar left-box">
                        <div class="left-accordion">
                            <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            {{-- tìm kiếm sản phẩm theo tên --}}
                            <div class="search-box">
                                <input type="search" id="search-input" name="text" placeholder="Tìm kiếm sản phẩm..."
                                    onkeyup="filterProducts()">
                                <i class="iconsax" data-icon="search-normal-2"></i>
                            </div>
                            {{-- Lọc theo danh mục --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsCateOpen-collapseEight">
                                        <span>Danh mục</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsCateOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="catagories-side theme-scrollbar">
                                            @foreach ($listCategory as $parentCategory)
                                                <li style="list-style-type: none; display: flex; align-items: center;">
                                                    <div style="margin-left: 0px; flex-grow: 1;">
                                                        <!-- Hiển thị danh mục cha -->
                                                        <input class="category-checkbox custom-checkbox"
                                                            id="category{{ $parentCategory->id }}" type="checkbox"
                                                            name="categories[]" value="{{ $parentCategory->id }}"
                                                            data-parent="{{ $parentCategory->parent_category_id }}"
                                                            data-id="{{ $parentCategory->id }}"
                                                            onchange="toggleChildCategories({{ $parentCategory->id }})">
                                                        <label
                                                            for="category{{ $parentCategory->id }}">{{ $parentCategory->name }}</label>
                                                    </div>
                                                </li>
    
                                                <!-- Hiển thị danh mục con của danh mục cha hiện tại -->
                                                @if ($parentCategory->categoryChildrent)
                                                    @foreach ($parentCategory->categoryChildrent as $childCategory)
                                                        <li style="list-style-type: none; display: flex; align-items: center;">
                                                            <div style="margin-left: 20px; flex-grow: 1;">
                                                                <!-- Lùi lại cho danh mục con -->
                                                                <input class="category-checkbox custom-checkbox"
                                                                    id="category{{ $childCategory->id }}" type="checkbox"
                                                                    name="categories[]" value="{{ $childCategory->id }}"
                                                                    data-parent="{{ $childCategory->parent_category_id }}"
                                                                    data-id="{{ $childCategory->id }}"
                                                                    onchange="toggleChildCategories({{ $childCategory->id }})">
                                                                <label
                                                                    for="category{{ $childCategory->id }}">{{ $childCategory->name }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- Phần lọc theo thương hiệu -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseEight">
                                        <span>Thương hiệu</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseEight">
                                    <div class="accordion-body">
                                        <ul class="theme-scrollbar">
                                            @foreach ($listBrand as $value)
                                                <li style="list-style-type: none; display: flex; align-items: center;">
                                                    <input class="brand-checkbox custom-checkbox"
                                                        id="brand{{ $value->id }}" type="checkbox" name="brands[]"
                                                        value="{{ $value->id }}">
                                                    <label for="brand{{ $value->id }}"
                                                        style="margin-left: 8px; display: flex; align-items: center; height: 100%;">
                                                        {{ $value->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- lọc theo giá --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseFour"><span>Giá</span></button></h2>
                                    <div class="price-display"> </div>
                                    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseFour">
                                        <div class="accordion-body">
                                            {{-- {{$minPriceProduct}} --}}
                                            <div class="range-slider">
                                                <input class="range-slider-input" type="range" name="min_price" min="{{$minPriceProduct}}" max="{{$maxPriceProduct}}"
                                                    step="1" value="{{$minPriceProduct}}" id="range-slider-min" readonly>
                                                <input class="range-slider-input" type="range" name="max_price" min="{{$minPriceProduct}}" max="{{$maxPriceProduct}}"
                                                    id="range-slider-max" step="1" value="{{$maxPriceProduct}}" readonly>
                                                <div class="range-slider-display"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header tags-header"><button class="accordion-button"><span>Vận chuyển & Giao hàng</span><span></span></button></h2>
                                    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSeven">
                                        <div class="accordion-body">
                                            <ul class="widget-card">
                                                <li><i class="iconsax" data-icon="truck-fast"></i>
                                                    <div>
                                                        <h6>Miễn phí vận chuyển</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                    </div>
                                                </li>
                                                <li><i class="iconsax" data-icon="headphones"></i>
                                                    <div>
                                                        <h6>Hỗ trợ 24/7</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                    </div>
                                                </li>
                                                <li><i class="iconsax" data-icon="exchange"></i>
                                                    <div>
                                                        <h6>30 ngày hoàn trả</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="sticky">
                        <div class="top-filter-menu">
                            <div>
                                <a class="filter-button btn">
                                    <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                                </a>
                                <div class="category-dropdown">
                                    <label for="cars">Sắp xếp :</label>
                                    <select class="form-select" id="cars" name="carlist">
                                        <option value="">Sản phẩm bán chạy</option>
                                        <option value="">Phổ biến</option>
                                        <option value="">Nổi bật</option>
                                        <option value="">Theo thứ tự chữ cái, Z-A</option>
                                        <option value="">Giá Cao - Thấp</option>
                                        <option value="">% Giảm giá - Cao xuống Thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="product-tab-content ratio1_3">
                            <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4">
                                <!-- Sản phẩm sẽ được hiển thị ở đây -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user/filterProduct.js') }}"></script>
@endsection
