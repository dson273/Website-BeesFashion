function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 VND";
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
document.addEventListener("DOMContentLoaded", function () {
        $('#total-payment').text("0₫");
        $('#total-discount').text("0₫");
        $('#total-price').text("0₫");
        $('#cart-progress span').text('(0 Sản phẩm)');
        $(document).on('change', '.product_checkbox', function () {
            var selectedAll = true;
            $('.product_checkbox').each(function () {
                if (!$(this).prop('checked')) {
                    selectedAll = false;
                }
            })
            if (selectedAll) {
                $('#selectAllCheckbox').prop('checked', true);
            } else {
                $('#selectAllCheckbox').prop('checked', false);
            }
            updateTotalPrice();
            updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
        });

        // Lắng nghe sự thay đổi số lượng của sản phẩm
        $(document).on('input', '.quantity-input', function () {
            updateTotalPrice();
        });

        // Chọn tất cả checkbox
        $('#selectAllCheckbox').change(function () {
            var isChecked = $(this).prop('checked');
            $('.product_checkbox').prop('checked', isChecked);
            updateTotalPrice();
            updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
        });
   

    $('.quantity_btn_plus').click(async function () {
        var btn_plus = $(this);
        var quantity = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').val());
        var product_variant_id = parseFloat(btn_plus.closest('tr').attr('data-variant-id'));
        var cart_id = parseFloat(btn_plus.closest('tr').attr('data-cart-id'));
        var stock_of_variant = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').attr('data-stock'));
        var new_quantity = quantity + 1;
        if (new_quantity > stock_of_variant) {
            notification('warning', ' Đã đạt số lượng tối đa!', 'Warning!', '2000');
        } else {
            var result = await updateQuantity(parseFloat(product_variant_id), parseFloat(cart_id), parseFloat(new_quantity), "plus");
            if (result) {
                btn_plus.closest('.quantity').find('.quantity-input').val(new_quantity);
                var price = btn_plus.closest('.quantity').find('.quantity-input').attr('data-price');
                //update total price
                btn_plus.closest('tr').find('.total-price').attr('data-price', new_quantity * price);
                btn_plus.closest('tr').find('.total-price').text(formatCurrency(new_quantity * price));
                updateTotalPrice();
                updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
            }
        }
    })
    $('.quantity_btn_minus').click(async function () {
        var btn_plus = $(this);
        var quantity = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').val());
        var product_variant_id = parseFloat(btn_plus.closest('tr').attr('data-variant-id'));
        var cart_id = parseFloat(btn_plus.closest('tr').attr('data-cart-id'));
        var new_quantity = quantity - 1;
        if (new_quantity < 1) {
            notification('warning', ' Đã đạt số lượng tối thiểu!', 'Warning!', '2000');
        } else {
            var result = await updateQuantity(parseFloat(product_variant_id), parseFloat(cart_id), parseFloat(new_quantity), "minus");
            if (result) {
                btn_plus.closest('.quantity').find('.quantity-input').val(new_quantity);
                var price = btn_plus.closest('.quantity').find('.quantity-input').attr('data-price');
                //update total price
                btn_plus.closest('tr').find('.total-price').attr('data-price', new_quantity * price);
                btn_plus.closest('tr').find('.total-price').text(formatCurrency(new_quantity * price));
                updateTotalPrice();
                updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
            }
        }
    })
    // // Khởi tạo giá trị tổng tiền ngay khi tải trang
    function updateTotalPrice() {
        let totalPayment = 0;
        let totalDiscount = 0;
        $('.cart_item').each(function () {
            const checkbox = $(this).find('.product_checkbox');
            if (checkbox.prop('checked')) {
                var regularPrice = parseFloat($(this).attr('data-regular-price'));  // Sử dụng .attr() để lấy giá trị của data attributes
                var salePrice = parseFloat($(this).attr('data-sale-price'));
                const quantity = parseInt($(this).find('.quantity-input').val());  // Lấy số lượng từ phần tử quantity-input trong .cart_item
                // Tính toán tổng tiền cho sản phẩm này (total-payment)
                console.log(quantity);
                const totalItemPrice = regularPrice * quantity;  // Sử dụng salePrice thay vì regularPrice, vì có thể đang áp dụng giảm giá
                const itemDiscount = regularPrice - salePrice;   // Giảm giá sản phẩm (regularPrice - salePrice)
                // Cộng vào tổng tiền và tổng giảm giá
                if (itemDiscount) {
                    totalPayment += totalItemPrice;
                    totalDiscount += itemDiscount * quantity;  // Giảm giá cho mỗi sản phẩm, nhân với số lượng
                } else {
                    totalPayment += totalItemPrice;
                    totalDiscount = 0;  // Giảm giá cho mỗi sản phẩm, nhân với số lượng

                }
                $(this).find('#total-price').text(formatCurrency(totalItemPrice));  // Cập nhật tổng giá cho dòng sản phẩm
            } else {
                $(this).find('#total-price').text('0₫');  // Cập nhật giá thành 0₫ nếu không được chọn
            }
        });
        // Cập nhật các giá trị tổng trong giao diện người dùng
        $('#total-payment').text(formatCurrency(totalPayment));
        $('#total-discount').text(formatCurrency(totalDiscount));

        const totalPrice = totalPayment - totalDiscount;
        $('#total-price').text(formatCurrency(totalPrice));  // Cập nhật tổng tiền cuối cùng
    }
    function updateCartItemCount() {
        var selectedItemsCount = $('.product_checkbox:checked').length;  // Đếm số sản phẩm đã chọn
        $('.cart-progress span').text('(' + selectedItemsCount + ' Sản phẩm)');  // Cập nhật số lượng sản phẩm vào giao diện
    }

    $('#check_out').on('click', function () {
        var selected_cart_item = false;
        $('.product_checkbox').each(function () {
            if ($(this).prop('checked')) {
                selected_cart_item = true;
            }
        })

        if (selected_cart_item) {
            var cart_ids = [];
            $('.cart_item').each(function () {
                var product_item = $(this);
                if (product_item.find('.product_checkbox').prop('checked')) {
                    var cart_id = product_item.data('cart-id');
                    cart_ids.push(cart_id);
                }
            })
            if (cart_ids.length > 0) {
                console.log(cart_ids);
                $('#input_post_data_to_check_out').val(cart_ids);
                $('#is_cart').val(true);
                $('#form_post_data_to_check_out').submit();
            }
        } else {
            notification('warning', ' Vui lòng chọn sản phẩm cần thanh toán!', 'Warning!', '2000');
        }
    })


});

//xóa tất cả những sản phẩm trong giỏ hàng
document.getElementById('clearAllButton').addEventListener('click', function (event) {
    event.preventDefault(); // Ngừng gửi form ngay lập tức
    const confirmation = confirm("Bạn chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?");
    if (confirmation) {
        document.getElementById('clearAllForm').submit(); // Nếu xác nhận, gửi form
    }
});
async function updateQuantity(product_variant_id, cart_id, new_quantity, change_type) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeUpdateQuantity,
            method: "POST",
            data: {
                _token: csrf,
                new_quantity: new_quantity,
                product_variant_id: product_variant_id,
                cart_id: cart_id,
                change_type: change_type
            },
            success: function (response) {
                if (response.status == 200) {
                    resolve(true);
                } else {
                    notification('warning', response.message, 'Warning!', 2000);
                    resolve(false);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Unable to get catalog data!', 'Error');
                reject();
            }
        });
    })
}


$(document).ready(function () {
    const variantBox = document.getElementById("variantBox");
    const backButton = document.getElementById("backButton");
    const confirmButton = document.getElementById("confirmButton");

    let selectedVariantId = null; // ID biến thể được chọn
    let variants = []; // Danh sách biến thể
    let cartId = null; // ID giỏ hàng của sản phẩm hiện tại

    // Hiển thị hộp chọn biến thể
    $(document).on('click', '.variant-button', function (event) {
        event.stopPropagation();
        const button = $(this);
        const rect = button[0].getBoundingClientRect();
        variantBox.style.top = `${rect.bottom + window.scrollY}px`;
        variantBox.style.left = `${rect.left + window.scrollX}px`;
        variantBox.classList.add("active");

        cartId = button.closest('tr').data('cart-id'); // Lấy ID giỏ hàng
        const productId = button.closest('tr').data('product-id');
        const currentVariantId = button.closest('tr').data('variant-id');

        // Gọi API để lấy danh sách biến thể
        $.ajax({
            url: `/cart/product/${productId}/variants`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    variants = response.variants; // Lưu danh sách biến thể
                    const attributeData = response.attribute_data;
                    displayAttributes(attributeData, variants, currentVariantId);
                } else {
                    console.log('Lỗi phản hồi:', response);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
            }
        });
    });


    // Đóng hộp variant khi nhấn nút "Trở lại"
    backButton.addEventListener("click", function () {
        resetDisabledVariants(); // Xóa trạng thái disabled
        variantBox.classList.remove("active");
    });

    // Đóng hộp variant khi nhấn ra ngoài
    document.addEventListener("click", function (event) {
        if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
            resetDisabledVariants(); // Xóa trạng thái disabled
            variantBox.classList.remove("active");
        }
    });

    // Hiển thị các thuộc tính của sản phẩm
    function displayAttributes(attributeData, variants, currentVariantId) {
        const attributesContainer = $('#attributesContainer');
        attributesContainer.empty(); // Xóa bỏ nội dung cũ

        if (!Array.isArray(attributeData)) {
            attributeData = Object.values(attributeData);
        }

        attributeData.forEach(function (attribute) {
            let attributeHtml = `
                <div class="attribute">
                    <h6 class="p-1">${attribute.name}:</h6>
                    <ul class="attribute-values">
                        ${attribute.attribute_values.map(function (value) {
                            const { selectedClass, disabledClass } = getVariantClasses(value, attribute, variants, currentVariantId);
                            return getAttributeHtml(value, attribute, selectedClass, disabledClass);
                        }).join('')}
                    </ul>
                </div>
            `;
            attributesContainer.append(attributeHtml);
        });

        updateDisabledVariants();
    }

    // Xác định class cho thuộc tính (selected hoặc disabled)
    function getVariantClasses(value, attribute, variants, currentVariantId) {
        let selectedClass = '';
        let disabledClass = '';
    
        variants.forEach(function (variant) {
            variant.attributes.forEach(function (attr) {
                if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
                    if (variant.stock < 1) {
                        disabledClass = 'disabled'; // Thêm class disabled nếu hết tồn kho
                    }
                    if (variant.product_variant_id === parseInt(currentVariantId)) {
                        selectedClass = 'selected'; // Thêm class selected nếu là biến thể hiện tại
                    }
                }
            });
        });
    
        return { selectedClass, disabledClass };
    }
    

    // Tạo HTML cho thuộc tính
    function getAttributeHtml(value, attribute, selectedClass, disabledClass) {
        if (/^#[0-9A-F]{6}$/i.test(value.value)) { // Nếu giá trị là màu (mã hex)
            return `
                <li class="attribute_item ${selectedClass} ${disabledClass}" title="${value.name}"
                    style="background-color: ${value.value}; border: 1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
                    data-attribute-id="${attribute.id}" data-value-id="${value.id}">
                </li>
            `;
        } else {
            return `
                <li>
                    <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;"
                        data-attribute-id="${attribute.id}" data-value-id="${value.id}">
                        ${value.name}
                    </button>
                </li>
            `;
        }
    }

    // Hàm cập nhật trạng thái disabled cho các biến thể
    function updateDisabledVariants() {
        $('.btn-variant, .attribute_item').each(function () {
            const valueId = $(this).data('value-id');
            const attributeId = $(this).data('attribute-id');
            let isAvailable = false; // Biến thể mặc định là không tồn tại
    
            // Duyệt qua danh sách variants để kiểm tra điều kiện
            variants.forEach(function (variant) {
                // Kiểm tra nếu variant có thuộc tính hiện tại và có stock > 0
                if (variant.attributes.some(attr => 
                    attr.attribute_id === attributeId && 
                    attr.value_id === valueId && 
                    variant.stock > 0)) {
                    isAvailable = true; // Có tồn kho và phù hợp với thuộc tính
                }
            });
    
            // Cập nhật class disabled dựa trên trạng thái isAvailable
            if (isAvailable) {
                $(this).removeClass('disabled'); // Không bị disabled
            } else {
                $(this).addClass('disabled'); // Bị disabled do không hợp lệ
            }
        });
    }
    


    // Xóa trạng thái disabled khỏi các nút
    function resetDisabledVariants() {
        $('.btn-variant, .attribute_item').removeClass('disabled');
    }

    // Khi nhấn nút "Xác nhận"
    // Khi nhấn nút "Xác nhận"
    confirmButton.addEventListener("click", function () {
        if (selectedVariantId && cartId) {
            // Gửi yêu cầu Ajax để cập nhật biến thể giỏ hàng
            $.ajax({
                url: `product/{product_id}/update-variant`, // Đảm bảo đường dẫn này đúng
                type: 'POST',
                data: {
                    cart_id: cartId, // ID giỏ hàng
                    variant_id: selectedVariantId, // ID biến thể đã chọn
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                success: function (response) {
                    if (response.success) {
                        notification('success', ' Sửa biến thể thành công!', 'Success!', '2000');
                        location.reload(); // Tải lại trang để cập nhật giỏ hàng
                    } else {
                        alert(response.message); // Hiển thị thông báo lỗi
                    }
                },
                error: function (xhr, status, error) {
                    notification('warning', ' Có lỗi trong quá trình chọn biến thể!', 'Warning!', '2000');
                    console.log('AJAX Error:', status, error);

                }
            });
        } else {
            alert("Vui lòng chọn một biến thể hợp lệ trước khi xác nhận.");
        }
    });

    let selectedAttributes = {}; // Lưu các lựa chọn của người dùng
    $(document).on('click', '.btn-variant, .attribute_item', function () {
        const selectedValueId = $(this).data('value-id');
        const selectedAttributeId = $(this).data('attribute-id');
    
        // Cập nhật trạng thái selected
        $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
        $(this).addClass('selected');
    
        // Cập nhật thuộc tính được chọn
        selectedAttributes[selectedAttributeId] = selectedValueId;
    
        // Tìm biến thể phù hợp với thuộc tính đã chọn
        selectedVariantId = null; // Reset lại ID biến thể
        variants.forEach(function (variant) {
            let isMatch = true;
    
            // Kiểm tra tất cả thuộc tính đã chọn
            variant.attributes.forEach(function (attr) {
                if (selectedAttributes[attr.attribute_id] !== undefined) {
                    if (selectedAttributes[attr.attribute_id] !== attr.value_id) {
                        isMatch = false;
                    }
                }
            });
    
            // Nếu tất cả thuộc tính khớp, cập nhật biến thể ID
            if (isMatch && variant.stock > 0) {
                selectedVariantId = variant.product_variant_id;
            }
        });
    
        // Cập nhật trạng thái disabled của các biến thể khác
        updateDisabledVariants();
    
        if (selectedVariantId) {
            console.log("Biến thể đã chọn:", selectedVariantId);
        } else {
            console.log("Không tìm thấy biến thể phù hợp.");
        }
    });
    

});



 








// $(document).ready(function () {
//     const variantBox = document.getElementById("variantBox");
//     const backButton = document.getElementById("backButton");
//     let selectedVariantId = null;  // Biến lưu trữ `product_variant_id` khi người dùng chọn thuộc tính
//     let variants = [];  // Mảng lưu trữ các biến thể sản phẩm (Cần khởi tạo trước khi sử dụng)

//     // Hàm hiển thị box dưới nút
//     $(document).on('click', '.variant-button', function (event) {
//         event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
//         const button = $(this);
//         const rect = button[0].getBoundingClientRect();
//         variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//         variantBox.style.left = `${rect.left + window.scrollX}px`;
//         variantBox.classList.toggle("active");

//         var cartRow = button.closest('tr');
//         var productId = cartRow.data('product-id');  // Lấy product_id từ dòng tr

//         // Lấy dữ liệu biến thể từ server
//         $.ajax({
//             url: '/product/' + productId + '/variants',  // Đảm bảo đúng URL
//             type: 'GET',
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     variants = response.variants;  // Cập nhật mảng biến thể
//                     var attribute_data = response.attribute_data;
//                     displayAttributes(attribute_data);
//                 } else {
//                     console.log('Lỗi phản hồi:', response);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('AJAX Error:', status, error);
//             }
//         });

//         // Hàm hiển thị các thuộc tính của sản phẩm
//         function displayAttributes(attribute_data) {
//             var attributesContainer = $('#attributesContainer');
//             attributesContainer.empty();  // Xóa bỏ nội dung cũ

//             if (!Array.isArray(attribute_data)) {
//                 attribute_data = Object.values(attribute_data);
//             }

//             // Hiển thị các thuộc tính của sản phẩm (ví dụ: màu sắc, kích thước)
//             attribute_data.forEach(function (attribute) {
//                 var attributeHtml = `
//                     <div class="attribute">
//                         <h6 class="p-1">${attribute.name} :</h6> 
//                         <ul class="attribute-values">
//                             ${attribute.attribute_values.map(function (value) {
//                                 return getAttributeHtml(value, attribute);
//                             }).join('')}
//                         </ul>
//                     </div>
//                 `;
//                 attributesContainer.append(attributeHtml);
//             });
//         }

//         // Hàm trả về HTML cho từng thuộc tính
//         function getAttributeHtml(value, attribute, selectedClass, disabledClass) {
//             if (/^#[0-9A-F]{6}$/i.test(value.value)) {
//                 return `
//                     <li class="attribute_item able ${selectedClass} ${disabledClass}" title="${value.name}"
//                         style="background-color: ${value.value}; border:1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
//                         value="${value.id}" data-attribute-id="${attribute.id}" data-color-name="${value.name}">
//                     </li>
//                 `;
//             } else {
//                 return `
//                     <li>
//                         <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;" data-attribute-id="${attribute.id}" data-value-id="${value.id}" value="${value.id}">
//                             ${value.name}
//                         </button>
//                     </li>
//                 `;
//             }
//         }
//     });

//     // Đóng box khi nhấn nút "Trở lại"
//     backButton.addEventListener("click", function () {
//         variantBox.classList.remove("active");
//     });

//     // Đóng box khi nhấn ra ngoài
//     document.addEventListener("click", function (event) {
//         if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
//             variantBox.classList.remove("active");
//         }
//     });

//     // Xử lý khi người dùng chọn thuộc tính
//     $(document).on('click', '.btn-variant', function () {
//         const selectedValueId = $(this).data('value-id');
//         const selectedAttributeId = $(this).data('attribute-id');
        
//         // Kiểm tra và đánh dấu thuộc tính đã chọn
//         $(this).closest('ul').find('.btn-variant').removeClass('selected');
//         $(this).addClass('selected');

//         // Tìm biến thể có `product_variant_id` tương ứng với thuộc tính đã chọn
//         updateVariantId(selectedAttributeId, selectedValueId);
//     });

//     // Xử lý khi người dùng chọn màu (dành cho màu hex)
//     $(document).on('click', '.attribute_item', function () {
//         const selectedValueId = $(this).data('value-id');
//         const selectedAttributeId = $(this).data('attribute-id');

//         // Kiểm tra và đánh dấu thuộc tính đã chọn
//         $(this).closest('ul').find('.attribute_item').removeClass('selected');
//         $(this).addClass('selected');

//         // Tìm biến thể có `product_variant_id` tương ứng với thuộc tính đã chọn
//         updateVariantId(selectedAttributeId, selectedValueId);
//     });

//     // Hàm cập nhật `product_variant_id` khi người dùng thay đổi thuộc tính
//     function updateVariantId(selectedAttributeId, selectedValueId) {
//         if (variants.length === 0) {
//             console.error("Variants is not loaded yet.");
//             return;
//         }

//         // Tìm `product_variant_id` tương ứng với các thuộc tính đã chọn
//         variants.forEach(function (variant) {
//             const selectedAttributes = variant.attributes.map(attr => attr.value_id);
//             if (selectedAttributes.includes(selectedValueId)) {
//                 selectedVariantId = variant.product_variant_id;
//             }
//         });

//         // Cập nhật `selectedVariantId` trong giao diện hoặc giỏ hàng
//         console.log("Selected Variant ID: ", selectedVariantId);

//         // Cập nhật giỏ hàng với `selectedVariantId` mới
//         if (selectedVariantId) {
//             const cartRow = $('.cart_item[data-cart-id=' + selectedVariantId + ']');
//             cartRow.data('variant-id', selectedVariantId);
//             cartRow.find('.quantity-input').val(1); // Cập nhật số lượng
//             updateCartRow(cartRow, selectedVariantId);
//         }
//     }

//     // Cập nhật thông tin giỏ hàng (ví dụ: số lượng và giá tiền)
//     function updateCartRow(cartRow, variantId) {
//         $.ajax({
//             url: '/cart/update-variant',  // Đảm bảo URL trùng với route bạn đã tạo
//             type: 'POST',
//             data: {
//                 _token: $('meta[name="csrf-token"]').attr('content'),
//                 variant_id: variantId,
//                 cart_id: cartRow.data('cart-id'),
//                 quantity: cartRow.find('.quantity-input').val()
//             },
//             success: function (response) {
//                 if (response.success) {
//                     cartRow.find('.total-price').text(response.new_total + 'đ');
//                     alert(response.message);
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('AJAX Error:', status, error);
//             }
//         });
//     }
// });
