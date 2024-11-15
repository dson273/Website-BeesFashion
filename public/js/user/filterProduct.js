function loadAllProducts() {
    $.ajax({
        url: 'api/products/all', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            console.log(products);
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
function loadBestselingProducts() {
    $.ajax({
        url: 'api/products/bestselingproduct', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            console.log(products);
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
//hiển thị thanh trượt theo giá
const onInput = (parent, e) => {
    const slides = parent.querySelectorAll("input");
    const min = parseFloat(slides[0].min);
    const max = parseFloat(slides[1].max);

    let slide1 = parseFloat(slides[0].value);
    let slide2 = parseFloat(slides[1].value);

    const percentageMin = (slide1 / (max - min)) * 100;
    const percentageMax = (slide2 / (max - min)) * 100;

    console.log("percentageMin", percentageMin, "slide1", slide1);
    parent.style.setProperty("--range-slider-value-low", percentageMin);
    parent.style.setProperty("--range-slider-value-high", percentageMax);

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

    const displayElement = parent.querySelector(".range-slider-display");
    if (displayElement) {
        displayElement.setAttribute("data-low", slide1);
        displayElement.setAttribute("data-high", slide2);
    }
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
function renderProducts(products) {
    const productGrid = $('.grid-section');
    productGrid.empty(); // Xóa nội dung hiện tại
    if (!Array.isArray(products) || products.length === 0) {
        productGrid.html(`
            <div class="justify-content-center">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/search/a60759ad1dabe909c46a.png" alt="timmm">
                <p>Hic. Không có sản phẩm nào. Bạn thử tắt điều kiện lọc và tìm lại nhé?</p>
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
        
        const displayPrice = minPrice === maxPrice ? `${minPrice}đ` : `${minPrice}đ - ${maxPrice}đ`;
        
        const productHTML = `
            <div>
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="label-2 wishlist-icon">
                                <i title="Thêm vào yêu thích" class="fa-regular fa-heart" data-bs-title="Add to Wishlist"></i>
                                <i title="Thêm vào yêu thích" class="fa-solid fa-heartt" data-bs-title="Add to Wishlist"></i>
                            </a>
                        </div>
                        <div class="product-image">
                            <a class="pro-first" href="${product.productURL}"> 
                                <img class="bg-imgd" src="${product.image_url}" alt="product">
                            </a>
                            <a class="pro-sec" href="${product.productURL}"> 
                                <img class="bg-imgd" src="${product.image_url}" alt="product">
                            </a>
                        </div>
                        <div class="cart-info-icon"> 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0">
                                <i title="Thêm vào giỏ hàng" class="fa-solid fa-cart-shopping" data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to cart"></i>
                            </a>
                            <a class="quickView" href="#" data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0" data-product-id="${product.id}">
                                <i title="Chi tiết sản phẩm" class="fa-regular fa-eye" data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-detail">
                        <a href="${product.productURL}">
                            <h6>${product.name}</h6>
                        </a>
                        <ul class="ratingd d-flex">
                            <li><p id="price-range">Giá: ${displayPrice}</p></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <div class="listing-button">
                            <a class="btn" href="cart.html">Quick Shop</a>
                        </div>
                    </div>
                </div>
            </div>            
        `;
        productGrid.append(productHTML); // Thêm sản phẩm vào lưới
    });
}


$(document).ready(function () {
    $('#filterBestSelling').on('click', function(e) {
        loadBestselingProducts();
    });

    loadAllProducts(); // Gọi một lần khi trang được tải
});

// Hàm để tải thông tin chi tiết sản phẩm khi nhấn vào "Quick View"
function loadProductDetails(productId) {
    $.ajax({
        url: `/product/${productId}`,  // Đảm bảo API URL này là đúng
        method: 'GET',
        success: function(response) {
            const product = response.product;  // Dữ liệu trả về từ API

            if (!product) {
                console.error("Không tìm thấy sản phẩm.");
                return;
            }

            // Hiển thị thông tin vào modal
            $('#modal-product-name').text(product.name);
            $('#modal-price').html(`${product.price} <del>${product.old_price}</del>`);  // Giả sử bạn có `old_price`
            $('#modal-description').text(product.description || 'Không có mô tả.');

            // Cập nhật hình ảnh
            const images = product.product_files;  // Giả sử images nằm trong `product_files`
            let imageSlides = '';
            if (images && images.length > 0) {
                images.forEach(function(image) {
                    imageSlides += `<div class="swiper-slide"><img class="bg-img" src="${image.image_url}" alt="${product.name}"></div>`;
                });
                $('#modal-images').html(imageSlides);
            } else {
                $('#modal-images').html('<div class="swiper-slide"><img class="bg-img" src="default-image.jpg" alt="No image available"></div>');
            }

            // Cập nhật các lựa chọn size
            const sizes = product.product_variants || [];
            let sizeOptions = '';
            sizes.forEach(function(variant) {
                sizeOptions += `<li><a href="#">${variant.size}</a></li>`;  // Giả sử bạn có thuộc tính `size` trong `product_variants`
            });
            $('#modal-size-box').html(sizeOptions);

            // Hiển thị modal
            $('#quick-view').modal('show');
        },
        error: function(error) {
            console.error('Error loading product details:', error);
        }
    });
}



// Sự kiện khi nhấn vào nút "Quick View"
// $(document).on('click', '[data-bs-toggle="modal"][data-bs-target="#quick-view"]', function(e) {
//     const productId = $(this).data('product-id');  // Lấy ID sản phẩm từ data-product-id
//     loadProductDetails(productId);  // Gọi hàm để tải thông tin sản phẩm vào modal
// });



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

    // Lấy giá trị màu đã chọn
    $('.color-option').on('click', function () {
        var selectedColor = $(this).data('color');
    });
    // lấy giá 
    $('.range-slider-input').on('change', function () {
        const currentMinPrice = $('#range-slider-min').val();
        const currentMaxPrice = $('#range-slider-max').val();

        // Cập nhật hiển thị giá
        $('.price-display').text(`Giá: ${currentMinPrice} - ${currentMaxPrice}`);

        // Gọi hàm filterProducts để lọc sản phẩm dựa trên giá trị thanh kéo mới
        // filterProducts(currentMinPrice, currentMaxPrice);
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
            //color: selectedColor,// Truyền màu vào
            // minPriceProduct: minPrice, // Sử dụng giá min từ thanh kéo
            // maxPriceProduct: maxPrice  // Sử dụng giá max từ thanh kéo
        },
        success: function (response) {
            // Kiểm tra cấu trúc của response để đảm bảo dữ liệu cần thiết tồn tại
            console.log("Response:", response);

            // Sử dụng default nếu không tồn tại
            // const globalMinPrice = response.data?.minPriceProduct ?? minPrice;
            // const globalMaxPrice = response.data?.maxPriceProduct ?? maxPrice;
            const products = response.listProduct || response;

            // Cập nhật lại giá trị của thanh kéo nếu cần
            // $('#range-slider-min').attr('min', globalMinPrice).attr('max', globalMaxPrice).val(minPrice);
            // $('#range-slider-max').attr('min', globalMinPrice).attr('max', globalMaxPrice).val(maxPrice);

            // Gọi hàm renderProducts và truyền vào các tham số
            // console.log(globalMinPrice, ' - ', globalMaxPrice);
            console.log("Sản phẩm sau khi lọc:", products);
            renderProducts(products); // Hiển thị sản phẩm đã lọc, globalMinPrice, globalMaxPrice
        },
        error: function (xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });

}

// document.querySelector('.wishlist-icon').addEventListener('click', function () {
//     alert(123);
//     this.classList.toggle('selected');
// });


// $(document).ready(function() {
//     // Bắt sự kiện click cho các nút "Bán chạy" và "Mới nhất"
//     $('#filterBestSelling').on('click', function() {
//         sortProducts('best_selling');
//     });

//     $('#filterNewArrivals').on('click', function() {
//         sortProducts('new_arrivals');
//     });

//     // Bắt sự kiện thay đổi giá trong dropdown
//     $('#priceSort').on('change', function() {
//         var sortOption = $(this).val();
//         sortProducts(sortOption);
//     });

//     // Hàm sắp xếp sản phẩm
//     function sortProducts(sortOption) {
//         let productsUrl = '/api/products';  // Đường dẫn API hoặc URL chứa sản phẩm
//         let sortBy = '';

//         // Kiểm tra lựa chọn
//         if (sortOption === 'best_selling') {
//             sortBy = 'best_selling';
//         } else if (sortOption === 'new_arrivals') {
//             sortBy = 'new_arrivals';
//         } else if (sortOption === 'price_asc') {
//             sortBy = 'price_asc';
//         } else if (sortOption === 'price_desc') {
//             sortBy = 'price_desc';
//         }

//         // Gọi API hoặc cập nhật lại danh sách sản phẩm
//         $.ajax({
//             url: productsUrl,
//             method: 'GET',
//             data: {
//                 sort: sortBy
//             },
//             success: function(response) {
//                 // Cập nhật giao diện với sản phẩm mới
//                 updateProductGrid(response.products);
//             },
//             error: function(error) {
//                 console.error("Có lỗi xảy ra khi tải sản phẩm", error);
//             }
//         });
//     }
// });

// function updateProductList(products) {
//     // Cập nhật DOM với danh sách sản phẩm mới
//      // Xóa danh sách sản phẩm hiện tại

//     renderProducts(products);
// }

// document.getElementById('priceSort').addEventListener('change', function() {
//     const priceSortValue = this.value;
//     const priceDefaultOption = document.querySelector('option[value="price_default"]');

//     // Kiểm tra giá trị đã chọn và ẩn/hiển thị tùy chọn 'Giá'
//     if (priceSortValue === 'price_asc' || priceSortValue === 'price_desc') {
//         // Nếu chọn "Giá Thấp - Cao" hoặc "Giá Cao - Thấp", ẩn tùy chọn "Giá"
//         priceDefaultOption.style.display = 'none';
//     } else {
//         // Nếu quay lại lựa chọn "Giá", hiển thị lại tùy chọn này
//         priceDefaultOption.style.display = 'block';
//     }
// });

//, #min-price, #max-price
// Event listeners cho các bộ lọc
$('#search-input').on('keyup', filterProducts); // Thay 'change' bằng 'keyup'
$('.custom-checkbox, .color-checkbox, .brand-checkbox').on('change', filterProducts);


