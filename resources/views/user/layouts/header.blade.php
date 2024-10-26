<div class="tap-top">
    <div><i class="fa-solid fa-angle-up"></i></div>
</div>
<!-- <span class="cursor"><span class="cursor-move-inner"><span class="cursor-inner"></span></span><span
        class="cursor-move-outer"><span class="cursor-outer"></span></span>
</span> -->
<!-- Start header -->
<header>
    <div class="top_header">
        <p>Free Coupe Code: Summer Sale On Selected items Use:<span>NEW 26</span><a href="product-select.html">SHOP NOW</a></p>
    </div>
    <div class="box-header">
        <div class="custom-container container header-1">
            <div class="row">
                <!-- Reponsive mobile -->
                <div class="col-12 p-0">
                    <div class="mobile-fix-option">
                        <ul>
                            <li> <a href="{{ route('home-shop') }}"><i class="iconsax" data-icon="home-1"></i>Home</a>
                            </li>
                            <li><a href="search.html"><i class="iconsax" data-icon="search-normal-2"></i>Search</a></li>
                            <li class="shopping-cart"> <a href="cart.html"><i class="iconsax"
                                        data-icon="shopping-cart"></i>Cart</a></li>
                            <li><a href="wishlist.html"><i class="iconsax" data-icon="heart"></i>My Wish</a></li>
                            <li> <a href="dashboard.html"><i class="iconsax" data-icon="user-2"></i>Account</a></li>
                        </ul>
                    </div>

                    <div class="offcanvas offcanvas-start" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="staticBackdropLabel">
                        <div class="offcanvas-header">
                            <h3 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h3>
                            <button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div></div>
                            I will not close if you click outside of me.
                        </div>
                    </div>
                </div>
                <!-- End reponsive mobile -->

                <!-- Dektop -->
                <div class="col-12">
                    <div class="main-menu">
                        <a class="brand-logo" href="{{ route('home-shop') }}"> <img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-4.png') }}" alt="logo"><img
                                class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-white-4.png') }}"
                                alt="logo"></a>
                        <nav id="main-nav">
                            <ul class="nav-menu sm-horizontal theme-scrollbar" id="sm-horizontal">
                                <li class="mobile-back" id="mobile-back">Back<i class="fa-solid fa-angle-right ps-2"
                                        aria-hidden="true"></i></li>
                                <li>
                                    <a class="nav-link" href="{{ route('home-shop') }}">Home</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="product-select.html">Shop</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('home-shop') }}">Product <span> <i
                                                class="fa-solid fa-angle-down"></i></span></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#">Page <span> <i
                                                class="fa-solid fa-angle-down"></i></span></a>
                                    <ul class="nav-submenu">
                                        <li> <a href="search.html">Search</a></li>
                                        <li> <a href="wishlist.html">Wishlist</a></li>
                                        <li> <a href="faq.html">Faq</a></li>
                                        <li> <a href="dashboard.html">My Dashboard <span
                                                    class="badge-sm theme-default">new</span></a></li>
                                        <li> <a href="order-success.html">Order Success</a></li>
                                        <li> <a href="order-tracking.html">Order Tracking</a></li>

                                </li>
                                <li> <a href="check-out.html">Check Out</a></li>
                                <li> <a href="about-us.html">About Us</a></li>
                                <li> <a href="404.html">404 </a></li>
                                <li> <a href="cart.html">cart </a></li>
                                <li> <a href="login.html"> Login <span class="badge-sm danger-color animated">Hot
                                        </span></a></li>
                                <li> <a href="forget-password.html"> Forgot Password </a></li>
                                <li> <a href="sign-up.html"> Sign Up </a></li>
                            </ul>
                            </li>
                            <li>
                                <a class="nav-link" href="blog.html">Blog<span> <i
                                            class="fa-solid fa-angle-down"></i></span></a>
                            </li>
                            <li> <a class="nav-link" href="contact.html">Contact </a></li>
                            </ul>
                        </nav>

                        <div class="sub_header">
                            <div class="toggle-nav" id="toggle-nav"><i
                                    class="fa-solid fa-bars-staggered sidebar-bar"></i>
                            </div>
                            <ul class="justify-content-end">
                                <li> <button href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                        aria-controls="offcanvasTop"><i class="iconsax"
                                            data-icon="search-normal-2"></i></button></li>
                                <li> <a href="wishlist.html"><i class="iconsax" data-icon="heart"></i><span
                                            class="cart_qty_cls">2</span></a></li>
                                @guest
                                    <li class="onhover-div">
                                        <a href="#"><i class="iconsax" data-icon="user-2"></i></a>
                                        <div class="onhover-show-div user">
                                            <ul>
                                                @if (Route::has('login'))
                                                    <li> <a href="{{ route('login') }}">Login </a></li>
                                                @endif
                                                @if (Route::has('register'))
                                                    <li> <a href="{{ route('register') }}">Register</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @else
                                    <li class="onhover-div">
                                        <a href="#"><i class="iconsax" data-icon="user-2"></i></a>
                                        <div class="onhover-show-div user">
                                            <ul>
                                                <li> <a href="{{ route('dashboard') }}">Dashboard </a></li>
                                                <li> <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#Confirmation-modal" title="Quick View"
                                                        tabindex="0">Logout</a></li>
                                            </ul>
                                    </li>
                                @endguest

                                <li class="onhover-div shopping-cart">
                                    <a class="p-0" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <div class="shoping-prize"><i class="iconsax pe-2" data-icon="basket-2"></i>0
                                            items
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End header -->
