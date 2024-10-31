function loadAllProducts() {
    $.ajax({
        url: '/api/products/all', // Đường dẫn API lấy toàn bộ sản phẩm
        method: 'GET',
        success: function (response) {
            const products = response.listProduct || response;
            console.log("Toàn bộ sản phẩm:", products);
            renderProducts(products); // Hiển thị toàn bộ sản phẩm
        },
        error: function (xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });


}
$(document).ready(function () {


    loadAllProducts(); // Gọi một lần khi trang được tải
});
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
                            <img style="height: 200px"  class="bg-img " src="https://ss-images.saostar.vn/wp1200/2024/10/30/pc/1730259389067/dosztl4r5u1-hssg909fqv2-sn5t1yqglv3.JPG" alt="">
                        </a>
                            <a class="pro-sec" href="product.html">
                                <img class="bg-img" src="" alt="">
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
                        <a href="">
                            <h6>${product.name}</h6>
                        </a>
                        <p class="list-per">${product.description}</p>
                        <p>$${product.variant_price} <del>$${product.variant_price}</del></p>
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
//chọn danh mục cha thì chọn cả danh mục con
function toggleChildCategorie(parentId) {
    const isChecked = $('#category' + parentId).is(':checked');
    $('.custom-checkbox[data-parent="' + parentId + '"]').each(function () {
        $(this).prop('checked', isChecked); // Đặt trạng thái của checkbox con
    });
    filterProducts();
}


// Hàm lọc sản phẩm
function filterProducts() {
    const searchInput = $('#search-input').val();
    const selectedCategories = [];
    const minPrice = $('#min-price').val();
    const maxPrice = $('#max-price').val();

    // Thu thập danh mục đã chọn
    $('.custom-checkbox:checked').each(function () {
        selectedCategories.push($(this).val());
    });

    //lấy giá 
    $('.range-slider-input').on('input', function () {
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        // Cập nhật hiển thị giá
        $('#price-display').text(`Giá: ${minPrice} - ${maxPrice}`);

        filterProducts();
    });


    // console.log(selectedCategories);

    // Nếu không có bộ lọc nào, gọi lại để hiển thị toàn bộ sản phẩm
    if (!searchInput && selectedCategories.length === 0 && !minPrice && !maxPrice) {
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
            min_price: minPrice, // Sử dụng giá min từ thanh trượt
            max_price: maxPrice  // Sử dụng giá max từ thanh trượt
        },
        success: function (response) {
            const products = response.listProduct || response;
            console.log("Sản phẩm sau khi lọc:", products);
            renderProducts(products); // Hiển thị sản phẩm đã lọc
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

