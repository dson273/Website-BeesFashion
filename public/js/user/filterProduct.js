function loadAllProducts() {
    $.ajax({
        url: 'api/products/all', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPriceProduct; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPriceProduct; // Giá lớn nhất toàn cục

            // Gọi hàm renderProducts và truyền vào các tham số
            renderProducts(products, globalMinPrice, globalMaxPrice);

            // Hiển thị giá toàn cục
            const priceRangeElement = document.getElementById("price-range");
            priceRangeElement.innerHTML = globalMinPrice === globalMaxPrice
                ? `Giá: $${globalMinPrice}`
                : `Giá: $${globalMinPrice} - $${globalMaxPrice}`;
        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}

$(document).ready(function () {


    loadAllProducts(); // Gọi một lần khi trang được tải
});
//hiển thị thanh trượt theo giá
const onInput = (parent, e) => {
    const slides = parent.querySelectorAll("input[type='range']");
    const min = parseFloat(slides[0].min);
    const max = parseFloat(slides[1].max);

    let slide1 = parseFloat(slides[0].value);
    let slide2 = parseFloat(slides[1].value);

    // Tính phần trăm vị trí của giá trị trên thanh kéo
    const percentageMin = ((slide1 - min) / (max - min)) * 100;
    const percentageMax = ((slide2 - min) / (max - min)) * 100;

    // Đặt giá trị CSS cho thanh kéo
    parent.style.setProperty("--range-slider-value-low", percentageMin);
    parent.style.setProperty("--range-slider-value-high", percentageMax);

    // Đảm bảo slide1 <= slide2
    if (slide1 > slide2) {
        const tmp = slide2;
        slide2 = slide1;
        slide1 = tmp;

        if (e?.currentTarget === slides[0]) {
            slides[0].insertAdjacentElement("beforebegin", slides[1]);
        } else {
            slides[1].insertAdjacentElement("afterend", slides[0]);
        }
    }

    // Cập nhật hiển thị giá trị trên giao diện
    const displayElement = parent.querySelector(".range-slider-display");
    if (displayElement) {
        displayElement.setAttribute("data-low", slide1);
        displayElement.setAttribute("data-high", slide2);
    }

    // Cập nhật hiển thị giá trên thanh trượt
    $('#price-display').text(`Giá: $${slide1} - $${slide2}`);

    // Gọi hàm lọc sản phẩm
    filterProducts(slide1, slide2);
};

addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll(".range-slider").forEach((range) =>
        range.querySelectorAll("input").forEach((input) => {
            if (input.type === "range") {
                input.oninput = (e) => onInput(range, e);
                onInput(range);
            }
        })
    );
});



// Hàm hiển thị sản phẩm
function renderProducts(products, globalMinPrice, globalMaxPrice) {
    const productGrid = $('.grid-section');
    productGrid.empty(); // Xóa nội dung hiện tại

    if (!Array.isArray(products) || products.length === 0) {
        productGrid.html('<p>Không có sản phẩm nào</p>');
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
                <div>
                    <div class="product-box-3">
                        <div class="img-wrapper">
                            <div class="label-block"><a class="label-2 wishlist-icon"
                                    href="javascript:void(0)" tabindex="0"><i class="iconsax"
                                        data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Add to Wishlist"></i></a></div>
                            <div class="product-image">
                                <a class="pro-first" href="product.html"> 
                                    <img class="bg-img" src="../assets/images/product/product-3/1.jpg" alt="product">
                                </a>
                            </div>
                            <div class="cart-info-icon"> 
                                <a href="#" data-bs-toggle="modal"data-bs-target="#addtocart" tabindex="0">
                                    <i class="iconsax"data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"data-bs-title="Add to card"></i>
                                </a>
                                <a href="compare.html"tabindex="0">                                          
                                    <i class="iconsax" data-icon="arrow-up-down"aria-hidden="true" data-bs-toggle="tooltip"data-bs-title="Compare"></i>                                     
                                </a>
                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i
                                        class="iconsax" data-icon="eye" aria-hidden="true"
                                        data-bs-toggle="tooltip" data-bs-title="Quick View"></i>
                                </a>
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
                            </ul>
                            <a href="">
                                <h6>${product.name}</h6>
                            </a>
                            <p class="list-per">${product.description}</p>
                            <p id="price-range">Giá: ${displayPrice}</p>
                            <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a>
                            </div>
                        </div>
                    </div>
                </div>
        `;
        productGrid.append(productHTML); // Thêm sản phẩm vào lưới
    });

    console.log(`Giá nhỏ nhất toàn cục: $${Number(globalMinPrice).toLocaleString()}`);
    console.log(`Giá lớn nhất toàn cục: $${Number(globalMaxPrice).toLocaleString()}`);
}




//chọn danh mục cha thì chọn cả danh mục con
function toggleChildCategories(parentId) {
    const isChecked = $('#category' + parentId).is(':checked');
    // Lặp qua tất cả các checkbox danh mục con có parentId tương ứng
    $('.custom-checkbox[data-parent="' + parentId + '"]').each(function () {
        $(this).prop('checked', isChecked); // Đặt trạng thái của checkbox con giống trạng thái của cha
    });
    filterProducts();
}


// Hàm lọc sản phẩm
function filterProducts() {
    const searchInput = $('#search-input').val();
    const selectedCategories = [];
    const selectedBrands = [];
    const minPrice = $('#range-slider-min').val();
    const maxPrice = $('#range-slider-max').val();

    // Lấy các danh mục đã chọn
    $('.category-checkbox:checked').each(function () {
        selectedCategories.push($(this).val());
    });

    // Lấy các thương hiệu đã chọn
    $('.brand-checkbox:checked').each(function () {
        selectedBrands.push($(this).val());
    });

    // lấy giá 
    $('.range-slider-input').on('change', function () {
        const currentMinPrice = $('#range-slider-min').val();
        const currentMaxPrice = $('#range-slider-max').val();

        // Cập nhật hiển thị giá
        $('.price-display').text(`Giá: ${currentMinPrice} - ${currentMaxPrice}`);

        // Gọi hàm filterProducts để lọc sản phẩm dựa trên giá trị thanh kéo mới
        filterProducts(currentMinPrice, currentMaxPrice);
    });


    // console.log(selectedCategories);

    // Nếu không có bộ lọc nào, gọi lại để hiển thị toàn bộ sản phẩm
    if (!searchInput && selectedCategories.length === 0 && !minPrice && !maxPrice && selectedBrands.length === 0) {
        loadAllProducts(); // Chỉ gọi một lần
        return;
    }

    // Gửi yêu cầu Ajax với các bộ lọc
    $.ajax({
        url: '/api/products/filter',
        method: 'GET',
        data: {
            name: searchInput,
            categories: selectedCategories.join(','), // Nối các ID danh mục
            brands: selectedBrands.join(','), // Danh sách ID thương hiệu
            minPriceProduct: minPrice, // Sử dụng giá min từ thanh kéo
            maxPriceProduct: maxPrice  // Sử dụng giá max từ thanh kéo
        },
        success: function (response) {
            // Kiểm tra cấu trúc của response để đảm bảo dữ liệu cần thiết tồn tại
            console.log("Response:", response);

            // Sử dụng default nếu không tồn tại
            const globalMinPrice = response.data?.minPriceProduct ?? minPrice;
            const globalMaxPrice = response.data?.maxPriceProduct ?? maxPrice;
            const products = response.listProduct || response;

            // Cập nhật lại giá trị của thanh kéo nếu cần
            $('#range-slider-min').attr('min', globalMinPrice).attr('max', globalMaxPrice).val(minPrice);
            $('#range-slider-max').attr('min', globalMinPrice).attr('max', globalMaxPrice).val(maxPrice);

            // Gọi hàm renderProducts và truyền vào các tham số
            console.log(globalMinPrice, ' - ', globalMaxPrice);
            console.log("Sản phẩm sau khi lọc:", products);
            renderProducts(products, globalMinPrice, globalMaxPrice); // Hiển thị sản phẩm đã lọc
        },
        error: function (xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });

}




//, #min-price, #max-price
// Event listeners cho các bộ lọc
$('#search-input').on('keyup', filterProducts); // Thay 'change' bằng 'keyup'
$('.custom-checkbox, .color-checkbox, .brand-checkbox').on('change', filterProducts);

