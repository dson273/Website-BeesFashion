@extends('user.layouts.master')

@section('content')
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
                            <li class="breadcrumb-item active"> <a href="">Bộ sản phẩm</a></li>
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
                            <div class="search-box">
                                <input type="search" id="search-input" name="text" placeholder="Tìm kiếm sản phẩm..."
                                    onkeyup="filterProducts()">
                                <i class="iconsax" data-icon="search-normal-2"></i>
                            </div>
                            <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                <div class="accordion-body">
                                    <ul class="catagories-side theme-scrollbar">
                                        @foreach ($listCate as $category)
                                            <li style="list-style-type: none; display: flex; align-items: center;">
                                                <div style="margin-left: {{ $category->level * 20 }}px; flex-grow: 1;">
                                                    <input class="custom-checkbox" id="category{{ $category->id }}"
                                                        type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                        data-parent="{{ $category->parent_category_id }}"
                                                        data-id="{{ $category->id }}"
                                                        onchange="toggleChildCategorie({{ $category->id }})">
                                                    <label for="category{{ $category->id }}">{{ $category->name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
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
                                    <label for="cars">Sort By :</label>
                                    <select class="form-select" id="cars" name="carlist">
                                        <option value="">Best selling</option>
                                        <option value="">Popularity</option>
                                        <option value="">Featured</option>
                                        <option value="">Alphabetically, Z-A</option>
                                        <option value="">High - Low Price</option>
                                        <option value="">% Off - High To Low</option>
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
