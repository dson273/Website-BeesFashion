@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Dashboard</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="{{route('/')}}">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Dashboard</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container user-dashboard-section">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="left-dashboard-show"><button class="btn btn_black sm rounded bg-primary">Show
                                Menu</button></div>
                        <div class="dashboard-left-sidebar sticky">
                            <div class="profile-box">
                                <div class="profile-bg-img"></div>
                                <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
                                <div class="profile-contain">
                                    <div class="profile-image"> <img class="img-fluid" src="{{asset('assets/images/user/user-icon.jpg')}}" alt=""></div>
                                    {{-- Profile --}}
                                    <div class="profile-name">
                                        <h4>{{ Auth::user()->username }}</h4>
                                        <h6>{{ Auth::user()->email }}</h6>
                                        <span data-bs-toggle="modal" data-bs-target="#edit-profile" title="Edit Profile" tabindex="0">Edit Profile</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <li><button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" data-bs-target="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true"><i
                                            class="iconsax" data-icon="home-1"></i>
                                        Dashboard</button>
                                </li>
                                <li><button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications" role="tab" aria-controls="notifications"
                                        aria-selected="false"><i class="iconsax" data-icon="lamp-2"></i>Notifications
                                    </button></li>
                                <li><button class="nav-link" id="order-tab" data-bs-toggle="pill" data-bs-target="#order" role="tab" aria-controls="order" aria-selected="false"><i class="iconsax"
                                            data-icon="receipt-square"></i>
                                        Order</button></li>
                                <li><button class="nav-link" id="wishlist-tab" data-bs-toggle="pill" data-bs-target="#wishlist" role="tab" aria-controls="wishlist" aria-selected="false"> <i
                                            class="iconsax" data-icon="heart"></i>Wishlist
                                    </button>
                                </li>
                                <li><button class="nav-link" id="saved-card-tab" data-bs-toggle="pill" data-bs-target="#saved-card" role="tab" aria-controls="saved-card" aria-selected="false"> <i
                                            class="iconsax" data-icon="bank-card"></i>Saved
                                        Card</button></li>
                                <li><button class="nav-link" id="address-tab" data-bs-toggle="pill" data-bs-target="#address" role="tab" aria-controls="address" aria-selected="false"><i
                                            class="iconsax" data-icon="cue-cards"></i>Address</button>
                                </li>
                                <li><button class="nav-link" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" role="tab" aria-controls="privacy" aria-selected="false">
                                        <i class="iconsax" data-icon="security-user"></i>Privacy</button></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            {{-- Dashboard --}}
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="dashboard-right-box">
                                    <div class="my-dashboard-tab">
                                        <div class="dashboard-items"> </div>
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>My Dashboard</h4>
                                        </div>
                                        <div class="dashboard-user-name">
                                            <h6>Hello,
                                                <b>{{ Auth::user()->full_name ? Auth::user()->full_name : Auth::user()->username }}</b>
                                            </h6>
                                            <p>My dashboard provides a comprehensive overview of key metrics and data
                                                relevant to your operations. It offers real-time insights into
                                                performance,
                                                including sales figures, website traffic, customer engagement, and more.
                                                With customizable widgets and intuitive visualizations, it facilitates
                                                quick
                                                decision-making and allows you to track progress towards your goals
                                                effectively.</p>
                                        </div>
                                        <div class="total-box">
                                            <div class="row gy-4">
                                                <div class="col-xl-4">
                                                    <div class="totle-contain">
                                                        <div class="wallet-point"><img src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/wallet.svg" alt=""><img class="img-1"
                                                                src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/wallet.svg" alt=""></div>
                                                        <div class="totle-detail">
                                                            <h6>Balance</h6>
                                                            <h4>$ 84.40 </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="totle-contain">
                                                        <div class="wallet-point"><img src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/coin.svg" alt=""><img class="img-1"
                                                                src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/coin.svg" alt=""></div>
                                                        <div class="totle-detail">
                                                            <h6>Total Points</h6>
                                                            <h4>500</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="totle-contain">
                                                        <div class="wallet-point"><img src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/order.svg" alt=""><img class="img-1"
                                                                src="https://themes.pixelstrap.net/katie/assets/images/svg-icon/order.svg" alt=""></div>
                                                        <div class="totle-detail">
                                                            <h6>Total Orders</h6>
                                                            <h4>12</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile-about">
                                            <div class="row">
                                                <div class="col-xl-7">
                                                    <div class="sidebar-title">
                                                        <div class="loader-line"></div>
                                                        <h5>Profile Information</h5>
                                                    </div>
                                                    <ul class="profile-information">
                                                        <li>
                                                            <h6>Username:</h6>
                                                            <p>{{ Auth::user()->username }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <h6>Name:</h6>
                                                            <p>{{ Auth::user()->full_name ? Auth::user()->full_name : 'Not updated yet' }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <h6>Phone:</h6>
                                                            <p>{{ Auth::user()->phone ? Auth::user()->phone : 'Not updated yet' }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                    <div class="sidebar-title">
                                                        <div class="loader-line"></div>
                                                        <h5>Login Details</h5>
                                                    </div>
                                                    <ul class="profile-information mb-0">
                                                        <li>
                                                            <h6>Email :</h6>
                                                            <p>{{ Auth::user()->email }}</p>
                                                        </li>
                                                        <li>
                                                            <h6>Password :</h6>
                                                            <p>●●●●●●<span data-bs-toggle="modal" data-bs-target="#edit-password" title="Edit Password" tabindex="0">Edit</span></p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-5">
                                                    <div class="profile-image d-none d-xl-block"> <img class="img-fluid" src="{{ asset('assets/images/other-img/dashboard.png') }}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End dashboard --}}

                            {{-- Notifications --}}
                            <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                                <div class="dashboard-right-box">
                                    <div class="notification-tab">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>Notifications</h4>
                                        </div>
                                        <ul class="notification-body">
                                            <li>
                                                <div class="user-img"> <img src="../assets/images/notification/1.jpg" alt=""></div>
                                                <div class="user-contant">
                                                    <h6>Mint - is your budget ready for spring
                                                        spending?<span>2:14PM</span>
                                                    </h6>
                                                    <p>A quick weekend trip, a staycation in your own town, or a
                                                        weeklong
                                                        vacay with the family—it’s your choice if it’s in the budget. No
                                                        matter what you plan on doing during spring break, budget ahead
                                                        for
                                                        it.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img"> <img src="../assets/images/notification/2.jpg" alt=""></div>
                                                <div class="user-contant">
                                                    <h6>Flipkart - Confirmed order<span>2:14PM</span></h6>
                                                    <p>Thanks for signing up for CodePen! We're happy you're here. Let's
                                                        get
                                                        your email address verified:</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- End notifications --}}

                            {{-- Whishlist --}}
                            <div class="tab-pane fade" id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab">
                                <div class="dashboard-right-box">
                                    <div class="wishlist-box ratio1_3">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>Wishlist</h4>
                                        </div>
                                        <div class="row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                                            <div class="col">
                                                <div class="product-box-3 product-wishlist">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><a class="label-2 wishlist-icon delete-button" href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                                    class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                                        <div class="product-image"><a class="pro-first" href="product.html">
                                                                <img class="bg-img" src="../assets/images/product/product-3/11.jpg" alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                                    class="bg-img" src="../assets/images/product/product-3/14.jpg" alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                                    class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a href="compare.html" title="Compare" tabindex="0"><i
                                                                    class="iconsax" data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" title="Quick View" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a></div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <ul class="rating">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li>4.3</li>
                                                        </ul><a href="product.html">
                                                            <h6>Long Sleeve Rounded T-Shirt</h6>
                                                        </a>
                                                        <p>$120.30 <del>$140.00</del><span>-20% </span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="product-box-3 product-wishlist">
                                                    <div class="img-wrapper">
                                                        <div class="label-block"><a class="label-2 wishlist-icon delete-button" href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                                    class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                                        <div class="product-image"><a class="pro-first" href="product.html">
                                                                <img class="bg-img" src="../assets/images/product/product-3/12.jpg" alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                                    class="bg-img" src="../assets/images/product/product-3/13.jpg" alt="product"></a></div>
                                                        <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                                    class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a href="compare.html" title="Compare" tabindex="0"><i
                                                                    class="iconsax" data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" title="Quick View" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a></div>
                                                        <div class="countdown">
                                                            <ul class="clockdiv4">
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="days"></div>
                                                                    </div><span class="title">Days</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="hours"></div>
                                                                    </div><span class="title">Hours</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="minutes"></div>
                                                                    </div><span class="title">Min</span>
                                                                </li>
                                                                <li class="dot"> <span>:</span></li>
                                                                <li>
                                                                    <div class="timer">
                                                                        <div class="seconds"></div>
                                                                    </div><span class="title">Sec</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <ul class="rating">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                            <li>4.3</li>
                                                        </ul><a href="product.html">
                                                            <h6>Blue lined White T-Shirt</h6>
                                                        </a>
                                                        <p>$190.00 <del>$210.00</del></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End whishlist --}}

                            {{-- Order --}}
                            <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                                <div class="dashboard-right-box">
                                    <div class="order">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>My Orders History</h4>
                                        </div>
                                        <div class="row gy-4">
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div class="order-container">
                                                        <div class="order-icon"><i class="iconsax" data-icon="box"></i>
                                                            <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>Delivered</h5>
                                                            <p>on Fri, 1 Mar</p>
                                                        </div>
                                                    </div>
                                                    <div class="product-order-detail">
                                                        <div class="product-box"> <a href="product.html"> <img src="../assets/images/notification/1.jpg" alt=""></a>
                                                            <div class="order-wrap">
                                                                <h5>Rustic Minidress with Halterneck</h5>
                                                                <p>Versatile sporty slogans short sleeve quirky laid
                                                                    back
                                                                    orange lux hoodies vests pins badges.</p>
                                                                <ul>
                                                                    <li>
                                                                        <p>Prize : </p><span>$20.00</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Size : </p><span>M</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Order Id :</p><span>ghat56han50</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-box">
                                                        <div class="review-box">
                                                            <ul class="rating">
                                                                <li> <i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i
                                                                        class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i></li>
                                                            </ul><span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Write Review</span>
                                                        </div>
                                                        <h6> <span> </span>* Exchange/Return window closed on 20 mar
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div class="order-container">
                                                        <div class="order-icon"><i class="iconsax" data-icon="undo"></i>
                                                            <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>Refund Credited</h5>
                                                            <p> Your Refund Of <b> $389.00 </b>For then return has been
                                                                processed Successfully on 4th Apr.<a href="#"> View
                                                                    Refund
                                                                    details</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="product-order-detail">
                                                        <div class="product-box"> <a href="product.html"> <img src="../assets/images/notification/9.jpg" alt=""></a>
                                                            <div class="order-wrap">
                                                                <h5>Rustic Minidress with Halterneck</h5>
                                                                <p>Versatile sporty slogans short sleeve quirky laid
                                                                    back
                                                                    orange lux hoodies vests pins badges.</p>
                                                                <ul>
                                                                    <li>
                                                                        <p>Prize : </p><span>$20.00</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Size : </p><span>M</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Order Id :</p><span>ghat56han50</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-box">
                                                        <div class="review-box">
                                                            <ul class="rating">
                                                                <li> <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                                        class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></li>
                                                            </ul>
                                                        </div>
                                                        <h6> * Exchange/Return window closed on 20 mar</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div class="order-container">
                                                        <div class="order-icon"><i class="iconsax" data-icon="box"></i>
                                                            <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>Delivered</h5>
                                                            <p>on Fri, 1 Mar</p>
                                                        </div>
                                                    </div>
                                                    <div class="product-order-detail">
                                                        <div class="product-box"> <a href="product.html"> <img src="../assets/images/notification/2.jpg" alt=""></a>
                                                            <div class="order-wrap">
                                                                <h5>Rustic Minidress with Halterneck</h5>
                                                                <p>Versatile sporty slogans short sleeve quirky laid
                                                                    back
                                                                    orange lux hoodies vests pins badges.</p>
                                                                <ul>
                                                                    <li>
                                                                        <p>Prize : </p><span>$20.00</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Size : </p><span>M</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Order Id :</p><span>ghat56han50</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-box">
                                                        <div class="review-box">
                                                            <ul class="rating">
                                                                <li> <i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i
                                                                        class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i></li>
                                                            </ul><span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Write Review</span>
                                                        </div>
                                                        <h6> * Exchange/Return window closed on 20 mar</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div class="order-container">
                                                        <div class="order-icon"><i class="iconsax" data-icon="box-add"></i>
                                                            <div class="couplet"><i class="fa-solid fa-xmark"></i></div>
                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>Cancelled</h5>
                                                            <p>on Fri, 1 Mar</p>
                                                            <h6> <b>Refund lanitiated : </b>$774.00 on Thu, 24 Feb 2024.
                                                                <a href="#"> View Refunddetails</a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="product-order-detail">
                                                        <div class="product-box"> <a href="product.html"> <img src="../assets/images/notification/6.jpg" alt=""></a>
                                                            <div class="order-wrap">
                                                                <h5>Rustic Minidress with Halterneck</h5>
                                                                <p>Versatile sporty slogans short sleeve quirky laid
                                                                    back
                                                                    orange lux hoodies vests pins badges.</p>
                                                                <ul>
                                                                    <li>
                                                                        <p>Prize : </p><span>$20.00</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Size : </p><span>M</span>
                                                                    </li>
                                                                    <li>
                                                                        <p>Order Id :</p><span>ghat56han50</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="return-box">
                                                        <div class="review-box">
                                                            <ul class="rating">
                                                                <li> <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                                        class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></li>
                                                            </ul>
                                                        </div>
                                                        <h6> * Exchange/Return window closed on 20 mar</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Order --}}

                            {{-- Save card --}}
                            <div class="tab-pane fade" id="saved-card" role="tabpanel" aria-labelledby="saved-card-tab">
                                <div class="dashboard-right-box">
                                    <div class="saved-card">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>My Card Details</h4>
                                        </div>
                                        <div class="payment-section">
                                            <div class="row gy-3">
                                                <div class="col-xxl-4 col-md-6">
                                                    <div class="payment-card">
                                                        <div class="bank-info"><img class="bank" src="../assets/images/bank-card/bank1.png" alt="bank1">
                                                            <div class="card-type"><img class="bank-card" src="../assets/images/bank-card/1.png" alt="card">
                                                            </div>
                                                        </div>
                                                        <div class="card-details"><span>Card Number</span>
                                                            <h5>6458 50XX XXXX 0851</h5>
                                                        </div>
                                                        <div class="card-details-wrap">
                                                            <div class="card-details"><span>Name On Card</span>
                                                                <h5>Josephin water</h5>
                                                            </div>
                                                            <div class="text-center card-details"><span>Validity</span>
                                                                <h5>XX/XX</h5>
                                                            </div>
                                                            <div class="btn-box"><span data-bs-toggle="modal" data-bs-target="#edit-bank-card" title="Quick View" tabindex="0"><i class="iconsax"
                                                                        data-icon="edit-1"></i></span><span data-bs-toggle="modal" data-bs-target="#bank-card-modal" title="Quick View"
                                                                    tabindex="0"><i class="iconsax" data-icon="trash"></i></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-6">
                                                    <div class="payment-card">
                                                        <div class="add-card">
                                                            <h6 data-bs-toggle="modal" data-bs-target="#add-bank-card" title="Quick View" tabindex="0">+ Add Card</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End save card --}}

                            {{-- Address --}}
                            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                <div class="dashboard-right-box">
                                    <div class="address-tab">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>My Address Details</h4>
                                        </div>
                                        <div class="row gy-3">
                                            @if (Auth::user()->user_shipping_addresses && Auth::user()->user_shipping_addresses->count() > 0)
                                                @foreach (Auth::user()->user_shipping_addresses as $shippingAddress)
                                                    <div class="col-xxl-12 col-md-6">
                                                        <div class="address-option">
                                                            <label for="address-billing-0">
                                                                <div class="delivery-address-box d-flex" data-id="{{ $shippingAddress->id }}">
                                                                    <div class="address-detail">
                                                                        {{-- <span class="address">
                                                                        <span class="address-title">Home</span>
                                                                    </span> --}}
                                                                        <span class="address">
                                                                            <span class="address-home d-flex">
                                                                                <span class="address-title">{{ $shippingAddress->full_name }}</span>
                                                                                @if ($shippingAddress->is_active)
                                                                                    <span class="ms-3 mt-1">
                                                                                        <span class="custom-status-set-address">Default</span>
                                                                                    </span>
                                                                                @endif
                                                                            </span>
                                                                        </span>
                                                                        <span class="address">
                                                                            <span class="address-home d-flex">
                                                                                <span class="address-tag-office">Address:</span>
                                                                                <p>{{ $shippingAddress->address }}</p>
                                                                            </span>
                                                                        </span>
                                                                        <span class="address"><span class="address-home d-flex">
                                                                                <span class="address-tag-office">Phone:</span>
                                                                                <p>{{ $shippingAddress->phone_number }}</p>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <div class="address-action">
                                                                        <div>
                                                                            <a class="btn_edit_address" href="#" data-id="{{ $shippingAddress->id }}"
                                                                                data-full_name="{{ $shippingAddress->full_name }}" data-phone_number="{{ $shippingAddress->phone_number }}"
                                                                                data-address="{{ $shippingAddress->address }}" data-bs-toggle="modal" data-bs-target="#edit-address"
                                                                                title="Edit Address" tabindex="0">Edit</a>
                                                                        </div>
                                                                        <div>
                                                                            <a class="btn_delete_address" href="#"title="Delete" tabindex="0"
                                                                                onclick="event.preventDefault();document.getElementById('delete-address-form').action='{{ route('dashboard.deleteAddress', $shippingAddress->id) }}';$('#delete-address-modal').modal('show');">Delete</a>
                                                                        </div>
                                                                        <div>
                                                                            @if (!$shippingAddress->is_active)
                                                                                <span class="">
                                                                                    <form action="{{ route('dashboard.addresses.set.default', $shippingAddress->id) }}" method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        <button type="submit" class="custom-set-address">Set as default</button>
                                                                                    </form>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center">
                                                    <div class="col-xxl-12 col-md-6">
                                                        <div class="address-option">
                                                            <label for="address-billing-0">
                                                                <h4 class="mt-2">Bạn chưa thêm địa chỉ</h4>
                                                                <div>
                                                                    <img class="img-fluid" src="{{ asset('assets/images/user/empty-cart.jpg') }}" width="250">
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn add-address" data-bs-toggle="modal" data-bs-target="#add-address" title="Quick View" tabindex="0">+ Add
                                            Address</button>
                                    </div>
                                </div>
                            </div>
                            {{-- End address --}}

                            {{-- Privacy --}}
                            <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                                <div class="dashboard-right-box">
                                    <div class="privacy-tab">
                                        <div class="sidebar-title">
                                            <div class="loader-line"></div>
                                            <h4>Privacy</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="privacy-title">
                                                    <h5>Allows others to see my profile</h5>
                                                    <p>Choose who can access your app and if users need to <a href="sign-up.html"> sign up.</a></p>
                                                </div><span class="short-title">access</span>
                                                <ul class="privacy-items">
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="lock-2"></i></div>
                                                        <div class="privacy-contant">
                                                            <h6>Private</h6>
                                                            <p>Only users you choose can access</p>
                                                        </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                    </li>
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="globe"></i>
                                                        </div>
                                                        <div class="privacy-contant">
                                                            <h6>Public</h6>
                                                            <p>Anyone with the link can</p>
                                                        </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                    </li>
                                                </ul><span class="short-title">Users</span>
                                                <ul class="privacy-items">
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="package"></i></div>
                                                        <div class="privacy-contant">
                                                            <h6>Users in the users table </h6>
                                                            <p>Only users in the users table can sign in </p>
                                                        </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                    </li>
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="fingerprint-circle"></i></div>
                                                        <div class="privacy-contant">
                                                            <h6>ongoing production team </h6>
                                                            <p>only members of your team can sign in </p>
                                                        </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                    </li>
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="add-layer"></i></div>
                                                        <div class="privacy-contant">
                                                            <h6>anyone form domain(s)</h6>
                                                            <p>only users with your email domain </p>
                                                        </div><label class="switch"><input type="checkbox" checked=""><span class="slider round"></span></label>
                                                    </li>
                                                    <li>
                                                        <div class="privacy-icon"> <i class="iconsax" data-icon="mail"></i>
                                                        </div>
                                                        <div class="privacy-contant">
                                                            <h6>any email in table </h6>
                                                            <p>Anyone with email included in a table </p>
                                                        </div><label class="switch"><input type="checkbox"><span class="slider round"></span></label>
                                                    </li>
                                                </ul><span class="short-title"> </span>
                                                <ul class="privacy-items">
                                                    <li>
                                                        <div class="privacy-contant">
                                                            <h6>Publishing </h6>
                                                            <p>Your Project is Published</p>
                                                        </div>
                                                        <div class="publish-button"> <button class="btn">Unpublish</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Privacy --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Modal edit profile --}}
        <div class="reviews-modal modal theme-modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Edit Profile</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="edit-profile-form" class="row g-3" action="{{ route('dashboard.editProfile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input id="full_name" class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ Auth::user()->full_name }}"
                                        placeholder="Enter your full name.">
                                    <div class="invalid-feedback">
                                        @error('full_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror" type="number" name="phone" value="{{ Auth::user()->phone }}"
                                        placeholder="Enter your phone.">
                                    <div class="invalid-feedback">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ Auth::user()->email }}"
                                        placeholder="Enter your email.">
                                    <div class="invalid-feedback">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal Edit address --}}
        <div class="reviews-modal modal theme-modal fade" id="edit-address" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Edit Address</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="edit-address-form" class="row g-3" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" placeholder="Enter your name."
                                        value="{{ old('full_name') }}">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control @error('phone_number') is-invalid @enderror" type="number" name="phone_number" placeholder="Enter your Number."
                                        value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2" placeholder="Write your Address..." name="address" value="{{ old('address') }}"></textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal Add address --}}
        <div class="reviews-modal modal theme-modal fade" id="add-address" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Add Address</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="add-address-form" class="row g-3" action="{{ route('dashboard.addAddress') }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" placeholder="Enter your name."
                                        value="{{ old('full_name') }}">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control @error('phone_number') is-invalid @enderror" type="number" name="phone_number" placeholder="Enter your Number."
                                        value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" cols="30" rows="2" placeholder="Write your Address..." name="address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal edit pass --}}
        <div class="reviews-modal modal theme-modal fade" id="edit-password" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Edit Password</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="edit-password-form" action="{{ route('dashboard.editPassword') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="from-group">
                                        <label class="form-label">Current Password</label>
                                        <input class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" id="current_password"
                                            placeholder="Enter Current Password.">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="from-group">
                                        <label class="form-label">New password</label>
                                        <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new_password" name="new_password"
                                            placeholder="Enter New password.">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="from-group">
                                        <label class="form-label">Confirm password</label>
                                        <input class="form-control @error('new_password_confirmation') is-invalid @enderror" type="password" name="new_password_confirmation"
                                            id="new_password_confirmation" placeholder="Enter Confirm password">
                                        @error('new_password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div><button class="btn btn-submit" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal delete address --}}
        <div class="modal theme-modal fade confirmation-modal" id="delete-address-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                        <h4>Are You Sure ?</h4>
                        <p>The address will be permanently deleted. Are you sure you want to do this?</p>
                        <div class="submit-button">
                            <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <form id="delete-address-form" action="" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal bank-card --}}
        <div class="modal theme-modal fade confirmation-modal" id="bank-card-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"> <img class="img-fluid" src="../assets/images/gif/question.gif" alt="">
                        <h4>Are You Sure ?</h4>
                        <p>The object will establish a new permission for this object, inheriting the permission for the
                            use/group, preview.</p>
                        <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">No</button><button class="btn" type="submit"
                                data-bs-dismiss="modal" aria-label="Close">Yes</button></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal --}}

        {{-- Modal review --}}
        <div class="reviews-modal modal theme-modal fade" id="Reviews-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Write A Review</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/notification/1.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00</del></p>
                                            <ul class="rating p-0 mb">
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-regular fa-star"> </i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label">Name</label><input class="form-control" type="text" name="review[author]" placeholder="Enter your name.">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label" for="exampleInputEmail1">Email
                                        address</label><input class="form-control" id="exampleInputEmail1" type="email" placeholder="john.smith@example.com"></div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Review Title</label><input class="form-control" type="text" name="review[author]" placeholder="Look great">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Review Content</label>
                                    <textarea class="form-control" cols="30" rows="5" placeholder="Write your comments here..."></textarea>
                                </div>
                            </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal edit bank --}}
        <div class="reviews-modal modal theme-modal fade" id="edit-bank-card" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Edit Card</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Card Holder Name</label><input class="form-control" type="text" name="name" value="Josephin water">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Card Number</label><input class="form-control" type="number" name="name" value="6458502535450851">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label">Expiry Date</label><input class="form-control" type="date" name="date"></div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label">Cv</label><input class="form-control" type="number" name="cv" value="456"></div>
                            </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal add bank --}}
        <div class="reviews-modal modal theme-modal fade" id="add-bank-card" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Add Bank Card</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Card Holder Name</label><input class="form-control" type="text" name="name" placeholder="Josephin water..">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Card Number</label><input class="form-control" type="number" name="name" placeholder="645850253545XXXX..">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label">Expiry Date</label><input class="form-control" type="date" name="date"></div>
                            </div>
                            <div class="col-6">
                                <div class="from-group"> <label class="form-label">Cv</label><input class="form-control" type="number" name="cv" placeholder="456"></div>
                            </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- End container content -->
@endsection

@section('script-libs')
    <script src="{{ asset('js/user/dashboard.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy tất cả các tab
            const tabs = document.querySelectorAll('#v-pills-tab button');
            // Lấy tab hiện tại từ URL nếu có
            const currentTab = new URLSearchParams(window.location.search).get('tab');
            if (currentTab) {
                const activeTab = document.querySelector(`[data-bs-target="#${currentTab}"]`);
                if (activeTab) {
                    // Bỏ 'active' khỏi tất cả các tab và kích hoạt tab hiện tại
                    tabs.forEach(tab => tab.classList.remove('active'));
                    activeTab.classList.add('active');
                    const tabContent = document.querySelector(`#${currentTab}`);
                    if (tabContent) {
                        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show',
                            'active'));
                        tabContent.classList.add('show', 'active');
                    }
                }
            }
            // Thêm sự kiện cho mỗi tab để cập nhật URL khi nhấp
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const target = this.getAttribute("data-bs-target").substring(
                        1); // Lấy id của tab
                    const url = new URL(window.location);
                    url.searchParams.set("tab", target);
                    window.history.replaceState(null, "", url); // Cập nhật URL
                });
            });
        });
    </script>
@endsection
