    <!-- Footer -->
    <footer class="footer-layout-img">
        <section class="section-b-space footer-1">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-content">
                            <div class="footer-logo"><a href="{{route('/')}}"> <img class="img-fluid"
                                        src="{{ asset('assets/images/logo/logo-Bee-white.png') }}" alt="Footer Logo"></a>
                            </div>
                            <ul>
                                <li>
                                    <i class="iconsax" data-icon="location"></i>
                                    <h6>1418 Riverwood Drive, Suite 3245 Cottonwood, CA 96052, United States</h6>
                                </li>
                                <li>
                                    <i class="iconsax" data-icon="phone-calling"></i>
                                    <h6>+ 185659635</h6>
                                </li>
                                <li>
                                    <i class="iconsax" data-icon="mail"></i>
                                    <h6>contact@katie.com</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col offset-xl-1">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>About Us</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="{{route('/')}}">Home</a></li>
                                        <li> <a class="nav" href="#">Shop</a></li>
                                        <li> <a class="nav" href="#">About Us</a></li>
                                        <li> <a class="nav" href="#">Blog</a></li>
                                        <li> <a class="nav" href="#">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>New Categories</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">Latest Shoes</a></li>
                                        <li> <a class="nav" href="#">Branded Jeans</a></li>
                                        <li> <a class="nav" href="#">New Jackets</a></li>
                                        <li> <a class="nav" href="#">Colorful Hoodies</a></li>
                                        <li> <a class="nav" href="#">Best Perfume</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Get Help</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">Your Orders</a></li>
                                        <li> <a class="nav" href="#">Your Account</a></li>
                                        <li> <a class="nav" href="#">Track Orders</a></li>
                                        <li> <a class="nav" href="#">Your Wishlist</a></li>
                                        <li> <a class="nav" href="#">Shopping FAQs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>My Account</h5>
                                    <ul class="footer-details accordion-hidden">
                                        <li> <a class="nav" href="#">My Account</a></li>
                                        <li> <a class="nav" href="#">Login/Register</a></li>
                                        <li> <a class="nav" href="#">Cart</a></li>
                                        <li> <a class="nav" href="#">Order History</a></li>
                                        <li> <a class="nav" href="#">Shopping FAQs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="sub-footer">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="footer-end">
                            <h6>2024 Copyright By Themeforest Powered By Pixelstrap </h6>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="payment-card-bottom">
                            <ul>
                                <li> <img src="{{ asset('assets/images/footer/discover.png') }}" alt="">
                                </li>
                                <li> <img src="{{ asset('assets/images/footer/american.png') }}" alt="">
                                </li>
                                <li> <img src="{{ asset('assets/images/footer/master.png') }}" alt=""></li>
                                <li> <img src="{{ asset('assets/images/footer/giro.png') }}" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer -->

    {{-- Modal logout --}}
    <div class="modal theme-modal fade confirmation-modal" id="modal-logout" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid" src="{{ asset('assets/images/gif/question.gif') }}"
                        alt="">
                    <h4>Confirmation</h4>
                    <p>Are you sure you want to proceed?</p>
                    <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal"
                            aria-label="Close">No</button><a class="btn" href="{{ route('logout') }}">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End logout --}}

    <!-- Modal cart right -->
    {{-- <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
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
    </div> --}}
    <!-- End modal cart right -->

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
                                    <div class="conten-popup">
                                        {{-- <a href="#"><img class="img-fluid blur-up lazyload pro-img"
                                                src="{{ asset('assets/images/modal/0.jpg') }}" alt=""></a> --}}
                                        <div class="add-card-content align-self-center text-center">
                                            <a href="#">
                                                <h6><i class="fa-solid fa-check"> </i>The product has been successfully added to your shopping cart
                                                </h6>
                                            </a>
                                            <div class="buttons">
                                                <a class="view-cart btn btn-solid" href="{{route('cart')}}">Your cart</a>
                                                {{-- <a class="checkout btn btn-solid" href="check-out.html">Check out</a> --}}
                                                <a class="continue btn btn-solid" href="{{route('/')}}">Continue shopping</a>
                                            </div>
                                            <div class="upsell_payment"><img class="img-fluid blur-up lazyload"
                                                    src="{{ asset('assets/images/payment_cart.png') }}"
                                                    alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="product-upsell">
                                    <h5>Products Loved by Our Customers</h5>
                                    <svg>
                                        <use
                                            href="#">
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
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal add cart -->

    <!-- Modal Seach -->
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
                    <li> <a href="product-select.html"><i class="iconsax" data-icon="search-normal-2"></i>Dresses</a>
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
