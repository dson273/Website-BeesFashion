@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Check Out</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Check Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xxl-9 col-lg-8">
                        <div class="left-sidebar-checkout sticky">
                            <div class="address-option">
                                <div class="address-title">
                                    <h4>Shipping Address </h4><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#address-modal" title="add product" tabindex="0">+ Add New
                                        Address</a>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-4"><label for="address-billing-0"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-0" type="radio"
                                                        checked="checked" name="radio"></span><span
                                                    class="address-detail"><span class="address"> <span
                                                            class="address-title">New Home </span></span><span
                                                        class="address"> <span class="address-home"> <span
                                                                class="address-tag"> Address:</span>26, Starts Hollow
                                                            Colony, Denver, Colorado, United States</span></span><span
                                                        class="address"> <span class="address-home"> <span
                                                                class="address-tag">Pin
                                                                Code:</span>80014</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            5551855359</span></span></span></span></label></div>
                                    <div class="col-xxl-4"><label for="address-billing-1"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-1" type="radio"
                                                        name="radio"></span><span class="address-detail"><span
                                                        class="address"> <span class="address-title">Old Home
                                                        </span></span><span class="address"> <span class="address-home">
                                                            <span class="address-tag"> Address:</span>53B, Claire New
                                                            Street, San Jose, California, United
                                                            States</span></span><span class="address"> <span
                                                            class="address-home"> <span class="address-tag">Pin
                                                                Code:</span>94088</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            5551855359</span></span></span></span></label></div>
                                    <div class="col-xxl-4"><label for="address-billing-2"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-2" type="radio"
                                                        name="radio"></span><span class="address-detail"><span
                                                        class="address"> <span class="address-title">IT
                                                            Office</span></span><span class="address"> <span
                                                            class="address-home"> <span class="address-tag">
                                                                Address:</span>101 Maple Drive, Placeholder Town, USA
                                                            44556</span></span><span class="address"> <span
                                                            class="address-home"> <span class="address-tag">Pin
                                                                Code:</span>54786</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            2547896314</span></span></span></span></label></div>
                                </div>
                            </div>
                            <div class="address-option">
                                <div class="address-title">
                                    <h4>Billing Address</h4><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#address-modal" title="add product" tabindex="0">+ Add New
                                        Address</a>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-4"><label for="address-billing-3"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-3" type="radio"
                                                        name="radio"></span><span class="address-detail"><span
                                                        class="address"> <span class="address-title">New Home
                                                        </span></span><span class="address"> <span class="address-home">
                                                            <span class="address-tag"> Address:</span>123 Main Street,
                                                            Anytown, Colorado, United States</span></span><span
                                                        class="address"> <span class="address-home"> <span
                                                                class="address-tag">Pin
                                                                Code:</span>85421</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            7845123658</span></span></span></span></label></div>
                                    <div class="col-xxl-4"><label for="address-billing-4"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-4" type="radio"
                                                        checked="checked" name="radio"></span><span
                                                    class="address-detail"><span class="address"> <span
                                                            class="address-title">Old Home </span></span><span
                                                        class="address"> <span class="address-home"> <span
                                                                class="address-tag"> Address:</span>456 Elm Street,
                                                            Sample
                                                            City, United States</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Pin
                                                                Code:</span>35412</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            9547862134</span></span></span></span></label></div>
                                    <div class="col-xxl-4"><label for="address-billing-6"> <span
                                                class="delivery-address-box"> <span class="form-check"> <input
                                                        class="custom-radio" id="address-billing-6" type="radio"
                                                        name="radio"></span><span class="address-detail"><span
                                                        class="address"> <span class="address-title">IT
                                                            Office</span></span><span class="address"> <span
                                                            class="address-home"> <span class="address-tag">
                                                                Address:</span>101 Maple Drive, Placeholder Town, United
                                                            States</span></span><span class="address"> <span
                                                            class="address-home"> <span class="address-tag">Pin
                                                                Code:</span>57412</span></span><span class="address">
                                                        <span class="address-home"> <span class="address-tag">Phone
                                                                :</span>+1
                                                            87453312145</span></span></span></span></label></div>
                                </div>
                            </div>
                            <div class="payment-options">
                                <h4 class="mb-3">Billing Address</h4>
                                <div class="row gy-3">
                                    <div class="col-sm-6">
                                        <div class="payment-box"><input class="custom-radio me-2" id="cod" type="radio"
                                                checked="checked" name="radio"><label for="cod">Cod</label></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box"><input class="custom-radio me-2" id="stripe"
                                                type="radio" name="radio"><label for="stripe">Stripe</label></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box"><input class="custom-radio me-2" id="paypal"
                                                type="radio" name="radio"><label for="paypal">Paypal</label></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box"><input class="custom-radio me-2" id="mollie"
                                                type="radio" name="radio"><label for="mollie">Mollie</label></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box"><input class="custom-radio me-2" id="razor-pay"
                                                type="radio" name="radio"><label for="razor-pay">Razor Pay</label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4">
                        <div class="right-sidebar-checkout">
                            <h4>Checkout</h4>
                            <div class="cart-listing">
                                <ul>
                                    <li> <img src="../assets/images/other-img/7.jpg" alt="">
                                        <div>
                                            <h6>Printed Long-sleeve Dress</h6><span>Green</span>
                                        </div>
                                        <p>$50.00</p>
                                    </li>
                                    <li> <img src="../assets/images/other-img/6.jpg" alt="">
                                        <div>
                                            <h6>Teddy Bear Coats</h6><span>Black </span>
                                        </div>
                                        <p>$40.00</p>
                                    </li>
                                    <li> <img src="../assets/images/other-img/5.jpg" alt="">
                                        <div>
                                            <h6>Colorful wind Coats</h6><span>white</span>
                                        </div>
                                        <p>$80.00</p>
                                    </li>
                                </ul>
                                <div class="summary-total">
                                    <ul>
                                        <li>
                                            <p>Subtotal</p><span>$220.00 </span>
                                        </li>
                                        <li>
                                            <p>Shipping</p><span>Enter shipping address</span>
                                        </li>
                                        <li>
                                            <p>Tax</p><span>$ 2.54</span>
                                        </li>
                                        <li>
                                            <p>Points</p><span>$ -10.00</span>
                                        </li>
                                        <li>
                                            <p>Wallet Balance</p><span>$ -84.40</span>
                                        </li>
                                    </ul>
                                    <div class="coupon-code"> <input type="text" placeholder="Enter Coupon Code"><button
                                            class="btn">Apply</button></div>
                                </div>
                                <div class="total">
                                    <h6>Total : </h6>
                                    <h6>$ 37.73</h6>
                                </div>
                                <div class="order-button"><a class="btn btn_black sm w-100 rounded" href="#">Place Order
                                    </a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        <div class="modal theme-modal fade address-modal" id="address-modal" tabindex="-1" role="dialog"
            aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Add Address</h4><button class="btn-close" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="address-box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group"><label class="form-label" for="title1">Title</label><input
                                            class="form-control" id="title1" type="text" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label class="form-label" for="address">Address
                                        </label><input class="form-control" id="address" type="text"
                                            placeholder="Enter Address"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="form-label"
                                            for="address">Country</label><select class="form-select" id="cars"
                                            name="cars">
                                            <option value="volvo">Surat</option>
                                            <option value="saab">Ahmadabad</option>
                                            <option value="mercedes">Vadodara</option>
                                            <option value="audi">Vapi</option>
                                        </select></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label"
                                            for="address">State</label><select class="form-select" id="cars"
                                            name="cars">
                                            <option value="volvo">Gujarat</option>
                                            <option value="saab">Karnataka</option>
                                            <option value="mercedes">Madhya Pradesh</option>
                                            <option value="audi">Maharashtra</option>
                                        </select></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="form-label" for="title1">City</label><input
                                            class="form-control" id="title1" type="text" placeholder="Enter City"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="form-label"
                                            for="address">Pincode</label><input class="form-control" id="address"
                                            type="text" placeholder="Enter Pincode"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label class="form-label" for="address">Phone
                                            Number</label><input class="form-control" id="address" type="number"
                                            placeholder="Enter Phone Number"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> <button class="btn cancel" type="cancel" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button><button class="btn submit" type="submit"
                            data-bs-dismiss="modal" aria-label="Close">Submit</button></div>
                </div>
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
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Jeans
                                Women</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Blazer Women</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Jeans
                                Men</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Blazer Men</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>T-Shirts Men</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Shoes
                                Men</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>T-Shirts Women</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Bags</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Sneakers Women</a></li>
                        <li> <a href="collection-left-sidebar.html"><i class="iconsax"
                                    data-icon="search-normal-2"></i>Dresses</a></li>
                    </ul>
                    <h4>You Might Like</h4>
                    <div class="row gy-4 ratio_square-2 preemptive-search">
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/1.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product.html">
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
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/2.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product.html">
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
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/3.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product.html">
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
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/4.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product.html">
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
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/5.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="product.html">
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
                                    <div class="product-image"><a href="product.html"> <img class="bg-img"
                                                src="../assets/images/product/product-2/blazers/6.jpg"
                                                alt="product"></a>
                                    </div>
                                </div>
                                <div class="product-detail"><a href="product.html">
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
    </main>
    <!-- End container content -->
@endsection
