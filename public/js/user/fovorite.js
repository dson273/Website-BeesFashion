function loadAllProducts() {
    $.ajax({
        url: '/api/favorite', // Đảm bảo URL đúng và chính xác
        method: 'GET',
        success: function(response) {
            // Kiểm tra dữ liệu trả về từ API, giả sử API trả về key "favorites"
            const products = response.favorites; // Danh sách sản phẩm yêu thích
            console.log(products);
            renderProducts(products); // Hàm render để hiển thị sản phẩm
        },
        error: function(error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}

$(document).ready(function () {


    loadAllProducts(); // Gọi một lần khi trang được tải
});
function renderProducts(products) {
    const productGrid = $('.grid-section');
    productGrid.empty(); // Xóa nội dung hiện tại
    

    if (!Array.isArray(products) || products.length === 0) {
        productGrid.html(`
            
                <div>
                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/search/a60759ad1dabe909c46a.png" alt="timmm" >
                    <p >Hic. Không có sản phẩm nào. Bạn thử thêm sản phẩm yêu thích nhé?</p>
                </div>
            
        `);
        return;
    }
    

    products.forEach(product => {
        const minPrice = product.variant_sale_price_min !== null
            ? Number(product.variant_sale_price_min).toLocaleString()
            : "N/A";
        const maxPrice = product.variant_sale_price_max !== null
            ? Number(product.variant_sale_price_max).toLocaleString()
            : "N/A";

        const displayPrice = minPrice === maxPrice ? `$${minPrice}` : `$${minPrice} - $${maxPrice}`;
        const productHTML = `
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
                                        <h6>${product.name}</h6>
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
        `;
        productGrid.append(productHTML); // Thêm sản phẩm vào lưới
    });
}

