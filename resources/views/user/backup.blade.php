<!-- Banner -->
<section class="section-space">
    <div class="custom-container container ">
        <!-- Carousel Wrapper -->
        <div id="bannerCarousel" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner ">
                <!-- Slide 1 -->
                <div class="carousel-item active  ">
                    <div class="row">
                        <a href="#">
                            <img class="img-fluid" src="{{ asset('assets/images/banner/b-1.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item  ">
                    <div class="row ">
                        <a href="#">
                            <img class="img-fluid" src="{{ asset('assets/images/banner/b-2.jpg') }}" alt="">
                        </a>
                    </div>
                </div>

            </div>
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
            </div>
            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<!-- End Banner -->
