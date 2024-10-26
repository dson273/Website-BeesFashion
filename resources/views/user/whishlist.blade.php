@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Wishlist</h4>
                        </div>
                        <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Wishlist</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container container wishlist-box">
                <div class="product-tab-content ratio1_3">
                    <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="#"> <img class="bg-img"
                                                src="../assets/images/product/product-3/1.jpg" alt="product"></a><a
                                            class="pro-sec" href="#"> <img class="bg-img"
                                                src="../assets/images/product/product-3/20.jpg" alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv1">
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
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="#">
                                        <h6>Greciilooks Women's Stylish Top</h6>
                                    </a>
                                    <p class="list-per">Fashion is to please your eye. Shapes and proportions are for
                                        your
                                        intellect. It is important to be chic. Vanity is the healthiest thing in life.
                                        Elegance isn't solely defined by what you wear. It's how you carry yourself, how
                                        you
                                        speak, what you read. Fashion is made to become unfashionable.</p>
                                    <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/2.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/19.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Wide Linen-Blend Trousers</h6>
                                    </a>
                                    <p class="list-per">I was the first person to have a punk rock hairstyle. It is not
                                        easy
                                        to dress well. I have my permanent muses and my muses of the moment. We live in
                                        an
                                        era of globalization and the era of the woman. Never in the history of the world
                                        have women been more in control of their destiny. You have a more interesting
                                        life
                                        if you wear impressive clothes.</p>
                                    <p>$100.00 <del>$18.00 </del></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/3.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/18.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
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
                                    <p class="list-per">I don't like trends. They tend to make everybody look the same.
                                        Clothes can transform your mood and confidence. I like the body. I like to
                                        design
                                        everything to do with the body. Fashion is made to become unfashionable. I adore
                                        the
                                        challenge of creating truly modern clothes, where a woman's personality and
                                        sense of
                                        self are revealed. I want people to see the dress, but focus on the woman.</p>
                                    <p>$120.30 <del>$140.00</del><span>-20%</span></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/4.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/17.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv2">
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
                                    <p class="list-per">If you wear clothes that don't suit you, you're a fashion
                                        victim.
                                        You have to wear clothes that make you look better. I think I'd go mad if I
                                        didn't
                                        have a place to escape to. In order to be irreplaceable one must always be
                                        different. Clothes mean nothing until someone lives in them. It's really easy to
                                        get
                                        colors right. It's really hard to get black - and neutrals - right. Black is
                                        certainly a color but it's also an illusion.</p>
                                    <p>$190.00 <del>$210.00</del></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/9.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/16.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv3">
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
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Greciilooks Women's Stylish Top</h6>
                                    </a>
                                    <p class="list-per">I try as much as possible to give you a great basic product and
                                        what
                                        comes out, I feel, is really amazing. I believe that my clothes can give people
                                        a
                                        better image of themselves - that it can increase their feelings of confidence
                                        and
                                        happiness. Every day I'm thinking about change. Luxury will be always around, no
                                        matter what happens in the world. I am like a freight train. Working on the
                                        details,
                                        twisting them and playing with them over the years, but always staying on the
                                        same
                                        track.</p>
                                    <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/10.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/15.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Wide Linen-Blend Trousers</h6>
                                    </a>
                                    <p class="list-per">Fashion fades, only style remains the same. I like the body. I
                                        like
                                        to design everything to do with the body. Men don't want another man to look at
                                        their woman because they don't know how to handle it. The key to my collections
                                        is
                                        sensuality. I wanted to dress the woman who lives and works, not the woman in a
                                        painting.</p>
                                    <p>$100.00 <del>$18.00 </del></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/11.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/14.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
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
                                    <p class="list-per">Clothes mean nothing until someone lives in them. I was the
                                        first
                                        person to have a punk rock hairstyle. You have to stay true to your heritage;
                                        that's
                                        what your brand is about. What I hate is nasty, ugly people. I never like to
                                        think
                                        that I design for a particular person. I design for the woman I wanted to be,
                                        the
                                        woman I used to be, and - to some degree - the woman I'm still a little piece
                                        of.
                                    </p>
                                    <p>$120.30 <del>$140.00</del><span>-20%</span></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                            href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i
                                                class="iconsax" data-icon="trash" aria-hidden="true"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/12.jpg"
                                                alt="product"></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img" src="../assets/images/product/product-3/13.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                                class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                            href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                    </div>
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
                                    <p class="list-per">Every day I'm thinking about change. Fashion to me has become
                                        very
                                        disposable; I wanted to get back to craft, to clothes that could last. I want
                                        people
                                        to be afraid of the women I dress. I didn't want to be a fashion designer, and
                                        for a
                                        good half of my career I didn't like it. I always wanted to do other things.
                                        When I
                                        was young, I lived like an old woman, and when I got old, I had to live like a
                                        young
                                        person.</p>
                                    <p>$190.00 <del>$210.00</del></p>
                                    <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"><button class="btn-close" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/1.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/2.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/3.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/4.jpg" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/5.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/6.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/7.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="../assets/images/pro/8.jpg" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h3>Women Pink Shirt</h3>
                                    <h5>$32.96</h5>
                                    <ul class="color-variant">
                                        <li class="bg-color-purple"></li>
                                        <li class="bg-color-blue"></li>
                                        <li class="bg-color-red"></li>
                                        <li class="bg-color-yellow"></li>
                                    </ul>
                                    <div class="border-product">
                                        <h6>Product details</h6>
                                        <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium
                                            doloremque laudantium</p>
                                    </div>
                                    <div class="product-description">
                                        <div class="size-box">
                                            <ul>
                                                <li class="active"><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li> <a href="#">xl</a></li>
                                            </ul>
                                        </div>
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="qty-box">
                                            <div class="input-group"><button class="btn quantity-left-minus"
                                                    type="button" data-type="minus" data-field=""><i
                                                        class="fa-solid fa-angle-left"></i></button><input
                                                    class="form-control input-number" type="text" name="quantity"
                                                    value="1"><button class="btn quantity-right-plus" type="button"
                                                    data-type="plus" data-field=""><i
                                                        class="fa-solid fa-angle-right"></i></button></div>
                                        </div>
                                    </div>
                                    <div class="product-buttons"><a class="btn btn-solid" href="cart.html">Add to
                                            cart</a><a class="btn btn-solid" href="product.html">View detail</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
