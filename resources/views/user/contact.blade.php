@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Contact</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="contact-main">
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="title-1 address-content">
                                <p class="pb-0">Let's Get In Touch<span></span></p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="location"></i></div>
                                <div class="contact-box">
                                    <h6>Contact Number</h6>
                                    <p>+91 123 - 456 - 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="phone-calling"></i></div>
                                <div class="contact-box">
                                    <h6>Email Address</h6>
                                    <p>katie098@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="mail"></i></div>
                                <div class="contact-box">
                                    <h6>Other Address</h6>
                                    <p>ABC Complex, New York USA 123456</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="address-items">
                                <div class="icon-box"> <i class="iconsax" data-icon="map-1"></i></div>
                                <div class="contact-box">
                                    <h6>Bournemouth Office</h6>
                                    <p>Visitación de la Encina 22</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container">
                <div class="contact-main">
                    <div class="row align-items-center gy-4">
                        <div class="col-lg-6 order-lg-1 order-2">
                            <div class="contact-box">
                                <h4>Contact Us </h4>
                                <p>If you've got fantastic products or want to collaborate, reach out to us. </p>
                                <div class="contact-form">
                                    <div class="row gy-4">
                                        <div class="col-12"> <label class="form-label" for="inputEmail4">Full Name
                                            </label><input class="form-control" id="inputEmail4" type="text" name="text"
                                                placeholder="Enter Full Name"></div>
                                        <div class="col-6"><label class="form-label" for="inputEmail5">Email
                                                Address</label><input class="form-control" id="inputEmail5" type="email"
                                                name="email" placeholder="Enter Email Address"></div>
                                        <div class="col-6"><label class="form-label" for="inputEmail6">Phone
                                                Number</label><input class="form-control" id="inputEmail6" type="number"
                                                name="number" placeholder="Enter Phone Number"></div>
                                        <div class="col-12"> <label class="form-label"
                                                for="inputEmail7">Subject</label><input class="form-control"
                                                id="inputEmail7" type="text" name="text" placeholder="Enter Subject">
                                        </div>
                                        <div class="col-12"> <label class="form-label">Message</label><textarea
                                                class="form-control" id="message" rows="6"
                                                placeholder="Enter Your Message"></textarea></div>
                                        <div class="col-12"> <button class="btn btn_black rounded sm" type="submit">
                                                Send
                                                Message </button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 order-lg-2 order-1 offset-xl-1">
                            <div class="contact-img"> <img class="img-fluid"
                                    src="https://themes.pixelstrap.net/katie/assets/images/contact/1.svg" alt=""></div>
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
                            <p>Men's Clothing <span>$35</span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity-previous">2</div>
                                        <div id="quantity-current">3</div>
                                        <div id="quantity-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add">+</button>
                                </div>
                                <div class="btn-cart">
                                    <div>$<span class="btn-cart__total" id="total">105</span></div>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/2.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>Men's Clothing <span>$35</span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove1">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity1-previous">2</div>
                                        <div id="quantity1-current">3</div>
                                        <div id="quantity1-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add1">+</button>
                                </div>
                                <div class="btn-cart">
                                    <div>$<span class="btn-cart__total" id="total1">100</span></div>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/3.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>Men's Clothing <span>$35</span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove2">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity2-previous">2</div>
                                        <div id="quantity2-current">3</div>
                                        <div id="quantity2-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add2">+</button>
                                </div>
                                <div class="btn-cart">
                                    <div>$<span class="btn-cart__total" id="total2">300</span></div>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="../assets/images/cart/4.jpg" alt=""></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>Men's Clothing <span>$35</span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove3">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity3-previous">2</div>
                                        <div id="quantity3-current">3</div>
                                        <div id="quantity3-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add3">+</button>
                                </div>
                                <div class="btn-cart">
                                    <div>$<span class="btn-cart__total" id="total3">200</span></div>
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
