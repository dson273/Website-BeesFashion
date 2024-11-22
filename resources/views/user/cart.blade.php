@extends('user.layouts.master')

@section('script-libs')
<script src="{{asset('js/user/cart_chinh.js')}}"></script>
@endsection

@section('content')
<!-- Container content -->
<main>
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Cart</h4>
                    </div>
                    {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Cart</a></li>
                            </ul>
                        </div> --}}
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row g-4">
                @if (count($cart_list) > 0)
                <div class="col-12">
                    <div class="cart-countdown"><img src="../assets/images/gif/fire-2.gif" alt="">
                        <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart.
                            We'll keep it for you for<span id="countdown"></span>minutes.</h6>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8">
                    <div class="cart-table">
                        <div class="table-title">
                            <h5>Cart <span id="cartTitle">({{ count($cart_list) }} item)</span></h5><button class="btn-clear" id="clearAllButton">Clear All</button>
                        </div>
                        <div class="table-responsive theme-scrollbar">
                            <table class="table" id="cart-table">
                                <thead>
                                    <tr>
                                        <th>Product </th>
                                        <th>Price </th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart_list as $item_cart)
                                    <tr class="product_item" data-cart-id="{{ $item_cart['id_cart'] }}" data-variant-id="{{ $item_cart['variant_id'] }}" data-product-id="{{ $item_cart['product_id'] }}"
                                        data-regular-price="{{ $item_cart['regular_price'] }}" data-sale-price="{{ $item_cart['sale_price'] }}" data-stock="{{ $item_cart['stock'] }}">
                                        <td>
                                            <div class="cart-box">
                                                <a href="{{ route('product.detail', $item_cart['product_id']) }}">
                                                    <img src="{{ asset('uploads/products/images/' . $item_cart['image']) }}" alt="{{ $item_cart['product_name'] }}" class="product-image"></a>
                                                <div class="cart-box-variant">
                                                    <a href="{{ route('product.detail', $item_cart['product_id']) }}">
                                                        <h5 class="text-wrap">{{ $item_cart['product_name'] }}</h5>
                                                    </a>
                                                    <div class="box-edit-variant mb-2 variant-selector">
                                                        <button type="button" id="variantButton" class="variant-button text-start">Chọn phân loại<span class="ms-lg-5"><i
                                                                    class="fa-solid fa-chevron-down"></i></span></button>
                                                    </div>
                                                    <div class="variant-details">
                                                        @foreach ($item_cart['attribute_values'] as $attribute)
                                                        <h6 class="attribute-item">
                                                            {{ $attribute['attribute_name'] }}:
                                                            <span class="attribute-value">{{ $attribute['value_name'] }}</span>
                                                        </h6>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="color: rgba(var(--theme-font-color), 1); font-size: calc(13.4px + .1875vw); font-weight: 500;">
                                                {{ number_format($item_cart['sale_price'] ?? $item_cart['regular_price'], 0, ',', '.') }}đ
                                                @if ($item_cart['sale_price'])
                                                <del class="ms-2" style="color:rgba(var(--light-color), 1); font-weight: normal">
                                                    {{ number_format($item_cart['regular_price'], 0, ',', '.') }}đ
                                                </del>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <div class="quantity">
                                                <button class="quantity-btn minus" type="button"><i class="fa-solid fa-minus"></i></button>
                                                <input class="quantity-input" type="number" value="{{ $item_cart['quantity'] }}" min="1"
                                                    max="{{ $item_cart['stock'] }}">
                                                <button class="quantity-btn plus" type="button"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td class="total-price">
                                            {{ number_format(($item_cart['sale_price'] ?? $item_cart['regular_price']) * $item_cart['quantity'], 0, ',', '.') }}đ
                                        </td>
                                        <td>
                                            <a class="deleteButton" href="javascript:void(0)" style="color: rgba(var(--danger-color), 1)">
                                                <i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="no-data" id="data-show"><img src="../assets/images/cart/1.gif" alt="">
                            <h4>You have nothing in your shopping cart!</h4>
                            <p>Today is a great day to purchase the things you have been holding onto! or
                                <span>Carry on
                                    Buying</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4">
                    <div class="cart-items">
                        <div class="cart-progress">
                            <h6>Price Details <span>({{ count($cart_list) }} Items)</span></h6>
                            {{-- <div class="progress">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 43%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span> <i class="iconsax"
                                                data-icon="truck-fast"></i></span></div>
                                </div>
                                <p>Almost there, add <span>$267.00 </span>more to get <span>FREE Shipping !! </span></p> --}}
                        </div>
                        <div class="cart-body">

                            <ul>
                                <li>
                                    <p>Total price</p>
                                    <span>{{ number_format($total_payment, 0, ',', '.') }}đ</span>
                                </li>
                                @if ($total_discount > 0)
                                <li>
                                    <p>Discount</p><span class="theme-color">-{{ number_format($total_discount, 0, ',', '.') }}đ</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="cart-bottom mb-2">
                            <h6>Subtotal
                                <span>{{ number_format($total_payment - $total_discount, 0, ',', '.') }}đ</span>
                            </h6>
                            <p>Use <span>BeesFashion's</span> discount code in the next step</p>
                        </div>
                        <form id="form_post_data_to_check_out" action="{{route('checkout')}}" method="POST">
                            @csrf
                            @method('GET')
                            <input type="hidden" name="cart_ids" id="input_post_data_to_check_out">
                            <input type="hidden" name="status_cart" id="is_cart">
                        </form>
                        <a class="btn btn_black w-100 rounded sm" id="check_out">Check Out</a>
                    </div>
                </div>
                @else
                <h5 class="text-center">Giỏ hàng của bạn đang trống!</h5>
                <div class="text-center mt-3">
                    <button><a href="{{ route('/') }}">Tiếp tục mua sắm</a></button>
                </div>
                @endif

                <div class="col-12">
                    <div class="cart-slider">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h6>For a trendy and modern twist, especially during transitional seasons.</h6>
                                <p> <img class="me-2" src="../assets/images/gif/discount.gif" alt="">You will get
                                    10%
                                    OFF on each product</p>
                            </div><a class="btn btn_outline sm rounded" href="product-detail.html">View All<svg>
                                    <use href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                    </use>
                                </svg></a>
                        </div>
                        <div class="swiper cart-slider-box">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product-detail.html"> <img src="../assets/images/user/4.jpg" alt=""></a>
                                        <div> <a href="product-detail.html">
                                                <h5>Polo-neck Body Dress</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$19.90 <span> <del>$14.90 </del></span></p><a class="btn" href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product-detail.html"> <img src="../assets/images/user/5.jpg" alt=""></a>
                                        <div> <a href="product-detail.html">
                                                <h5>Short Sleeve Sweater</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$22.90 <span> <del>$24.90 </del></span></p><a class="btn" href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product-detail.html"> <img src="../assets/images/user/6.jpg" alt=""></a>
                                        <div> <a href="product-detail.html">
                                                <h5>Oversized Cotton Short</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$10.90 <span> <del>$18.90 </del></span></p><a class="btn" href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product-detail.html"> <img src="../assets/images/user/7.jpg" alt=""></a>
                                        <div> <a href="product-detail.html">
                                                <h5>Oversized Women Shirt</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$15.90 <span> <del>$20.90 </del></span></p><a class="btn" href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Box Chọn Biến Thể -->
        <div id="variantBox" class="box-variant">
            <div class="variant-container">
                <div class="varianr-content">
                    <label class="form-label">Color: <span>Đen</span></label>
                    <div class="d-flex mb-2 color-options">
                        <input class="btn-color" type="radio" id="color-black" name="color" value="black">
                        <label for="color-black" title="black" class="color-label me-2" style="background-image: url('{{ asset('assets/images/cart/1.jpg') }}');"></label>

                        <input class="btn-color" type="radio" id="color-gray" name="color" value="gray">
                        <label for="color-gray" class="color-label" style="background-image: url('{{ asset('assets/images/cart/2.jpg') }}');"></label>

                    </div>
                    <label class="form-label">Size: <span>S</span></label>
                    <div class="d-flex flex-wrap mb-2 wrap-vra">
                        <button class="btn-variant">S</button>
                        <button class="btn-variant">M</button>
                        <button class="btn-variant">L</button>
                    </div>

                    <label class="form-label">Vải: <span>Lụa</span></label>
                    <div class="d-flex flex-wrap mb-2 wrap-vra">
                        <button class="btn-variant-default">Lụa</button>
                        <button class="btn-variant-default">Tơ</button>
                        <button class="btn-variant-default">Jean</button>
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-between box-variant-bottom">
                    <button type="button" id="backButton" class="btn-back">Trở lại</button>
                    <button type="submit" class="btn-confirm">Xác nhận</button>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- End container content -->
@endsection

@section('script-libs')
<script>
    //Lấy tất cả các nút có class 'btn-variant'
    const variantButtons = document.querySelectorAll('.btn-variant');
    const variantDefault = document.querySelectorAll('.btn-variant-default');
    const variantColors = document.querySelectorAll('.btn-color');

    variantButtons.forEach(button => {
        button.addEventListener('click', () => {
            variantButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });
    variantDefault.forEach(button => {
        button.addEventListener('click', () => {
            variantDefault.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });
    variantColors.forEach(button => {
        button.addEventListener('click', () => {
            variantColors.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const variantButton = document.getElementById("variantButton");
        const variantBox = document.getElementById("variantBox");
        const backButton = document.getElementById("backButton");

        // Hàm hiển thị box dưới nút
        variantButton.addEventListener("click", function(event) {
            event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
            const rect = variantButton.getBoundingClientRect();

            // Cập nhật vị trí của variantBox ngay dưới nút
            variantBox.style.top = `${rect.bottom + window.scrollY}px`;
            variantBox.style.left = `${rect.left + window.scrollX}px`;

            variantBox.classList.toggle("active"); // Hiển thị box
        });

        // Đóng box khi nhấn nút "Trở lại"
        backButton.addEventListener("click", function() {
            variantBox.classList.remove("active");
        });

        // Đóng box khi nhấn ra ngoài
        document.addEventListener("click", function(event) {
            if (!variantBox.contains(event.target) && !variantButton.contains(event.target)) {
                variantBox.classList.remove("active");
            }
        });
    });
</script>
@endsection