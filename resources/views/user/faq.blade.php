@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Faq</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Faq</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container faq-section">
                <div class="row gy-4">
                    <div class="col-xl-10 mx-auto">
                        <div class="faq-title-2 sticky">
                            <h3>How Can We Help You?</h3>
                            <div>
                                <div class="faq-search"><input type="search" name="text"
                                        placeholder="Search here...."><i class="iconsax"
                                        data-icon="search-normal-2"></i></div><button
                                    class="btn btn_black">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 mx-auto">
                        <div class="custom-accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"><span>1.
                                                Pellentesque habitant morbi tristique
                                                senectus et netus?</span></button></h2>
                                    <div class="accordion-collapse collapse show" id="collapseOne">
                                        <div class="accordion-body">
                                            <p>"Brewing tea is akin to picking low-hanging fruit - it's easily
                                                identifiable
                                                and immensely satisfying. Just as one can derive pleasure from the
                                                simplicity of tea-making, in photography, I've found that sharing my
                                                work is
                                                paramount to improvement. Each sip of perfectly brewed tea or shared
                                                photograph carries its own story, evoking emotions and connections
                                                beyond
                                                mere words."</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"><span>2. What are
                                                the
                                                shipping costs and estimated delivery time?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Just as the art of brewing tea is a blend of science and artistry, so too
                                                is
                                                photography a fusion of technique and creativity. Each click of the
                                                shutter
                                                captures a moment in time, preserving emotions, stories, and
                                                perspectives.
                                                It's in the sharing of these moments that the true magic unfolds,
                                                weaving a
                                                tapestry of experiences that transcends boundaries and speaks to the
                                                soul.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"><span>3. How can I
                                                downgrade to an earlier version of Dummy Content?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseThree"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Once the earlier version is activated, test your website thoroughly to
                                                ensure
                                                that everything is working as expected. Check that the dummy content is
                                                being generated correctly and that there are no compatibility issues
                                                with
                                                other plugins or themes.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"><span>4. How can I
                                                upgrade from Shopify 2.5 to shopify 3?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseFour"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>As of my last update, there wasn't a direct upgrade path from Shopify 2.5
                                                to
                                                Shopify 3, as there's no versioning system like software updates.
                                                However,
                                                Shopify continually updates its platform with new features and
                                                improvements.
                                                To take advantage of these updates, you generally don't need to perform
                                                any
                                                manual upgrades.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"><span>5. Under what
                                                license are Regular Labs extensions released?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseFive"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Regular Labs extensions are typically released under the GNU General
                                                Public
                                                License (GPL) version 2 or later.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"><span>6. What is the
                                                Regular Labs Library?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseSix"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>The Regular Labs Library is a collection of Joomla extensions developed
                                                by
                                                Regular Labs (formerly known as NoNumber). Regular Labs is a well-known
                                                developer in the Joomla community, creating a variety of extensions to
                                                enhance and extend the functionality of Joomla websites. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSeven"><span>7. Can I
                                                turn
                                                on/off some blocks on the page?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseSeven"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Yes, you can typically turn on/off blocks on a webpage depending on the
                                                level
                                                of control and access you have. If you're a user interacting with a
                                                webpage,
                                                you might not have the ability to directly toggle blocks on or off
                                                unless
                                                the webpage provides such functionality through options or settings.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEight"><span>8. Do you
                                                guys
                                                offer a refund or exchange?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseEight"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>As an AI developed by OpenAI, I don't directly offer refunds or exchanges
                                                as
                                                I'm not a product or service. However, many companies do have policies
                                                in
                                                place for refunds or exchanges depending on their terms and conditions.
                                                It's
                                                best to check with the specific company you're dealing with regarding
                                                their
                                                refund or exchange policies.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNine"><span>9. What I
                                                have to
                                                do when I need your support?</span></button></h2>
                                    <div class="accordion-collapse collapse" id="collapseNine"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>When you need support, simply ask! Whether you need help with a problem,
                                                advice on a decision, information on a topic, or just someone to talk
                                                to,
                                                I'm here to assist you to the best of my ability. Just provide me with
                                                the
                                                details of what you need, and I'll do my best to help.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header"><button class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTen"><span>10. Would
                                                assistance be available to upload the template if
                                                needed?</span></button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapseTen"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Yes, assistance would be available to upload the template if needed.
                                                Whether
                                                you're looking to upload a document, a file, or any other template, feel
                                                free to ask for guidance, and I'll do my best to assist you through the
                                                process.</p>
                                        </div>
                                    </div>
                                </div>
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
