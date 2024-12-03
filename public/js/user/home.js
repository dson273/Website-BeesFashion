document.querySelectorAll('.copy-content').forEach(element => {
    element.addEventListener('click', function () {
        const voucherCode = this.getAttribute('data-code'); // Lấy mã voucher
        const originalText = this.textContent; // Lưu nội dung ban đầu

        // Sao chép mã vào clipboard
        navigator.clipboard.writeText(voucherCode).then(() => {
            // Hiển thị "Đã chép"
            this.textContent = this.getAttribute('data-copied-text');


            // Trả lại nội dung ban đầu sau 3 giây
            setTimeout(() => {
                this.textContent = originalText;
            }, 3000);

        }).catch(err => {
            notification('error', 'Lỗi khi sao chép: ', err);
        });
    });
});
$(document).ready(function () {
    // Khi nhấn nút giảm
    $('.reduce').on('click', function () {
        var quantity = parseInt($('#quantity').val()); // Lấy giá trị hiện tại của input
        if (quantity > 1) {
            $('#quantity').val(quantity - 1); // Giảm số lượng
        }
    });

    // Khi nhấn nút tăng
    $('.increment').on('click', function () {
        var quantity = parseInt($('#quantity').val()); // Lấy giá trị hiện tại của input
        if (quantity < 10) { // Kiểm tra xem số lượng đã bằng 10 chưa
            $('#quantity').val(quantity + 1); // Tăng số lượng
        } else {
            notification('error', 'Số lượng không thể vượt quá 10!'); // Hiển thị thông báo nếu vượt quá 10
        }
    });

    // Khi người dùng nhập trực tiếp vào input
    $('#quantity').on('input', function () {
        var quantity = parseInt($(this).val()); // Lấy giá trị từ input
        if (quantity < 1) {
            $(this).val(1); // Nếu nhập vào giá trị nhỏ hơn 1, đặt lại là 1
        } else if (quantity > 10) {
            $(this).val(10); // Nếu nhập vào giá trị lớn hơn 10, đặt lại là 10
            notification('error', 'Số lượng không thể vượt quá 10!');
        }
    });
});

$(document).on('click', '.quick-view-btn', function (event) {
    event.preventDefault();
    const productId = $(this).data('product-id');
    openQuickView(productId);
});

// Xử lý đóng modal
$(document).on('click', '#close_modal', function () {
    var attributes_container = document.getElementById('attributes-container');
    attributes_container.innerHTML = "";
})

// Hàm mở modal Quick View
function openQuickView(productId) {
    // Hiển thị modal với loading
    const modal = $('#quick-view');
    modal.modal('show');
    modal.find('#product-image').attr('src', 'path/to/loading-image.gif'); // Loading image tạm thời
    modal.find('#product-name, #product-sku, #product-price').text('Loading...');
    modal.find('.color-list, .size-list, .default-list').empty(); // Xóa dữ liệu cũ

    // Gửi yêu cầu API lấy dữ liệu chi tiết sản phẩm
    $.ajax({
        url: `/get-product-details/${productId}`,
        method: 'GET',
        success: function (response) {
            // Lưu productId vào modal
            modal.data('product-id', productId); // Lưu productId vào data của modal

            // Gọi hàm hiển thị dữ liệu sản phẩm vào modal
            displayProductDetailsInModal(response);
            initializeAttributeSelection(response);
        },
        error: function (xhr, status, error) {
            notification('error', 'Không thể tải dữ liệu sản phẩm. Vui lòng thử lại.');
            modal.modal('hide');
        }
    });
}

function processAttributes(product) {
    const groupedAttributes = {};

    // Lấy danh sách thuộc tính từ dữ liệu
    Object.values(product.array_attributes).forEach((attribute) => {
        const attributeGroup = {
            id: attribute.id,
            name: attribute.name,
            type: attribute.type,
            values: []
        };

        // Lấy các giá trị thuộc tính
        attribute.attribute_values.forEach((value) => {
            attributeGroup.values.push({
                id: value.id,
                name: value.name,
                value: value.value || null // Xử lý trường hợp không có giá trị
            });
        });

        groupedAttributes[attribute.id] = attributeGroup;
    });

    return groupedAttributes;
}

// Hàm hiển thị dữ liệu sản phẩm vào modal
function displayProductDetailsInModal(product) {
    const modal = $('#quick-view');

    // Hiển thị thông tin cơ bản
    modal.find('#product-name').text(product.name);
    modal.find('#product-sku').text(`SKU: ${product.sku}`);
    $('#btn_view_detail_of_quick_view_product').attr('href', 'productDetail/' + product.sku);
    // Lọc các biến thể có sale_price và regular_price
    const variantsWithSalePrice = product.array_variants.filter((variant) => variant.sale_price !== null);
    const variantsWithoutSalePrice = product.array_variants.filter((variant) => variant.sale_price === null);

    // Tính toán giá thấp nhất và cao nhất
    let minPrice, maxPrice;

    if (variantsWithSalePrice.length > 0) {
        minPrice = Math.min(...variantsWithSalePrice.map(variant => variant.sale_price));
        maxPrice = variantsWithoutSalePrice.length > 0
            ? Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price))
            : Math.max(...variantsWithSalePrice.map(variant => variant.sale_price));
    } else {
        minPrice = Math.min(...variantsWithoutSalePrice.map(variant => variant.regular_price));
        maxPrice = Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price));
    }

    // Hiển thị giá
    if (minPrice === maxPrice) {
        modal.find('#product-price').text(new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(minPrice));
    } else {
        modal.find('#product-price').text(new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(minPrice) + ' - ' + new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(maxPrice));
    }

    modal.find('#product-image').attr('src', product.imageUrl);

    // Cập nhật ảnh liên quan
    const swiperWrapper = modal.find('.modal-slide-2 .swiper-wrapper');
    swiperWrapper.empty();
    product.relatedImages.forEach((image) => {
        swiperWrapper.append(`
            <div class="swiper-slide">
                <img class="img-fluid" src="${image}" alt="Product Image">
            </div>
        `);
    });

    // Hiển thị các thuộc tính
    const attributesContainer = modal.find('.attributes-container');
    attributesContainer.empty();

    Object.values(product.array_attributes).forEach((attribute) => {
        let html = `
            <div class="attribute-section">
                <p>${attribute.name}:</p>
                <div class="attribute_group ${attribute.type}" data-id="${attribute.id}">
                    <ul class="${attribute.type}-variant">`;

        attribute.attribute_values.forEach((value) => {
            if (attribute.type === 'color') {
                html += `
                    <li class="attribute_item able" title="${value.name}" 
                        style="background-color: ${value.value};" 
                        data-id="${value.id}">
                    </li>`;
            } else {
                html += `
                    <li class="attribute_item able" title="${value.name}" 
                        data-id="${value.id}">
                        ${value.name}
                    </li>`;
            }
        });

        html += `
                    </ul>
                </div>
            </div>`;
        attributesContainer.append(html);
    });

    modal.modal('show');
}

// Xử lý chọn thuộc tính
function initializeAttributeSelection(product) {
    const variants = product.array_variants;
    let selectedAttributes = [];

    $(document).off('click', '.attribute_item').on('click', '.attribute_item', function (e) {
        e.preventDefault();
        if ($(this).hasClass('disabled')) return;

        const attributeValueId = $(this).data('id');
        const isSelected = $(this).hasClass('active');

        // Cập nhật trạng thái chọn thuộc tính
        if (isSelected) {
            $(this).removeClass('active');
            selectedAttributes = selectedAttributes.filter((id) => id !== attributeValueId);
        } else {
            $(this).addClass('active');
            selectedAttributes.push(attributeValueId);
        }

        // Tìm biến thể phù hợp dựa trên các thuộc tính đã chọn
        const matchingVariant = variants.find((variant) => {
            const sortedSelected = [...selectedAttributes].sort();
            const sortedVariantAttributes = [...variant.attribute_values].sort();

            return JSON.stringify(sortedSelected) === JSON.stringify(sortedVariantAttributes) && variant.stock > 0;
        });

        // Lưu variant_id nếu tìm thấy biến thể phù hợp
        if (matchingVariant) {
            selectedVariantId = matchingVariant.variant_id;
            const priceToShow = matchingVariant.sale_price || matchingVariant.regular_price;
            $('#quick-view #product-price').text(new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(priceToShow));
        } else {
            selectedVariantId = null;  // Reset nếu không tìm thấy biến thể
            // Nếu chưa chọn đủ thuộc tính, hiển thị giá mặc định
            const variantsWithSalePrice = product.array_variants.filter(variant => variant.sale_price !== null);
            const variantsWithoutSalePrice = product.array_variants.filter(variant => variant.sale_price === null);
            let minPrice, maxPrice;

            if (variantsWithSalePrice.length > 0) {
                minPrice = Math.min(...variantsWithSalePrice.map(variant => variant.sale_price));
                maxPrice = variantsWithoutSalePrice.length > 0
                    ? Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price))
                    : Math.max(...variantsWithSalePrice.map(variant => variant.sale_price));
            } else {
                minPrice = Math.min(...variantsWithoutSalePrice.map(variant => variant.regular_price));
                maxPrice = Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price));
            }

            $('#quick-view #product-price').text(
                minPrice === maxPrice
                    ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(minPrice)
                    : new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(minPrice) + ' - ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(maxPrice)
            );
        }
        // Cập nhật trạng thái các thuộc tính khả dụng
        updateAttributeStates(selectedAttributes, variants);
    });
}

// Cập nhật trạng thái thuộc tính
function updateAttributeStates(selectedAttributes, variants) {
    const availableAttributes = new Set();

    variants.forEach((variant) => {
        const isCompatible = selectedAttributes.every((id) => variant.attribute_values.includes(id));
        if (isCompatible && variant.stock > 0) {
            variant.attribute_values.forEach((id) => availableAttributes.add(id));
        }
    });

    $('.attribute_item').each(function () {
        const id = $(this).data('id');

        if (availableAttributes.has(id)) {
            // Thuộc tính khả dụng
            $(this).removeClass('disabled').addClass('able');
        } else {
            // Thuộc tính không khả dụng
            $(this).removeClass('able active').addClass('disabled');
        }
    });
}

$(document).on('click', '#add-to-cart-btn', function (event) {
    event.preventDefault();

    // Kiểm tra xem đã chọn đầy đủ thuộc tính chưa
    if (!selectedVariantId) {
        notification('warning', 'Vui lòng chọn đầy đủ thuộc tính sản phẩm!');
        return;
    }

    var quantity = $('#quantity').val(); // Lấy giá trị từ input số lượng

    // Kiểm tra giá trị số lượng hợp lệ
    if (!quantity || quantity <= 0 || isNaN(quantity)) {
        notification('warning', 'Số lượng không hợp lệ!');
        return;
    }

    addToCart(selectedVariantId, quantity);
});

function addToCart(variantId, quantity) {
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: {
            variant_id: variantId,
            quantity: quantity
        },
        success: function (response) {
            if (response.success) {
                $('.shoping-prize .cart-count').text(response.cartCount);
                var successMessage = $('#fancybox-add-to-cart');
                successMessage.removeClass('hide').addClass('show');
                $('#quantity').val(1);
                setTimeout(function () {
                    successMessage.removeClass('show').addClass('hide');
                }, 3000);
                $('#quick-view').modal('hide');
            } else {
                alert(data.message);
            }
        },
        error: function (xhr, status, error) {
            notification('warning', 'Vui lòng đăng nhập để thêm vào giỏ hàng.');
        }
    });
}
