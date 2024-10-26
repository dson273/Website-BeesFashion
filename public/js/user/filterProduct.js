// Hàm hiển thị sản phẩm
function renderProducts(products) {
    const productGrid = $('.grid-section');
    productGrid.empty(); // Xóa nội dung hiện tại

    if (products.length === 0) {
        productGrid.html('<p>Không có sản phẩm nào</p>');
        return;
    }

    products.forEach(product => {
        const productHTML = `
            <div class="col">
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="label-2 wishlist-icon" href="javascript:void(0)">
                                <i class="iconsax" data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
                            </a>
                        </div>
                        <div class="product-image">
                            <a class="pro-first" href="product.html">
                                <img class="bg-img" src="${product.image_url}" alt="${product.name}">
                            </a>
                            <a class="pro-sec" href="product.html">
                                <img class="bg-img" src="${product.image_url}" alt="${product.name}">
                            </a>
                        </div>
                        <div class="cart-info-icon">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart">
                                <i class="iconsax" data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to cart"></i>
                            </a>
                            <a href="compare.html">
                                <i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Compare"></i>
                            </a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view">
                                <i class="iconsax" data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i>
                            </a>
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
                        </ul>
                        <a href="product.html">
                            <h6>${product.name}</h6>
                        </a>
                        <p class="list-per">${product.description}</p>
                        <p>$${product.price} <del>$${product.original_price}</del></p>
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

// Hàm lọc sản phẩm
function filterProducts() {
    const searchInput = $('#search-input').val();
    const selectedCategories = [];
    const selectedColors = [];
    const minPrice = $('#min-price').val();
    const maxPrice = $('#max-price').val();

    //Hiển thị toàn bộ sản phẩm


    //Danh mục
    function toggleChildCategorie(categoryId) {
        // Lấy trạng thái của danh mục cha
        let parentCheckbox = document.getElementById('category' + categoryId);
        let isChecked = parentCheckbox.checked;
    
        // Lấy tất cả các checkbox con của danh mục cha
        let childCheckboxes = document.querySelectorAll(`input[data-parent='${categoryId}']`);
    
        // Chọn hoặc bỏ chọn tất cả các danh mục con
        childCheckboxes.forEach(function (checkbox) {
            checkbox.checked = isChecked;
            // Nếu danh mục con cũng có con, thực hiện đệ quy để chọn/bỏ chọn chúng
            toggleChildCategorie(checkbox.getAttribute('data-id'));
        });
    }


    // Thu thập các danh mục đã chọn
    $('.custom-checkbox:checked').each(function () {
        selectedCategories.push($(this).val());
    });






    // Thu thập các màu đã chọn
    $('.color-checkbox:checked').each(function () {
        selectedColors.push($(this).val());
    });


    // Gửi yêu cầu AJAX với các bộ lọc
    $.ajax({
        url: '/api/products/filter',
        method: 'GET',
        data: {
            name: searchInput,
            categories: selectedCategories,
            colors: selectedColors,
            price_range: { min: minPrice, max: maxPrice }
        },
        success: function(response) {
            const products = response.listProduct || response;
            renderProducts(products); // Hiển thị sản phẩm đã lọc
        },
        error: function(xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });
}

// Event listeners cho các bộ lọc
$('#search-input, #min-price, #max-price').on('change', filterProducts);
$('.custom-checkbox, .color-checkbox, .brand-checkbox').on('change', filterProducts);
 
 
 
 
 
 
 
 
 
 
 
 
 
//  var nameFilter = '';
// var categoryFilter = [];
// var colorFilter = [];
// var minPrice = '';
// var maxPrice = '';

// $.ajax({
//     url: '/products/filter',
//     method: 'GET',
//     data: {
//         name: nameFilter,
//         category_ids: categoryFilter,
//         colors: colorFilter,
//         price_range: { min: minPrice, max: maxPrice }
//     },
//     success: function(response) {
//         // Xử lý dữ liệu trả về
//     }
// });
