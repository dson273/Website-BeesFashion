@extends('user.layouts.master')

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
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Cart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="cart-countdown"><img src="../assets/images/gif/fire-2.gif" alt="">
                            <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart.
                                We'll
                                keep it for you for<span id="countdown"></span>minutes.</h6>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-8">
                        <div class="cart-table">
                            <div class="table-title">
                                <h5>Cart<span id="cartTitle">(3)</span></h5><button id="clearAllButton">Clear
                                    All</button>
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
                                        <tr>
                                            <td>
                                                <div class="cart-box"> <a href="product-detail.html"> <img
                                                            src="../assets/images/cart/category/1.jpg" alt=""></a>
                                                    <div> <a href="product-detail.html">
                                                            <h5>Concrete Jungle Pack</h5>
                                                        </a>
                                                        <p>Sold By: <span>Roger Group </span></p>
                                                        <p>Size: <span>Small</span></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$20.00</td>
                                            <td>
                                                <div class="quantity"><button class="minus" type="button"><i
                                                            class="fa-solid fa-minus"></i></button><input type="number"
                                                        value="1" min="1" max="20"><button class="plus" type="button"><i
                                                            class="fa-solid fa-plus"></i></button></div>
                                            </td>
                                            <td>$195.00</td>
                                            <td><a class="deleteButton" href="javascript:void(0)"><i class="iconsax"
                                                        data-icon="trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="cart-box"> <a href="product-detail.html"> <img
                                                            src="../assets/images/cart/category/2.jpg" alt=""></a>
                                                    <div> <a href="product-detail.html">
                                                            <h5>Mini dress with ruffled straps</h5>
                                                        </a>
                                                        <p>Sold By: <span>luisa Shop</span></p>
                                                        <p>Size: <span>Medium </span></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$20.00</td>
                                            <td>
                                                <div class="quantity"><button class="minus" type="button"><i
                                                            class="fa-solid fa-minus"></i></button><input type="number"
                                                        value="1" min="1" max="20"><button class="plus" type="button"><i
                                                            class="fa-solid fa-plus"></i></button></div>
                                            </td>
                                            <td>$150.00</td>
                                            <td> <a class="deleteButton" href="javascript:void(0)"><i class="iconsax"
                                                        data-icon="trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="cart-box"> <a href="product-detail.html"> <img
                                                            src="../assets/images/cart/category/3.jpg" alt=""></a>
                                                    <div> <a href="product-detail.html">
                                                            <h5>Long Sleeve Asymmetric</h5>
                                                        </a>
                                                        <p>Sold By: <span>Brown Shop</span></p>
                                                        <p>Size: <span>Large </span></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$25.00</td>
                                            <td>
                                                <div class="quantity"><button class="minus" type="button"><i
                                                            class="fa-solid fa-minus"></i></button><input type="number"
                                                        value="1" min="1" max="20"><button class="plus" type="button"><i
                                                            class="fa-solid fa-plus"></i></button></div>
                                            </td>
                                            <td>$120.00</td>
                                            <td> <a class="deleteButton" href="javascript:void(0)"><i class="iconsax"
                                                        data-icon="trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="no-data" id="data-show"><img src="../assets/images/cart/1.gif" alt="">
                                <h4>You have nothing in your shopping cart!</h4>
                                <p>Today is a great day to purchase the things you have been holding onto! or
                                    <span>Carry on
                                        Buying</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4">
                        <div class="cart-items">
                            <div class="cart-progress">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 43%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span> <i
                                                class="iconsax" data-icon="truck-fast"></i></span></div>
                                </div>
                                <p>Almost there, add <span>$267.00 </span>more to get <span>FREE Shipping !! </span></p>
                            </div>
                            <div class="cart-body">
                                <h6>Price Details (3 Items) </h6>
                                <ul>
                                    <li>
                                        <p>Bag total </p><span>$220.00 </span>
                                    </li>
                                    <li>
                                        <p>Bag savings </p><span class="theme-color">-$20.00 </span>
                                    </li>
                                    <li>
                                        <p>Coupon Discount </p><span class="Coupon">Apply Coupon </span>
                                    </li>
                                    <li>
                                        <p>Delivery </p><span>$50.00 </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="cart-bottom">
                                <p><i class="iconsax me-1" data-icon="tag-2"></i>SPECIAL OFFER (-$1.49) </p>
                                <h6>Subtotal <span>$158.41 </span></h6><span>Taxes and shipping calculated at
                                    checkout</span>
                            </div>
                            <div class="coupon-box">
                                <h6>Coupon</h6>
                                <ul>
                                    <li> <span> <input type="text" placeholder="Apply Coupon"><i class="iconsax me-1"
                                                data-icon="tag-2"> </i></span><button class="btn">Apply </button></li>
                                    <li> <span> <a class="theme-color" href="login.html">Login </a>to see best coupon
                                            for
                                            you </span></li>
                                </ul>
                            </div><a class="btn btn_black w-100 rounded sm" href="check-out.html">Check Out</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="cart-slider">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6>For a trendy and modern twist, especially during transitional seasons.</h6>
                                    <p> <img class="me-2" src="../assets/images/gif/discount.gif" alt="">You will get
                                        10%
                                        OFF on each product</p>
                                </div><a class="btn btn_outline sm rounded" href="product-detail.html">View All<svg>
                                        <use
                                            href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#arrow">
                                        </use>
                                    </svg></a>
                            </div>
                            <div class="swiper cart-slider-box">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/4.jpg" alt=""></a>
                                            <div> <a href="product-detail.html">
                                                    <h5>Polo-neck Body Dress</h5>
                                                </a>
                                                <h6>Sold By: <span>Brown Shop</span></h6>
                                                <div class="category-dropdown"><select class="form-select"
                                                        name="carlist">
                                                        <option value="">Best color</option>
                                                        <option value="">White</option>
                                                        <option value="">Black</option>
                                                        <option value="">Green</option>
                                                    </select></div>
                                                <p>$19.90 <span> <del>$14.90 </del></span></p><a class="btn"
                                                    href="#">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/5.jpg" alt=""></a>
                                            <div> <a href="product-detail.html">
                                                    <h5>Short Sleeve Sweater</h5>
                                                </a>
                                                <h6>Sold By: <span>Brown Shop</span></h6>
                                                <div class="category-dropdown"><select class="form-select"
                                                        name="carlist">
                                                        <option value="">Best color</option>
                                                        <option value="">White</option>
                                                        <option value="">Black</option>
                                                        <option value="">Green</option>
                                                    </select></div>
                                                <p>$22.90 <span> <del>$24.90 </del></span></p><a class="btn"
                                                    href="#">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/6.jpg" alt=""></a>
                                            <div> <a href="product-detail.html">
                                                    <h5>Oversized Cotton Short</h5>
                                                </a>
                                                <h6>Sold By: <span>Brown Shop</span></h6>
                                                <div class="category-dropdown"><select class="form-select"
                                                        name="carlist">
                                                        <option value="">Best color</option>
                                                        <option value="">White</option>
                                                        <option value="">Black</option>
                                                        <option value="">Green</option>
                                                    </select></div>
                                                <p>$10.90 <span> <del>$18.90 </del></span></p><a class="btn"
                                                    href="#">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="cart-box"> <a href="product-detail.html"> <img
                                                    src="../assets/images/user/7.jpg" alt=""></a>
                                            <div> <a href="product-detail.html">
                                                    <h5>Oversized Women Shirt</h5>
                                                </a>
                                                <h6>Sold By: <span>Brown Shop</span></h6>
                                                <div class="category-dropdown"><select class="form-select"
                                                        name="carlist">
                                                        <option value="">Best color</option>
                                                        <option value="">White</option>
                                                        <option value="">Black</option>
                                                        <option value="">Green</option>
                                                    </select></div>
                                                <p>$15.90 <span> <del>$20.90 </del></span></p><a class="btn"
                                                    href="#">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal theme-modal fade cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal1">
                        <div class="custom-container container">
                            <div class="row">
                                <div class="col-12 px-0">
                                    <div class="modal-bg addtocart"><button class="btn-close" type="button"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="d-flex"><a href="#"><img class="img-fluid blur-up lazyload pro-img"
                                                    src="../assets/images/modal/0.jpg" alt=""></a>
                                            <div class="add-card-content align-self-center text-center"><a href="#">
                                                    <h6><i class="fa-solid fa-check"> </i>Item <span>men full
                                                            sleeves</span><span> successfully added to your Cart</span>
                                                    </h6>
                                                </a>
                                                <div class="buttons"><a class="view-cart btn btn-solid"
                                                        href="cart.html">Your cart</a><a class="checkout btn btn-solid"
                                                        href="check-out.html">Check out</a><a
                                                        class="continue btn btn-solid" href="index.html">Continue
                                                        shopping</a></div>
                                                <div class="upsell_payment"><img class="img-fluid blur-up lazyload"
                                                        src="../assets/images/payment_cart.png" alt=""></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-upsell">
                                        <h5>Products Loved by Our Customers</h5><svg>
                                            <use
                                                href="https://themes.pixelstrap.net/katie/assets/svg/icon-sprite.svg#main-line">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="../assets/images/modal/1.jpg" alt="user"><a
                                            href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="../assets/images/modal/2.jpg" alt="user"><a
                                            href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="../assets/images/modal/3.jpg" alt="user"><a
                                            href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="../assets/images/modal/4.jpg" alt="user"><a
                                            href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="../assets/images/modal/5.jpg" alt="user"><a
                                            href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="../assets/images/modal/6.jpg" alt="user"><a
                                            href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h4><button class="btn-close"
                    type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body theme-scrollbar">
                <ul class="offcanvas-cart">
                    <li> <a href="#"> <img src="../assets/images/cart/1.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity-previous">2</div>
                                        <div id="quantity-current">3</div>
                                        <div id="quantity-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/2.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total1">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove1">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity1-previous">2</div>
                                        <div id="quantity1-current">3</div>
                                        <div id="quantity1-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add1">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/3.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total2">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove2">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity2-previous">2</div>
                                        <div id="quantity2-current">3</div>
                                        <div id="quantity2-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add2">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/4.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total3">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove3">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity3-previous">2</div>
                                        <div id="quantity3-current">3</div>
                                        <div id="quantity3-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add3">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-footer">
                <p>Spend <span>$ 14.81 </span>more and enjoy <span>FREE SHIPPING!</span></p>
                <div class="footer-range-slider">
                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="46"
                        aria-valuemin="0" aria-valuemax="100">
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
        <div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1"
            aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header"><button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
            <div class="offcanvas-body theme-scrollbar">
                <div class="container">
                    <h3>What are you trying to find?</h3>
                    <div class="search-box"> <input type="search" name="text" placeholder="I'm looking for…"><i
                            class="iconsax" data-icon="search-normal-2"></i></div>
                    <h4>Popular Searches</h4>
                    <ul class="rapid-search">
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Jeans
                                Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Blazer Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Jeans
                                Men</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Blazer Men</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>T-Shirts Men</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Shoes
                                Men</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>T-Shirts Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Bags</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Sneakers Women</a></li>
                        <li> <a href="product-select.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Dresses</a></li>
                    </ul>
                    <h4>You Might Like</h4>
                    <div class="row gy-4 ratio_square-2 preemptive-search">
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product-detail.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/1.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product-detail.html">
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
                                                src="../assets/images/product/product-2/blazers/2.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product-detail.html">
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
                                                src="../assets/images/product/product-2/blazers/3.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product-detail.html">
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
                                                src="../assets/images/product/product-2/blazers/4.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product-detail.html">
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
                                                src="../assets/images/product/product-2/blazers/5.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product-detail.html">
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
                                                src="../assets/images/product/product-2/blazers/6.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail"><a href="product-detail.html">
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
        <div class="theme-btns"><button class="btntheme" id="dark-btn"><i class="fa-regular fa-moon"></i>
                <div class="text">Dark</div>
            </button>
            <!-- <button class="btntheme rtlBtnEl" id="rtl-btn"><i class="fa-solid fa-repeat"></i>
                <div class="rtl">Rtl</div>
            </button> -->
        </div>
    </main>
    <!-- End container content -->
@endsection
