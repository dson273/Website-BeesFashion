@extends('user.layouts.master')

@section('content')
    <!--Container Content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Product Detail</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Product Detail</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space product-thumbnail-page pt-0">
            <div class="custom-container container">
                <div class="row gy-4">
                    {{-- box-left --}}
                    <div class="col-lg-6">
                        <div class="row sticky">
                            <div class="col-sm-2 col-3">
                                <div class="swiper product-slider product-slider-img">
                                    <div class="swiper-wrapper">
                                        @foreach ($product->product_files as $image)
                                            <div class="swiper-slide"><img src="{{ asset('uploads/products/images/' . $image->file_name) }}" alt=""></div>
                                        @endforeach
                                        {{-- <div class="swiper-slide"> <img src="../assets/images/product/slider/4.jpg"
                                                alt=""><span> <i class="iconsax" data-icon="play"></i></span></div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-9">
                                <div class="swiper product-slider-thumb product-slider-img-1">
                                    <div class="swiper-wrapper ratio_square-2">
                                        @foreach ($product->product_files as $image)
                                            <div class="swiper-slide"><img class="bg-img" src="{{ asset('uploads/products/images/' . $image->file_name) }}" alt=""></div>
                                        @endforeach
                                        {{-- <div class="swiper-slide"> <video class="video-tag" loop="" autoplay="" muted="">
                                                <source
                                                    src="https://themes.pixelstrap.net/katie/assets/images/product/slider/clothing.mp4"
                                                    type="video/mp4"> Your browser does not support the video tag.
                                            </video></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- box-right --}}
                    <div class="col-lg-6">
                        <div class="product-detail-box">
                            <div class="product-option">
                                <div class="move-fast-box d-flex align-items-center gap-1"><img src="../assets/images/gif/fire.gif" alt="">
                                    <p>Move fast!</p>
                                </div>
                                <h3>{{ $product->name }} {{ $product->SKU }}</h3>

                                <div class="box-price-top d-flex align-items-end gap-2">
                                    <div id="price">{{ $product->priceRange }}</div>
                                    <div id="discount" class="offer-btn">Hot!</div>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="fa-solid fa-star"> </i>
                                            <i class="fa-solid fa-star"> </i>
                                            <i class="fa-solid fa-star"> </i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                            <i class="fa-regular fa-star"></i>
                                        </li>
                                        <li>(4.7) Rating</li>
                                    </ul>
                                    <p>Dressing up. People just don't do it anymore. We have to change that. Give me time
                                        and I'll give you a revolution.</p>
                                </div>
                                <div class="buy-box border-buttom mb-3">
                                    <ul>
                                        <li> <span data-bs-toggle="modal" data-bs-target="#size-chart" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="ruler"></i>Size
                                                Chart</span>
                                        </li>
                                        <li> <span data-bs-toggle="modal" data-bs-target="#terms-conditions-modal" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="truck"></i>Delivery
                                                & return</span></li>
                                        <li> <span data-bs-toggle="modal" data-bs-target="#question-box" title="Quick View" tabindex="0"><i class="iconsax me-2" data-icon="question-message"></i>Ask
                                                a Question</span></li>
                                    </ul>
                                </div>
                                <input type="number" class="total_attributes" value="{{ count($array_attributes) }}" hidden>
                                <input type="number" class="product_id" value="{{ $product->id }}" hidden>
                                <div class="blink-border">
                                    @foreach ($array_attributes as $attribute_item)
                                        @if ($attribute_item['type'] == 'button')
                                            <div class="d-flex attribute-section">
                                                <div>
                                                    <h5>{{ $attribute_item['name'] }}:</h5>
                                                    <div class="button-box attribute_group" data-id="{{ $attribute_item['id'] }}" data-type="{{ $attribute_item['type'] }}">
                                                        <ul class="button-variant">
                                                            @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                                <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}" data-id="{{ $attribute_value_item['id'] }}">
                                                                    {{ $attribute_value_item['name'] }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($attribute_item['type'] == 'color')
                                            <div class="attribute-section">
                                                <h5>{{ $attribute_item['name'] }}:</h5>
                                                <div class="color-box attribute_group" data-id="{{ $attribute_item['id'] }}">
                                                    <ul class="color-variant">
                                                        @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                            <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}"
                                                                style="background-color: {{ $attribute_value_item['value'] }}; border:1px solid rgba(var(--theme-default))"
                                                                data-id="{{ $attribute_value_item['id'] }}">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="attribute-section">
                                                <h5>{{ $attribute_item['name'] }}:</h5>
                                                <div class="default-box attribute_group" data-id="{{ $attribute_item['id'] }}">
                                                    <ul class="default-variant">
                                                        @foreach ($attribute_item['attribute_values'] as $attribute_value_item)
                                                            <li class="attribute_item able" title="{{ $attribute_value_item['name'] }}" data-id="{{ $attribute_value_item['id'] }}">
                                                                {{ $attribute_value_item['name'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="quantity-box d-flex align-items-center gap-3">
                                    <div class="quantity_pro">
                                        <button class="reduce" type="button"><i class="fa-solid fa-minus"></i></button>
                                        <input class="quantity" type="number" value="1" min="1" max="20">
                                        <button class="increment" type="button"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="selected-variant d-flex">
                                        <p id="update-stock" class="me-1">{{ $total_stock }} </p> sản phẩm có sẵn
                                    </div>
                                    <!-- Nút "Chọn lại" -->
                                    <div class="reset-button">
                                        <button class="reset_selected">Reset</button>
                                    </div>
                                </div>
                                <span class="box-price d-flex align-items-end gap-2">
                                    <p class="currency mb-3" id="sale-price"></p>
                                    <p class="currency mb-3" id="regular-price"></p>
                                    <p class="mb-3" id="percent-discount"></p>
                                </span>
                                <div class="d-flex align-items-center w-100 add-cart-box mb-3 gap-2">
                                    <a class="btn btn_black sm add-to-cart" href="#" title="add product">Add To
                                        Cart</a>
                                    <a class="btn btn_outline sm" href="#">Buy Now</a>
                                </div>
                                <div class="buy-box">
                                    <ul>
                                        <li> <a href="#"> <i class="fa-regular fa-heart me-2"></i>Add To
                                                Wishlist</a></li>
                                        <li> <a href="#"> <i class="fa-solid fa-arrows-rotate me-2"></i>Add To
                                                Compare</a></li>
                                        <li> <a href="#" data-bs-toggle="modal" data-bs-target="#social-box" title="Quick View" tabindex="0"><i
                                                    class="fa-solid fa-share-nodes me-2"></i>Share</a></li>
                                    </ul>
                                </div>
                                <div class="sale-box">
                                    <div class="d-flex align-items-center gap-2"><img src="../assets/images/gif/timer.gif" alt="">
                                        <p>Limited Time Left! Hurry, Sale Ending!</p>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv1">
                                            <li>
                                                <div class="timer">
                                                    <div class="days"></div>
                                                </div><span class="title">Days</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="hours"></div>
                                                </div><span class="title">Hours</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="minutes"></div>
                                                </div><span class="title">Min</span>
                                            </li>
                                            <li>:</li>
                                            <li>
                                                <div class="timer">
                                                    <div class="seconds"></div>
                                                </div><span class="title">Sec</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- <div class="dz-info">
                                    <ul>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Sku:</h6>
                                                <p> SKU_45 </p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Available: </h6>
                                                <p>Pre-Order</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Tags: </h6>
                                                <p>Color Pink Clay , Athletic, Accessories, Vendor Kalles</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6>Vendor: </h6>
                                                <p> Balenciaga</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="share-option">
                                    <h5>Secure Checkout </h5><img class="img-fluid" src="../assets/images/other-img/secure_payments.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-section-box x-small-section pt-0">
                <div class="custom-container container">
                    <div class="row">
                        <div class="col-12">
                            <ul class="product-tab theme-scrollbar nav nav-tabs nav-underline" id="Product" role="tablist">
                                <li class="nav-item" role="presentation"><button class="nav-link active" id="Description-tab" data-bs-toggle="tab" data-bs-target="#Description-tab-pane"
                                        role="tab" aria-controls="Description-tab-pane" aria-selected="true">Description</button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification-tab-pane" role="tab"
                                        aria-controls="specification-tab-pane" aria-selected="false">Specification</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question-tab-pane" role="tab"
                                        aria-controls="question-tab-pane" aria-selected="false">Q & A</button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="Reviews-tab" data-bs-toggle="tab" data-bs-target="#Reviews-tab-pane" role="tab"
                                        aria-controls="Reviews-tab-pane" aria-selected="false">Reviews</button></li>
                            </ul>
                            <div class="tab-content product-content" id="ProductContent">
                                {{-- Mô tả sản phẩm --}}
                                <div class="tab-pane fade show active" id="Description-tab-pane" role="tabpanel" aria-labelledby="Description-tab" tabindex="0">
                                    <div class="row gy-4">
                                        {!! $product->description !!}
                                        {{-- <div class="col-12">
                                            <p class="paragraphs">Experience the perfect blend of comfort and style with
                                                our
                                                Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress
                                                offers a soft and breathable feel, making it ideal for warm weather. The
                                                lightweight fabric ensures you stay cool and comfortable throughout the day.
                                            </p>
                                            <p class="paragraphs">Perfect for casual outings, beach trips, or summer
                                                parties. Pair it with sandals for a relaxed look or dress it up with heels
                                                and accessories for a more polished ensemble.</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="row gy-4">
                                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                    <div class="general-summery">
                                                        <h5>Product Specifications</h5>
                                                        <ul>
                                                            <li>100% Premium Cotton</li>
                                                            <li>A-line silhouette with a flattering fit</li>
                                                            <li>Knee-length for versatile styling</li>
                                                            <li>V-neck for a touch of elegance</li>
                                                            <li>Short sleeves for a casual look</li>
                                                            <li>Available in solid colors and floral prints</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                    <div class="general-summery">
                                                        <h5>Washing Instructions</h5>
                                                        <ul>
                                                            <li>Use cold water for washing</li>
                                                            <li>Use a low heat setting for drying.</li>
                                                            <li>Avoid using bleach on this fabric.</li>
                                                            <li>Use a low heat setting when ironing.</li>
                                                            <li>Do not take this item to a dry cleaner.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                    <div class="general-summery">
                                                        <h5>Size & Fit</h5>
                                                        <ul>
                                                            <li>The model (height 5'8) is wearing a size S</li>
                                                            <li>Measurements taken from size Small</li>
                                                            <li>Chest: 30"</li>
                                                            <li>Length: 20"</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- End mô tả --}}

                                {{-- Specification --}}
                                <div class="tab-pane fade" id="specification-tab-pane" role="tabpanel" aria-labelledby="specification-tab" tabindex="0">
                                    <p>I like to be real. I don't like things to be staged or fussy. Grunge is a hippied
                                        romantic version of punk. I have my favourite fashion decade, yes, yes, yes: '60s.
                                        It was a sort of little revolution; the clothes were amazing but not too
                                        exaggerated. Fashions fade, style is eternal. A girl should be two things: classy
                                        and fabulous.</p>
                                    <div class="table-responsive theme-scrollbar">
                                        <table class="specification-table striped table">
                                            <tr>
                                                <th>Product Dimensions</th>
                                                <td>15 x 15 x 3 cm; 250 Grams</td>
                                            </tr>
                                            <tr>
                                                <th>Date First Available</th>
                                                <td>5 April 2021</td>
                                            </tr>
                                            <tr>
                                                <th>Manufacturer&rlm;</th>
                                                <td>Aditya Birla Fashion and Retail Limited</td>
                                            </tr>
                                            <tr>
                                                <th>ASIN</th>
                                                <td>B06Y28LCDN</td>
                                            </tr>
                                            <tr>
                                                <th>Item model number</th>
                                                <td>AMKP317G04244</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>Men</td>
                                            </tr>
                                            <tr>
                                                <th>Item Weight</th>
                                                <td>250 G</td>
                                            </tr>
                                            <tr>
                                                <th>Item Dimensions LxWxH</th>
                                                <td>15 x 15 x 3 Centimeters</td>
                                            </tr>
                                            <tr>
                                                <th>Net Quantity</th>
                                                <td>1 U</td>
                                            </tr>
                                            <tr>
                                                <th>Included Components&rlm;</th>
                                                <td>1-T-shirt</td>
                                            </tr>
                                            <tr>
                                                <th>Generic Name</th>
                                                <td>T-shirt</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                {{-- Q&A --}}
                                <div class="tab-pane fade" id="question-tab-pane" role="tabpanel" aria-labelledby="question-tab" tabindex="0">
                                    <div class="question-main-box">
                                        <h5>Have Doubts Regarding This Product ?</h5>
                                        <h6 data-bs-toggle="modal" data-bs-target="#question-modal" title="Quick View" tabindex="0">Post Your Question</h6>
                                    </div>
                                    <div class="question-answer">
                                        <ul>
                                            <li>
                                                <div class="question-box">
                                                    <p>Q1 </p>
                                                    <h6>Which designer created the little black dress?</h6>
                                                    <ul class="link-dislike-box">
                                                        <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                </i>0</a></li>
                                                        <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                </i>0</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="answer-box"><b>Ans.</b><span>The little black dress (LBD) is
                                                        often attributed to the iconic fashion designer Coco Chanel. She
                                                        popularized the concept of the LBD in the 1920s, offering a simple,
                                                        versatile, and elegant garment that became a staple in women's
                                                        fashion.</span></div>
                                            </li>
                                            <li>
                                                <div class="question-box">
                                                    <p>Q2 </p>
                                                    <h6>Which First Lady influenced women's fashion in the 1960s?</h6>
                                                    <ul class="link-dislike-box">
                                                        <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                </i>0</a></li>
                                                        <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                </i>0</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="answer-box"><b>Ans.</b><span>The First Lady who significantly
                                                        influenced women's fashion in the 1960s was Jacqueline Kennedy, the
                                                        wife of President John F. Kennedy. She was renowned for her elegant
                                                        and sophisticated style, often wearing simple yet chic outfits that
                                                        set trends during her time in the White House. </span></div>
                                            </li>
                                            <li>
                                                <div class="question-box">
                                                    <p>Q3 </p>
                                                    <h6>What was the first name of the fashion designer Chanel?</h6>
                                                    <ul class="link-dislike-box">
                                                        <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0
                                                            </a>
                                                        </li>
                                                        <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                </i>0</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="answer-box"><b>Ans.</b><span>The first name of the fashion
                                                        designer Chanel was Gabrielle. Gabrielle "Coco" Chanel was a
                                                        pioneering French fashion designer known for her timeless designs,
                                                        including the iconic Chanel suit and the little black dress.</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="question-box">
                                                    <p>Q4 </p>
                                                    <h6>Carnaby Street, famous in the 60s as a fashion center, is in which
                                                        capital?</h6>
                                                    <ul class="link-dislike-box">
                                                        <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                </i>0</a></li>
                                                        <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                </i>0</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="answer-box"><b>Ans.</b><span>Carnaby Street, famous for its
                                                        association with fashion and youth culture in the 1960s, is located
                                                        in London, the capital of the United Kingdom.🎉</span></div>
                                            </li>
                                            <li>
                                                <div class="question-box">
                                                    <p>Q5 </p>
                                                    <h6>Threadless is a company selling unique what?</h6>
                                                    <ul class="link-dislike-box">
                                                        <li> <a href="#"><i class="iconsax" data-icon="like">
                                                                </i>0</a></li>
                                                        <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                                </i>0</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="answer-box"><b>Ans.</b><span>Threadless is a company selling
                                                        unique T-shirts.</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                {{-- Đánh giá --}}
                                <div class="tab-pane fade" id="Reviews-tab-pane" role="tabpanel" aria-labelledby="Reviews-tab" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-lg-4">
                                            <div class="review-right">
                                                <div class="customer-rating">
                                                    <div class="global-rating">
                                                        <div>
                                                            <h5>4.5</h5>
                                                        </div>
                                                        <div>
                                                            <h6>Average Ratings</h6>
                                                            <ul class="rating mb p-0">
                                                                <li><i class="fa-solid fa-star"></i></li>
                                                                <li><i class="fa-solid fa-star"></i></li>
                                                                <li><i class="fa-solid fa-star"></i></li>
                                                                <li><i class="fa-solid fa-star"></i></li>
                                                                <li><i class="fa-regular fa-star"></i></li>
                                                                <li><span>(14)</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="rating-progess">
                                                        <li>
                                                            <p>5 Star</p>
                                                            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 80%"></div>
                                                            </div>
                                                            <p>80%</p>
                                                        </li>
                                                        <li>
                                                            <p>4 Star</p>
                                                            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 70%"></div>
                                                            </div>
                                                            <p>70%</p>
                                                        </li>
                                                        <li>
                                                            <p>3 Star</p>
                                                            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 55%"></div>
                                                            </div>
                                                            <p>55%</p>
                                                        </li>
                                                        <li>
                                                            <p>2 Star</p>
                                                            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 40%"></div>
                                                            </div>
                                                            <p>40%</p>
                                                        </li>
                                                        <li>
                                                            <p>1 Star</p>
                                                            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 25%"></div>
                                                            </div>
                                                            <p>25%</p>
                                                        </li>
                                                    </ul><button class="btn reviews-modal" data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Write a
                                                        review</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="comments-box">
                                                <h5>Comments </h5>
                                                <ul class="theme-scrollbar">
                                                    <li>
                                                        <div class="comment-items">
                                                            <div class="user-img"> <img src="../assets/images/user/1.jpg" alt=""></div>
                                                            <div class="user-content">
                                                                <div class="user-info">
                                                                    <div class="d-flex justify-content-between gap-3">
                                                                        <h6> <i class="iconsax" data-icon="user-1"></i>Michel Poe</h6>
                                                                        <span>
                                                                            <i class="iconsax" data-icon="clock"></i>Mar
                                                                            29,
                                                                            2022</span>
                                                                    </div>
                                                                    <ul class="rating mb p-0">
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-regular fa-star"></i></li>
                                                                    </ul>
                                                                </div>
                                                                <p>Khaki cotton blend military jacket flattering fit mock
                                                                    horn buttons and patch pockets showerproof black
                                                                    lightgrey. Printed lining patch pockets jersey blazer
                                                                    built in pocket square wool casual quilted jacket
                                                                    without hood azure.</p><a href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                                        Replay</span></a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="reply">
                                                        <div class="comment-items">
                                                            <div class="user-img"> <img src="../assets/images/user/2.jpg" alt=""></div>
                                                            <div class="user-content">
                                                                <div class="user-info">
                                                                    <div class="d-flex justify-content-between gap-3">
                                                                        <h6> <i class="iconsax" data-icon="user-1"></i>Michel Poe</h6>
                                                                        <span>
                                                                            <i class="iconsax" data-icon="clock"></i>Mar
                                                                            29,
                                                                            2022</span>
                                                                    </div>
                                                                    <ul class="rating mb p-0">
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-regular fa-star"></i></li>
                                                                    </ul>
                                                                </div>
                                                                <p>Khaki cotton blend military jacket flattering fit mock
                                                                    horn buttons and patch pockets showerproof black
                                                                    lightgrey. Printed lining patch pockets jersey blazer
                                                                    built in pocket square wool casual quilted jacket
                                                                    without hood azure.</p><a href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                                        Replay</span></a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="comment-items">
                                                            <div class="user-img"> <img src="../assets/images/user/3.jpg" alt=""></div>
                                                            <div class="user-content">
                                                                <div class="user-info">
                                                                    <div class="d-flex justify-content-between gap-3">
                                                                        <h6> <i class="iconsax" data-icon="user-1"></i>Michel Poe</h6>
                                                                        <span>
                                                                            <i class="iconsax" data-icon="clock"></i>Mar
                                                                            29,
                                                                            2022</span>
                                                                    </div>
                                                                    <ul class="rating mb p-0">
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-solid fa-star"></i></li>
                                                                        <li><i class="fa-regular fa-star"></i></li>
                                                                    </ul>
                                                                </div>
                                                                <p>Khaki cotton blend military jacket flattering fit mock
                                                                    horn buttons and patch pockets showerproof black
                                                                    lightgrey. Printed lining patch pockets jersey blazer
                                                                    built in pocket square wool casual quilted jacket
                                                                    without hood azure.</p><a href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                                        Replay</span></a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End đánh giá --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0">
            <div class="custom-container product-contain container">
                <div class="text-start mb-4">
                    <h3>Related Products</h3>
                </div>
                <div class="swiper special-offer-slide-2">
                    <div class="swiper-wrapper ratio1_3">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="swiper-slide">
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i class="iconsax"
                                                    data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a></div>
                                        <div class="product-image">
                                            <a class="pro-first" href="{{ route('product.detail', $relatedProduct->id) }}">
                                                <img class="bg-img" src="{{ asset('uploads/products/images/' . $relatedProduct->active_image) }}" alt="product"></a>
                                            <a class="pro-sec" href="{{ route('product.detail', $relatedProduct->id) }}">
                                                <img class="bg-img" src="{{ asset('uploads/products/images/' . $relatedProduct->inactive_image) }}" alt="product"></a>
                                        </div>
                                        <div class="cart-info-icon">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                                </i></a>
                                            {{-- <a href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a> --}}
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
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
                                        </ul><a href="{{ route('product.detail', $relatedProduct->id) }}">
                                            <h6>{{ $relatedProduct->name }}</h6>
                                        </a>
                                        <p style="color: rgb(201, 33, 39)">{{ $relatedProduct->priceRange }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="swiper-slide">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i class="iconsax"
                                                data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a></div>
                                    <div class="product-image"><a class="pro-first" href="product-detail.html"> <img class="bg-img" src="../assets/images/product/product-3/14.jpg"
                                                alt="product"></a><a class="pro-sec" href="product-detail.html"> <img class="bg-img" src="../assets/images/product/product-3/16.jpg"
                                                alt="product"></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0"><i class="iconsax" data-icon="basket-2"
                                                aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                            </i></a><a href="compare.html" tabindex="0"><i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i class="iconsax"
                                                data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a></div>
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
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product-detail.html">
                                        <h6>Greciilooks Women's Stylish Top</h6>
                                    </a>
                                    <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>

        <div class="customer-reviews-modal modal theme-modal fade" id="Reviews-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Write A Review</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/modal/1.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00</del></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="customer-rating"><label class="form-label">Review Content :</label>
                                    <ul class="rating mb p-0">
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"> </i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Review Content :</label>
                                    <textarea class="form-control" id="comment" cols="30" rows="4" placeholder="Write your comments here..."></textarea>
                                </div>
                            </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="reviews-modal modal theme-modal fade" id="question-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Ask a question</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/modal/1.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00</del></p>
                                            <ul class="rating mb p-0">
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
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Your Question</label>
                                    <textarea class="form-control" id="comment-1" cols="30" rows="5" placeholder="Write Your Question here..."></textarea>
                                </div>
                            </div>
                            <div class="modal-button-group"><button class="btn btn-cancel" type="submit" data-bs-dismiss="modal" aria-label="Close">Cancel</button><button class="btn btn-submit"
                                    type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/1.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/2.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/3.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/4.jpg" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/5.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/6.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/7.jpg" alt=""></div>
                                            <div class="swiper-slide"><img class="bg-img" src="../assets/images/pro/8.jpg" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h3>Women Pink Shirt</h3>
                                    <h5>$32.96<del>$50.12</del></h5>
                                    <ul class="color-variant">
                                        <li class="bg-color-brown"></li>
                                        <li class="bg-color-chocolate"></li>
                                        <li class="bg-color-coffee"></li>
                                        <li class="bg-color-black"></li>
                                    </ul>
                                    <div class="border-product">
                                        <h6>Product details</h6>
                                        <p>Western yoke on an Indigo shirt made of 100% cotton. Ideal for informal
                                            gatherings, this top will ensure your comfort and style throughout the day.
                                        </p>
                                    </div>
                                    <div class="product-description">
                                        <div class="size-box">
                                            <ul>
                                                <li class="active"><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                            </ul>
                                        </div>
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="quantity"><button class="minus" type="button"><i class="fa-solid fa-minus"></i></button><input type="number" value="1" min="1"
                                                max="20"><button class="plus" type="button"><i class="fa-solid fa-plus"></i></button></div>
                                    </div>
                                    <div class="product-buttons"><a class="btn btn-solid" href="#">Add to
                                            cart</a><a class="btn btn-solid" href="#">View detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="terms-conditions-modal modal theme-modal fade" id="terms-conditions-modal" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Delivery & return</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <ul class="returns-policy">
                            <li> <b>Return Policy: </b>Most unopened items can be returned within 30 days of delivery
                                for a
                                full refund. We cover return shipping costs for our errors (e.g., incorrect or defective
                                items). Refunds typically process within four weeks, although often faster. This
                                includes
                                return transit time (5-10 business days), processing upon receipt (3-5 business days),
                                and
                                your bank's refund processing (5-10 business days). To return an item, log in, access
                                your
                                order, and click "Return Item(s)." We'll email you once your return is processed.</li>
                            <li>– Free shipping on orders over $100.</li>
                            <li>– Returns accepted within 10 days of receipt or tracking number for unworn items. </li>
                            <li>– Items must be in their original packaging and</li>
                            <li>– Standard shipping charges apply otherwise. Please refer to our delivery Terms &
                                Conditions
                                for further details.</li>
                            <li>– Returned products must be in original packaging, safety wrapped, undamaged, and
                                unworn.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade" id="size-chart" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Size Chart</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0"><a href="#"> <img class="img-fluid" src="../assets/images/size-chart/size-chart.jpg" alt=""></a></div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade question-answer-modal" id="question-box" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Ask a Question</h4><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="reviews-product">
                                    <div> <img src="../assets/images/modal/0.jpg" alt="">
                                        <div>
                                            <h5>Denim Skirts Corset Blazer</h5>
                                            <p>$20.00 <del>$35.00 </del></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="from-group"> <label class="form-label">Your Question :</label>
                                    <textarea class="form-control" id="comment" cols="30" rows="4" placeholder="Write your Question here..."></textarea>
                                </div>
                            </div>
                            <div class="modal-button-group"><button class="btn btn-cancel" type="submit" data-bs-dismiss="modal" aria-label="Close">Cancel</button><button class="btn btn-submit"
                                    type="submit" data-bs-dismiss="modal" aria-label="Close">Submit</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal theme-modal fade social-modal" id="social-box" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Copy link</h6><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"><input class="form-field form-field--input" type="text" value="http://localhost:3000/katie/template/product-detail.html#">
                        <h6>Share:</h6>
                        <ul>
                            <li> <a href="https://www.facebook.com/" target="_blank"> <i class="fa-brands fa-facebook-f"></i></a></li>
                            <li> <a href="https://in.pinterest.com/" target="_blank"> <i class="fa-brands fa-pinterest-p"></i></a></li>
                            <li> <a href="https://twitter.com/" target="_blank"> <i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                            <li> <a href="https://www.instagram.com/" target="_blank"> <i class="fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End container content -->
@endsection

@section('script-libs')
    <script src="{{ asset('assets/js/grid-option.js') }}"></script>
    <script>
        $(document).ready(function(e) {
            //-----------------------currency------------------------------
            function currency() {
                var status = true;
                try {
                    $('.currency').each(function() {
                        var value = $(this).text();
                        // Loại bỏ các ký tự không phải số
                        var numericValue = parseFloat(value.replace(/[^0-9]/g, ''));
                        // Định dạng số theo định dạng tiền tệ
                        var formattedValue = new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(numericValue);
                        // Cập nhật giá trị định dạng vào phần tử
                        $(this).text(formattedValue);
                    });
                } catch (e) {
                    status = false;
                }
                return status;
            }
            currency();

            // Biến lưu trữ các biến thể của sản phẩm
            var variants = @json($array_variants) || [];
            var attribute_value_ids = [];
            var current_item_id = 0;
            var product_id = $('.product_id').val();
            var total_attributes = $('.total_attributes').val();
            var total_stock = $("#update-stock").text();
            var sale_price = $("#sale-price").text();
            var regular_price = $("#regular-price").text();
            var percent_discount = $("#percent-discount").text();
            var variant_selected = false;
            var variant_id = null;
            var get_stock_variant_clicked = null;
            $('#sale-price, #regular-price, #percent-discount').hide();
            // Khi người dùng chọn một giá trị thuộc tính
            $(".attribute_item").click(function(e) {
                if ($(this).hasClass('able')) {
                    var array_allow_click_attribute_values_id = [];
                    var attributeValueId = $(this).data("id");
                    // Kiểm tra nếu đang ở trạng thái active (được chọn)
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active'); // Xóa class active khi bỏ chọn
                        // Xoá id của thuộc tính được bỏ chọn khỏi mảng
                        attribute_value_ids = attribute_value_ids.filter(function(item) {
                            return item != attributeValueId;
                        });
                        // Nếu không còn thuộc tính nào được chọn, reset variant_selected
                        if (attribute_value_ids.length == 0 || variant_selected == true) {
                            variant_selected = false;
                            variant_id = null;
                        }
                        // Ẩn nút reset khi không còn thuộc tính nào được chọn
                        if (attribute_value_ids.length == 0) {
                            $('.reset_selected').hide();
                        }
                        // Cập nhật lại giá và số lượng sản phẩm
                        $('#sale-price, #regular-price, #percent-discount').hide();
                        $('#update-stock').text(total_stock);
                        get_stock_variant_clicked = null;
                        console.log(get_stock_variant_clicked);
                        //kiểm tra từng phần tử
                        $('.attribute_item').each(function() {
                            if (!$(this).hasClass('able')) {
                                $(this).removeClass('disabled');
                                $(this).addClass('able');
                            }
                        });
                        // Lọc các biến thể hợp lệ
                        variants.forEach(function(variant) {
                            var isSubset = attribute_value_ids.every(function(item) {
                                return variant['attribute_values'].includes(item);
                            });
                            if (isSubset && variant['stock'] > 0) {
                                variant['attribute_values'].forEach(function(
                                    item_variant_attribute_value_id) {
                                    if (!array_allow_click_attribute_values_id.includes(
                                            item_variant_attribute_value_id)) {
                                        array_allow_click_attribute_values_id.push(
                                            item_variant_attribute_value_id);
                                    }
                                });
                            }
                        });
                        // Disable các item không hợp lệ
                        $('.able').each(function() {
                            var id_item_btn_click = $(this).data('id');
                            if (!array_allow_click_attribute_values_id.includes(id_item_btn_click)) {
                                $(this).removeClass('able active').addClass('disabled');
                            }
                        });
                    } else {
                        var current_item = $(this).closest('.attribute_group').find('.attribute_item.active');
                        if (current_item.length && current_item.hasClass('active')) {
                            current_item.removeClass('active');
                            var current_item_id = current_item.data('id');

                            // Loại bỏ current_item_id khỏi attribute_value_ids
                            attribute_value_ids = attribute_value_ids.filter(item => item !== current_item_id);
                        }
                        // Thêm thuộc tính mới vào mảng
                        $(this).addClass('active');
                        attribute_value_ids.push(attributeValueId); // Thêm id thuộc tính vừa chọn vào mảng
                        // Hiển thị nút reset khi có thuộc tính được chọn
                        if (attribute_value_ids.length > 0) {
                            $('.reset_selected').show();
                        }
                        //Xử lý lọc thuộc tính khi người dùng chọn
                        variants.forEach(function(variant) {
                            var isSubset = attribute_value_ids.every(function(item) {
                                return variant['attribute_values'].includes(item);
                            });
                            if (isSubset && variant['stock'] > 0) {
                                variant['attribute_values'].forEach(function(
                                    item_variant_attribute_value_id) {
                                    if (!array_allow_click_attribute_values_id.includes(
                                            item_variant_attribute_value_id)) {
                                        array_allow_click_attribute_values_id.push(
                                            item_variant_attribute_value_id);
                                    }
                                });
                            }
                        });
                        //Kiểm tra xem biến thể có liên kết với nhau không
                        function arraysEqualUnordered(arr1, arr2) {
                            if (arr1.length !== arr2.length) return false;
                            let sortedArr1 = arr1.slice().sort();
                            let sortedArr2 = arr2.slice().sort();
                            return sortedArr1.every((value, index) => value === sortedArr2[index]);
                        }
                        variants.some(function(variant) {
                            variant_selected = arraysEqualUnordered(variant['attribute_values'],
                                attribute_value_ids);
                            if (variant_selected) {
                                variant_id = variant['variant_id'];
                                $('#sale-price, #regular-price, #percent-discount').show();
                            }
                            console.log('Trạng thái của variant_selected là: ' + variant_selected);
                            return variant_selected;
                        });
                        // Disable các item không hợp lệ
                        array_allow_click_attribute_values_id.forEach(function(item) {
                            $('.able').each(function() {
                                var id_item_btn_click = $(this).data('id');
                                if (!array_allow_click_attribute_values_id.includes(
                                        id_item_btn_click)) {
                                    $(this).removeClass('able active');
                                    $(this).addClass('disabled');
                                }
                            });
                        });
                        e.preventDefault();
                        $('.attribute_group').each(function() {
                            attributeValuesId = $(this).data('id');
                            if (attribute_value_ids.includes(attributeValuesId)) {
                                $.ajax({
                                    url: "{{ route('userProductDetailFocused') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        attribute_value_ids: attribute_value_ids,
                                        product_id: product_id
                                    },
                                    success: function(response) {
                                        if (response.status == "success") {
                                            var regular_price = response.data['regular_price'];
                                            var sale_price = response.data['sale_price'];
                                            var stock = response.data['stock'];
                                            var percent_discount = (100 - (sale_price /
                                                regular_price * 100)).toFixed(1);
                                            if (variant_selected) {
                                                if (sale_price && sale_price > 0) {
                                                    $('#regular-price').text(regular_price)
                                                        .addClass('regular-price-css')
                                                        .removeClass('regular-price');
                                                    $('#sale-price').text(sale_price);
                                                    $('#update-stock').text(stock);
                                                    $('#percent-discount')
                                                        .text("-" + percent_discount + "%");
                                                } else {
                                                    $('#regular-price').text(regular_price)
                                                        .addClass('regular-price')
                                                        .removeClass('regular-price-css');
                                                    $('#sale-price, #percent-discount').hide();
                                                    $('#update-stock').text(stock);
                                                }
                                                get_stock_variant_clicked = stock;
                                                currency();
                                            }
                                        } else {
                                            $('#update-stock').text(0);
                                            notification('error', 'Sản phẩm không có sẵn', 'Hết hàng');
                                            console.log('Response status is not success');
                                        }
                                    },
                                    error: function(xhr) {
                                        alert('Đã xảy ra lỗi trong quá trình xử lý yêu cầu.');
                                    }
                                })
                            }
                        });
                    }
                }
            });
            //------------------Handle increment and reduce quantity-------------------
            $('.reduce').click(function() {
                if (!variant_selected) {
                    $('.blink-border').addClass('animation-blink-border');
                    setTimeout(() => {
                        $('.blink-border').removeClass('animation-blink-border');
                    }, 950);
                    notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
                } else {
                    if ($('.quantity').val() <= 1) {
                        $('.quantity').val(1);
                    } else {
                        $('.quantity').val($('.quantity').val() - 1);
                    }
                }
            })
            $('.quantity').on('input', function() {
                if (!variant_selected) {
                    $(this).val(1);
                    $('.blink-border').addClass('animation-blink-border');
                    setTimeout(() => {
                        $('.blink-border').removeClass('animation-blink-border');
                    }, 950);
                    notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
                } else {
                    if (!Number($(this).val())) {
                        $(this).val(1);
                        notification('error', 'Vui lòng nhập số!', 'Lỗi');
                    }
                }
            })
            $('.increment').click(function() {
                if (!variant_selected) {
                    $('.blink-border').addClass('animation-blink-border');
                    setTimeout(() => {
                        $('.blink-border').removeClass('animation-blink-border');
                    }, 950);
                    notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
                } else {
                    if ($('.quantity').val() >= get_stock_variant_clicked) {
                        $('.blink-border-text').addClass('animation-blink-border');
                        setTimeout(() => {
                            $('.blink-border-text').removeClass('animation-blink-border');
                        }, 950);
                        notification('warning', 'Đã đạt đến số lượng tối đa trong kho!', 'Cảnh báo!');
                    } else if ($('.quantity').val() >= 10) {
                        notification('warning', 'Mỗi lần chỉ được phép mua tối đa 10 sản phẩm!',
                            'Cảnh báo!');
                    } else {
                        $('.quantity').val(function(i, val) {
                            return parseInt(val) + 1;
                        });
                    }
                }
            })
            $('.add-to-cart').click(function() {
                if (!variant_selected) {
                    $('.blink-border').addClass('animation-blink-border');
                    setTimeout(() => {
                        $('.blink-border').removeClass('animation-blink-border');
                    }, 950);
                    notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
                } else {
                    var quantity = $('.quantity').val();
                    const url =
                        "{{ route('addToCart', ['variant_id' => ':variant_id', 'quantity' => ':quantity']) }}"
                        .replace(':variant_id', variant_id)
                        .replace(':quantity', quantity);
                    window.location.href = url;
                }
            })

            //------------Xử lý reset selected-----------------------
            if (attribute_value_ids.length == 0) {
                $('.reset_selected').hide();
            }
            $('.reset_selected').click(function() {
                attribute_value_ids = [];
                $('.attribute_item').each(function() {
                    if (!$(this).hasClass('able')) {
                        $(this).removeClass('disabled');
                        $(this).addClass('able active');
                    }
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                $('#regular-price').text(regular_price);
                $('#sale-price').text(sale_price);
                $('#update-stock').text(total_stock);
                $('#percent-discount').text(percent_discount);
                get_stock_variant_clicked = null;
                $('#sale-price, #regular-price, #percent-discount').hide();
                $('.reset_selected').hide();
                variant_selected = false;
            })

        });
    </script>
@endsection
