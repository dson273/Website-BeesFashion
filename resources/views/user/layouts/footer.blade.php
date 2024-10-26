    <!-- Footer -->
    <footer class="footer-layout-img">
        <section class="section-b-space footer-1">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-content">
                            <div class="footer-logo"><a href="index.html"> <img class="img-fluid"
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
                                        <li> <a class="nav" href="index.html">Home</a></li>
                                        <li> <a class="nav" href="product-select.html">Shop</a></li>
                                        <li> <a class="nav" href="about-us.html">About Us</a></li>
                                        <li> <a class="nav" href="blog.html">Blog</a></li>
                                        <li> <a class="nav" href="contact.html">Contact</a></li>
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
                                        <li> <a class="nav" href="order-success.html">Your Orders</a></li>
                                        <li> <a class="nav" href="dashboard.html">Your Account</a></li>
                                        <li> <a class="nav" href="order-tracking.html">Track Orders</a></li>
                                        <li> <a class="nav" href="wishlist.html">Your Wishlist</a></li>
                                        <li> <a class="nav" href="faq.html">Shopping FAQs</a></li>
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
                                        <li> <a class="nav" href="dashboard.html">My Account</a></li>
                                        <li> <a class="nav" href="login.html">Login/Register</a></li>
                                        <li> <a class="nav" href="cart.html">Cart</a></li>
                                        <li> <a class="nav" href="order-success.html">Order History</a></li>
                                        <li> <a class="nav" href="faq.html">Shopping FAQs</a></li>
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
                <div class="modal-body"> <img class="img-fluid" src="{{asset('assets/images/gif/question.gif')}}" alt="">
                    <h4>Confirmation</h4>
                    <p>Are you sure you want to proceed?</p>
                    <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal"
                            aria-label="Close">No</button><a class="btn" href="{{route('logout')}}">Yes</a></div>
                </div>
            </div>
        </div>
    </div>
    {{-- End logout --}}
