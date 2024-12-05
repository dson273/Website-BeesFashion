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
                // console.log(quantity);
                const totalItemPrice = regularPrice * quantity;
                const itemDiscount = regularPrice - salePrice;

                if (itemDiscount > 0) {
                    totalPayment += totalItemPrice;
                    totalDiscount += itemDiscount * quantity;
                } else {
                    totalPayment += totalItemPrice;
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

// ----------------v1----------------
// $(document).ready(function () {
//     const variantBox = document.getElementById("variantBox");
//     const backButton = document.getElementById("backButton");
//     const confirmButton = document.getElementById("confirmButton");

//     let selectedVariantId = null; // ID biến thể được chọn
//     let variants = []; // Danh sách biến thể
//     let cartId = null; // ID giỏ hàng của sản phẩm hiện tại

//     // Hiển thị hộp chọn biến thể
//     $(document).on('click', '.variant-button', function (event) {
//         event.stopPropagation();
//         const button = $(this);
//         const rect = button[0].getBoundingClientRect();
//         variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//         variantBox.style.left = `${rect.left + window.scrollX}px`;
//         variantBox.classList.add("active");

//         cartId = button.closest('tr').data('cart-id'); // Lấy ID giỏ hàng
//         const productId = button.closest('tr').data('product-id');
//         const currentVariantId = button.closest('tr').data('variant-id');

//         // Gọi API để lấy danh sách biến thể
//         $.ajax({
//             url: `/cart/product/${productId}/variants`,
//             type: 'GET',
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     variants = response.variants; // Lưu danh sách biến thể
//                     const attributeData = response.attribute_data;
//                     // console.log(attributeData);

//                     displayAttributes(attributeData, variants, currentVariantId);
//                 } else {
//                     console.log('Lỗi phản hồi:', response);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('AJAX Error:', status, error);
//             }
//         });
//     });




//     // Hiển thị các thuộc tính của sản phẩm
//     function displayAttributes(attributeData, variants, currentVariantId) {
//         const attributesContainer = $('#attributes-container');
//         attributesContainer.empty(); // Xóa bỏ nội dung cũ

//         if (!Array.isArray(attributeData)) {
//             attributeData = Object.values(attributeData);
//         }

//         attributeData.forEach(function (attribute) {
//             let attributeHtml = `
//                 <div class="attribute">
//                     <h6 class="p-1">${attribute.name}:</h6>
//                     <ul class="attribute-values">
//                         ${attribute.attribute_values.map(function (value) {
//                             const { selectedClass, disabledClass } = getVariantClasses(value, attribute, variants, currentVariantId);
//                             return getAttributeHtml(value, attribute, selectedClass, disabledClass);
//                         }).join('')}
//                     </ul>
//                 </div>
//             `;
//             attributesContainer.append(attributeHtml);
//         });

//         updateDisabledVariants();
//     }


//     //-----------------v1---------------------
//     // Xác định class cho thuộc tính (selected hoặc disabled)
//     // function getVariantClasses(value, attribute, variants, currentVariantId) {
//     //     let selectedClass = '';
//     //     let disabledClass = '';

//     //     // Lưu trữ các product_variant_id đã được xử lý
//     //     const seenProductIds = new Set();
//     //     const currentVariantAttributes = {};

//     //     // Tìm thuộc tính của biến thể hiện tại
//     //     variants.forEach(function (variant) {
//     //         if (variant.product_variant_id === parseInt(currentVariantId)) {
//     //             variant.attributes.forEach(function (attr) {
//     //                 currentVariantAttributes[attr.attribute_id] = attr.value_id;
//     //             });
//     //         }
//     //     });

//     //     // Lưu trữ tất cả các thuộc tính có sẵn cho product_id hiện tại
//     //     const availableVariants = new Set();
//     //     variants.forEach(function (variant) {
//     //         if (variant.product_id === variants[0].product_id) { // Giả sử tất cả các biến thể đều có cùng product_id
//     //             variant.attributes.forEach(function (attr) {
//     //                 availableVariants.add(`${attr.attribute_id}:${attr.value_id}`);
//     //             });
//     //         }
//     //     });

//     //     variants.forEach(function (variant) {
//     //         variant.attributes.forEach(function (attr) {
//     //             // Kiểm tra xem thuộc tính có khớp với giá trị đang xem không
//     //             if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
//     //                 // Kiểm tra nếu là biến thể hiện tại (đã chọn)
//     //                 if (variant.product_variant_id === parseInt(currentVariantId)) {
//     //                     selectedClass = 'selected'; // Thêm class selected nếu là biến thể hiện tại
//     //                 }

//     //                 // Nếu biến thể đã được chọn, không cho phép disable
//     //                 if (selectedClass === 'selected') {
//     //                     return; // Dừng lại nếu đã có biến thể được chọn
//     //                 }

//     //                 // Kiểm tra xem stock có đủ hay không
//     //                 if (variant.stock < 1) {
//     //                     disabledClass = 'disabled'; // Thêm class disabled nếu hết tồn kho
//     //                 }

//     //                 // Kiểm tra các thuộc tính khác trong giỏ hàng
//     //                 const isDisabled = Object.keys(currentVariantAttributes).some(attrId => {
//     //                     return seenProductIds.has(variant.product_id) && 
//     //                            currentVariantAttributes[attrId] !== attr.value_id;
//     //                 });

//     //                 if (isDisabled) {
//     //                     disabledClass = 'disabled'; // Thêm class disabled nếu có thuộc tính khác trong giỏ hàng
//     //                 } else {
//     //                     seenProductIds.add(variant.product_id); // Lưu product_id để so sánh với các biến thể khác
//     //                 }
//     //             }
//     //         });
//     //     });

//     //     // Kiểm tra các thuộc tính không có biến thể tương ứng
//     //     const attributeValues = variants.filter(variant => variant.product_id === variants[0].product_id)
//     //             .flatMap(variant => variant.attributes)
//     //             .filter(attr => attr.attribute_id === attribute.id)
//     //             .map(attr => attr.value_id);

//     //     if (!attributeValues.includes(value.id)) {
//     //         disabledClass = 'disabled'; // Nếu giá trị không có biến thể tương ứng thì disabled
//     //     }

//     //     return { selectedClass, disabledClass };
//     // }


//     //-----------------------v2---------------------
//     // function getVariantClasses(value, attribute, variants, currentVariantId) {
//     //     let selectedClass = '';
//     //     let disabledClass = '';

//     //     // Thuộc tính của biến thể hiện tại
//     //     const currentVariantAttributes = {};

//     //     // Lấy các thuộc tính của biến thể hiện tại (nếu có)
//     //     variants.forEach(function (variant) {
//     //         if (variant.product_variant_id === parseInt(currentVariantId)) {
//     //             variant.attributes.forEach(function (attr) {
//     //                 currentVariantAttributes[attr.attribute_id] = attr.value_id;
//     //             });
//     //         }
//     //     });

//     //     // Biến thể trong giỏ hàng
//     //     const cartItems = window.cartItems || [];
//     //     const cartVariantIds = cartItems
//     //         .filter(item => item.product_id === variants[0].product_id)
//     //         .map(item => item.product_variant_id);

//     //     // Kiểm tra tính hợp lệ của giá trị đã chọn
//     //     const isValidCombination = (selectedAttributes) => {
//     //         return variants.some(variant => {
//     //             return Object.keys(selectedAttributes).every(attrId => {
//     //                 return variant.attributes.some(attr =>
//     //                     attr.attribute_id === parseInt(attrId) && attr.value_id === selectedAttributes[attrId]
//     //                 );
//     //             });
//     //         });
//     //     };

//     //     // Kiểm tra nếu giá trị thuộc biến thể hiện tại
//     //     variants.forEach(function (variant) {
//     //         const isCurrentVariant = variant.product_variant_id === parseInt(currentVariantId);

//     //         variant.attributes.forEach(function (attr) {
//     //             if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
//     //                 if (isCurrentVariant) {
//     //                     selectedClass = 'selected';
//     //                 }

//     //                 // Lưu lại các thuộc tính đã chọn
//     //                 const selectedAttributes = { ...currentVariantAttributes, [attribute.id]: value.id };

//     //                 // Kiểm tra nếu biến thể có sự kết hợp hợp lệ
//     //                 if (!isValidCombination(selectedAttributes)) {
//     //                     disabledClass = 'disabled';
//     //                 }

//     //                 const isInCart = cartVariantIds.includes(variant.product_variant_id);
//     //                 const isConflicting = Object.keys(currentVariantAttributes).some(attrId => {
//     //                     return currentVariantAttributes[attrId] !== undefined &&
//     //                         currentVariantAttributes[attrId] !== attr.value_id;
//     //                 });

//     //                 // Nếu biến thể này có trong giỏ hàng và không phải là biến thể hiện tại
//     //                 if (isInCart && !isCurrentVariant && !isConflicting) {
//     //                     disabledClass = 'disabled';
//     //                 }
//     //             }
//     //         });
//     //     });

//     //     return { selectedClass, disabledClass };
//     // }

//     //------------------------v3-------------------
//     function getVariantClasses(value, attribute, variants, currentVariantId) {
//         let selectedClass = '';
//         let disabledClass = '';

//         // Thuộc tính của biến thể hiện tại
//         const currentVariantAttributes = {};

//         // Lấy các thuộc tính của biến thể hiện tại
//         const currentVariant = variants.find(variant => variant.product_variant_id === parseInt(currentVariantId));
//         if (currentVariant) {
//             currentVariant.attributes.forEach(attr => {
//                 currentVariantAttributes[attr.attribute_id] = attr.value_id;
//             });
//         }

//         // Biến thể trong giỏ hàng
//         const cartItems = window.cartItems || [];
//         // console.log(cartItems);

//         // Lấy các biến thể khác trong giỏ hàng (cùng `product_id` nhưng khác `currentVariantId`)
//         const cartVariants = cartItems.filter(item => 
//             item.product_id === variants[0].product_id &&
//             item.variant_id !== parseInt(currentVariantId)
//         );

//         // Lấy tất cả các giá trị hợp lệ cho thuộc tính
//         const validAttributeValues = variants
//             .filter(variant => {
//                 // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính hiện tại (trừ thuộc tính đang xét)
//                 return Object.keys(currentVariantAttributes).every(attrId => {
//                     // Bỏ qua thuộc tính đang xét
//                     if (parseInt(attrId) === attribute.id) return true;
//                     return variant.attributes.some(attr =>
//                         attr.attribute_id === parseInt(attrId) &&
//                         attr.value_id === currentVariantAttributes[attrId]
//                     );
//                 });
//             })
//             .flatMap(variant => variant.attributes.filter(attr => attr.attribute_id === attribute.id))
//             .map(attr => attr.value_id);
//         // console.log(validAttributeValues);

//         // Kiểm tra nếu giá trị đang xét đã tồn tại trong giỏ hàng (disabled nếu tồn tại)
//         const isValueDisabled = cartVariants.some(cartItem => 
//             cartItem.attribute_values.some(cartAttr => 
//                 cartAttr.attribute_id === attribute.id && cartAttr.value_id === value.id
//             ) &&
//             Object.keys(currentVariantAttributes).every(attrId => {
//                 if (parseInt(attrId) === attribute.id) return true; // Bỏ qua thuộc tính hiện tại
//                 return cartItem.attribute_values.some(cartAttr => 
//                     cartAttr.attribute_id === parseInt(attrId) && 
//                     cartAttr.value_id === currentVariantAttributes[attrId]
//                 );
//             })
//         );

//         // Xác định trạng thái `disabled` và `selected`
//         if (currentVariant) {
//             currentVariant.attributes.forEach(attr => {
//                 if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
//                     selectedClass = 'selected';
//                 }
//             });
//         }

//         if (!validAttributeValues.includes(value.id) || isValueDisabled) {
//             disabledClass = 'disabled';
//         }

//         return { selectedClass, disabledClass };
//     }
//     fetchCartItems().then(() => {
//         // Tiếp tục xử lý giao diện hoặc logic liên quan đến giỏ hàng
//         console.log('Cart items loaded.');
//     });


//     // Gọi API để lấy `cart_list`
// function fetchCartItems() {
//     return fetch('/api/cart-items', {
//         method: 'GET',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             window.cartItems = data.cart_list; // Lưu dữ liệu giỏ hàng vào biến toàn cục
//             // console.log('Cart Items:', window.cartItems);
//         } else {
//             console.error('Failed to fetch cart items.');
//         }
//     })
//     .catch(error => console.error('Error fetching cart items:', error));
// }


//     // Tạo HTML cho thuộc tính
//     function getAttributeHtml(value, attribute, selectedClass, disabledClass) {
//         if (/^#[0-9A-F]{6}$/i.test(value.value)) { // Nếu giá trị là màu (mã hex)
//             return `
//                 <li class="attribute_item ${selectedClass} ${disabledClass}" title="${value.name}"
//                     style="background-color: ${value.value}; border: 1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
//                     data-attribute-id="${attribute.id}" data-value-id="${value.id}">
//                 </li>
//             `;
//         } else {
//             return `
//                 <li>
//                     <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;"
//                         data-attribute-id="${attribute.id}" data-value-id="${value.id}">
//                         ${value.name}
//                     </button>
//                 </li>
//             `;
//         }
//     }

//     // Đóng hộp variant khi nhấn nút "Trở lại"
//     backButton.addEventListener("click", function () {
//         resetDisabledVariants(); // Xóa trạng thái disabled
//         variantBox.classList.remove("active");
//     });

//     // Đóng hộp variant khi nhấn ra ngoài
//     document.addEventListener("click", function (event) {
//         if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
//             resetDisabledVariants(); // Xóa trạng thái disabled
//             variantBox.classList.remove("active");
//         }
//     });
//     // Hàm cập nhật trạng thái disabled cho các biến thể
//     function updateDisabledVariants() {
//         const selectedAttributes = {}; // Thuộc tính đã được chọn

//         // Thu thập tất cả các thuộc tính đã chọn
//         $('.btn-variant.selected, .attribute_item.selected').each(function () {
//             const attributeId = $(this).data('attribute-id');
//             const valueId = $(this).data('value-id');
//             selectedAttributes[attributeId] = valueId;
//         });

//         // Kiểm tra và cập nhật trạng thái cho từng giá trị thuộc tính
//         $('.btn-variant, .attribute_item').each(function () {
//             const valueId = $(this).data('value-id');
//             const attributeId = $(this).data('attribute-id');

//             let isAvailable = false; // Mặc định không khả dụng

//             // Duyệt qua danh sách biến thể
//             variants.forEach(function (variant) {
//                 let isMatch = true;

//                 // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính đã chọn không
//                 Object.keys(selectedAttributes).forEach(function (selectedAttributeId) {
//                     if (
//                         variant.attributes.some(attr =>
//                             attr.attribute_id === parseInt(selectedAttributeId) &&
//                             attr.value_id !== selectedAttributes[selectedAttributeId]
//                         ) === true
//                     ) {
//                         isMatch = false;
//                     }
//                 });

//                 // Nếu biến thể khớp với các thuộc tính đã chọn, kiểm tra giá trị hiện tại
//                 if (
//                     isMatch &&
//                     variant.attributes.some(attr =>
//                         attr.attribute_id === attributeId &&
//                         attr.value_id === valueId
//                     )
//                 ) {
//                     isAvailable = true; // Biến thể tồn tại và hợp lệ
//                 }
//             });

//             // Cập nhật trạng thái disabled
//             // if (isAvailable) {
//             //     $(this).removeClass('disabled'); // Có thể chọn
//             // } else {
//             //     $(this).addClass('disabled'); // Không thể chọn
//             // }
//         });
//     }




//     // Xóa trạng thái disabled khỏi các nút
//     function resetDisabledVariants() {
//         $('.btn-variant, .attribute_item').removeClass('disabled');
//     }

//     // Khi nhấn nút "Xác nhận"
//     confirmButton.addEventListener("click", function () {
//         if (selectedVariantId && cartId) {
//             // Gửi yêu cầu Ajax để cập nhật biến thể giỏ hàng
//             $.ajax({
//                 url: `product/{product_id}/update-variant`, // Đảm bảo đường dẫn này đúng
//                 type: 'POST',
//                 data: {
//                     cart_id: cartId, // ID giỏ hàng
//                     variant_id: selectedVariantId, // ID biến thể đã chọn
//                     _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
//                 },
//                 success: function (response) {
//                     if (response.success) {
//                         notification('success', ' Sửa biến thể thành công!', 'Success!', '2000');
//                         location.reload(); // Tải lại trang để cập nhật giỏ hàng
//                     } else {
//                         alert(response.message); // Hiển thị thông báo lỗi
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     notification('warning', ' Có lỗi trong quá trình chọn biến thể!', 'Warning!', '2000');
//                     console.log('AJAX Error:', status, error);

//                 }
//             });
//         } else {
//             alert("Vui lòng chọn một biến thể hợp lệ trước khi xác nhận.");
//         }
//     });

//     let selectedAttributes = {}; // Lưu các lựa chọn của người dùng
//     $(document).on('click', '.btn-variant, .attribute_item', function () {
//         const selectedValueId = $(this).data('value-id');
//         const selectedAttributeId = $(this).data('attribute-id');

//         // Cập nhật trạng thái selected
//         $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
//         $(this).addClass('selected');

//         // Cập nhật thuộc tính được chọn
//         selectedAttributes[selectedAttributeId] = selectedValueId;

//         // Tìm biến thể phù hợp với thuộc tính đã chọn
//         selectedVariantId = null; // Reset lại ID biến thể
//         variants.forEach(function (variant) {
//             let isMatch = true;

//             // Kiểm tra tất cả thuộc tính đã chọn
//             variant.attributes.forEach(function (attr) {
//                 if (selectedAttributes[attr.attribute_id] !== undefined) {
//                     if (selectedAttributes[attr.attribute_id] !== attr.value_id) {
//                         isMatch = false;
//                     }
//                 }
//             });

//             // Nếu tất cả thuộc tính khớp, cập nhật biến thể ID
//             if (isMatch && variant.stock > 0) {
//                 selectedVariantId = variant.product_variant_id;
//             }
//         });

//         // Cập nhật trạng thái disabled của các biến thể khác
//         updateDisabledVariants();

//         if (selectedVariantId) {
//             console.log("Biến thể đã chọn:", selectedVariantId);
//         } else {
//             console.log("Không tìm thấy biến thể phù hợp.");
//         }
//     });


// });









//     // Hàm cập nhật trạng thái disabled cho các biến thể
//     function updateDisabledVariants() {
//         const selectedAttributes = {}; // Thuộc tính đã được chọn

//         // Thu thập tất cả các thuộc tính đã chọn
//         $('.btn-variant.selected, .attribute_item.selected').each(function () {
//             const attributeId = $(this).data('attribute-id');
//             const valueId = $(this).data('value-id');
//             selectedAttributes[attributeId] = valueId;
//         });

//         // Kiểm tra và cập nhật trạng thái cho từng giá trị thuộc tính
//         $('.btn-variant, .attribute_item').each(function () {
//             const valueId = $(this).data('value-id');
//             const attributeId = $(this).data('attribute-id');

//             let isAvailable = false; // Mặc định không khả dụng

//             // Duyệt qua danh sách biến thể
//             variants.forEach(function (variant) {
//                 let isMatch = true;

//                 // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính đã chọn không
//                 Object.keys(selectedAttributes).forEach(function (selectedAttributeId) {
//                     if (
//                         variant.attributes.some(attr =>
//                             attr.attribute_id === parseInt(selectedAttributeId) &&
//                             attr.value_id !== selectedAttributes[selectedAttributeId]
//                         ) === true
//                     ) {
//                         isMatch = false;
//                     }
//                 });

//                 // Nếu biến thể khớp với các thuộc tính đã chọn, kiểm tra giá trị hiện tại
//                 if (
//                     isMatch &&
//                     variant.attributes.some(attr =>
//                         attr.attribute_id === attributeId &&
//                         attr.value_id === valueId
//                     )
//                 ) {
//                     isAvailable = true; // Biến thể tồn tại và hợp lệ
//                 }
//             });

//             // Cập nhật trạng thái disabled
//             if (isAvailable) {
//                 $(this).removeClass('disabled'); // Có thể chọn
//             } else {
//                 $(this).addClass('disabled'); // Không thể chọn
//             }
//         });
//     }




//     // Xóa trạng thái disabled khỏi các nút
//     function resetDisabledVariants() {
//         $('.btn-variant, .attribute_item').removeClass('disabled');
//     }

//     // Khi nhấn nút "Xác nhận"
//     confirmButton.addEventListener("click", function () {
//         if (selectedVariantId && cartId) {
//             // Gửi yêu cầu Ajax để cập nhật biến thể giỏ hàng
//             $.ajax({
//                 url: `product/{product_id}/update-variant`, // Đảm bảo đường dẫn này đúng
//                 type: 'POST',
//                 data: {
//                     cart_id: cartId, // ID giỏ hàng
//                     variant_id: selectedVariantId, // ID biến thể đã chọn
//                     _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
//                 },
//                 success: function (response) {
//                     if (response.success) {
//                         notification('success', ' Sửa biến thể thành công!', 'Success!', '2000');
//                         location.reload(); // Tải lại trang để cập nhật giỏ hàng
//                     } else {
//                         alert(response.message); // Hiển thị thông báo lỗi
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     notification('warning', ' Có lỗi trong quá trình chọn biến thể!', 'Warning!', '2000');
//                     console.log('AJAX Error:', status, error);

//                 }
//             });
//         } else {
//             alert("Vui lòng chọn một biến thể hợp lệ trước khi xác nhận.");
//         }
//     });

//     let selectedAttributes = {}; // Lưu các lựa chọn của người dùng
//     $(document).on('click', '.btn-variant, .attribute_item', function () {
//         const selectedValueId = $(this).data('value-id');
//         const selectedAttributeId = $(this).data('attribute-id');

//         // Cập nhật trạng thái selected
//         $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
//         $(this).addClass('selected');

//         // Cập nhật thuộc tính được chọn
//         selectedAttributes[selectedAttributeId] = selectedValueId;

//         // Tìm biến thể phù hợp với thuộc tính đã chọn
//         selectedVariantId = null; // Reset lại ID biến thể
//         variants.forEach(function (variant) {
//             let isMatch = true;

//             // Kiểm tra tất cả thuộc tính đã chọn
//             variant.attributes.forEach(function (attr) {
//                 if (selectedAttributes[attr.attribute_id] !== undefined) {
//                     if (selectedAttributes[attr.attribute_id] !== attr.value_id) {
//                         isMatch = false;
//                     }
//                 }
//             });

//             // Nếu tất cả thuộc tính khớp, cập nhật biến thể ID
//             if (isMatch && variant.stock > 0) {
//                 selectedVariantId = variant.product_variant_id;
//             }
//         });

//         // Cập nhật trạng thái disabled của các biến thể khác
//         updateDisabledVariants();

//         if (selectedVariantId) {
//             console.log("Biến thể đã chọn:", selectedVariantId);
//         } else {
//             console.log("Không tìm thấy biến thể phù hợp.");
//         }
//     });












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








// $(document).ready(function () {
//     const variantBox = document.getElementById("variantBox");
//     const backButton = document.getElementById("backButton");
//     const confirmButton = document.getElementById("confirmButton");

//     let selectedVariantId = null; // ID biến thể được chọn
//     let variants = []; // Danh sách biến thể
//     let cartId = null; // ID giỏ hàng của sản phẩm hiện tại
//     let cartItems = []; // Dữ liệu giỏ hàng từ API

//     // Gọi API để lấy `cart_list`
//     function fetchCartItems() {
//         return fetch('/api/cart-items', {
//             method: 'GET',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 cartItems = data.cart_list; // Lưu dữ liệu giỏ hàng
//                 console.log('Cart Items:', cartItems);
//             } else {
//                 console.error('Failed to fetch cart items.');
//             }
//         })
//         .catch(error => console.error('Error fetching cart items:', error));
//     }

//     // Hiển thị hộp chọn biến thể
//     $(document).on('click', '.variant-button', function (event) {
//         event.stopPropagation();
//         const button = $(this);
//         const rect = button[0].getBoundingClientRect();
//         variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//         variantBox.style.left = `${rect.left + window.scrollX}px`;
//         variantBox.classList.add("active");

//         cartId = button.closest('tr').data('cart-id'); // Lấy ID giỏ hàng
//         const productId = button.closest('tr').data('product-id');
//         const currentVariantId = button.closest('tr').data('variant-id');

//         // Gọi API để lấy danh sách biến thể
//         $.ajax({
//             url: `/cart/product/${productId}/variants`,
//             type: 'GET',
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     variants = response.variants; // Lưu danh sách biến thể
//                     const attributeData = response.attribute_data;
//                     displayAttributes(attributeData, variants, currentVariantId);
//                 } else {
//                     console.log('Lỗi phản hồi:', response);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('AJAX Error:', status, error);
//             }
//         });
//     });

//     // Hiển thị các thuộc tính của sản phẩm
//     function displayAttributes(attributeData, variants, currentVariantId) {
//         const attributesContainer = $('#attributes-container');
//         attributesContainer.empty(); // Xóa bỏ nội dung cũ

//         if (!Array.isArray(attributeData)) {
//             attributeData = Object.values(attributeData);
//         }

//         attributeData.forEach(function (attribute) {
//             let attributeHtml = `
//                 <div class="attribute">
//                     <h6 class="p-1">${attribute.name}:</h6>
//                     <ul class="attribute-values">
//                         ${attribute.attribute_values.map(function (value) {
//                             const { selectedClass, disabledClass } = getVariantClasses(value, attribute, variants, currentVariantId);
//                             return getAttributeHtml(value, attribute, selectedClass, disabledClass);
//                         }).join('')}
//                     </ul>
//                 </div>
//             `;
//             attributesContainer.append(attributeHtml);
//         });

//         //updateDisabledVariants();
//     }

//     // Lấy trạng thái `selected` và `disabled` cho các biến thể
//     function getVariantClasses(value, attribute, variants, currentVariantId) {
//                 let selectedClass = '';
//                 let disabledClass = '';

//                 // Thuộc tính của biến thể hiện tại
//                 const currentVariantAttributes = {};

//                 // Lấy các thuộc tính của biến thể hiện tại
//                 const currentVariant = variants.find(variant => variant.product_variant_id === parseInt(currentVariantId));
//                 if (currentVariant) {
//                     currentVariant.attributes.forEach(attr => {
//                         currentVariantAttributes[attr.attribute_id] = attr.value_id;
//                     });
//                 }

//                 // Biến thể trong giỏ hàng
//                 const cartItems = window.cartItems || [];
//                 console.log(cartItems);

//                 // Lấy các biến thể khác trong giỏ hàng (cùng `product_id` nhưng khác `currentVariantId`)
//                 const cartVariants = cartItems.filter(item => 
//                     item.product_id === variants[0].product_id &&
//                     item.variant_id !== parseInt(currentVariantId)
//                 );

//                 // Lấy tất cả các giá trị hợp lệ cho thuộc tính
//                 const validAttributeValues = variants
//                     .filter(variant => {
//                         // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính hiện tại (trừ thuộc tính đang xét)
//                         return Object.keys(currentVariantAttributes).every(attrId => {
//                             // Bỏ qua thuộc tính đang xét
//                             if (parseInt(attrId) === attribute.id) return true;
//                             return variant.attributes.some(attr =>
//                                 attr.attribute_id === parseInt(attrId) &&
//                                 attr.value_id === currentVariantAttributes[attrId]
//                             );
//                         });
//                     })
//                     .flatMap(variant => variant.attributes.filter(attr => attr.attribute_id === attribute.id))
//                     .map(attr => attr.value_id);
//                 // console.log(validAttributeValues);

//                 // Kiểm tra nếu giá trị đang xét đã tồn tại trong giỏ hàng (disabled nếu tồn tại)
//                 const isValueDisabled = cartVariants.some(cartItem => 
//                     cartItem.attribute_values.some(cartAttr => 
//                         cartAttr.attribute_id === attribute.id && cartAttr.value_id === value.id
//                     ) &&
//                     Object.keys(currentVariantAttributes).every(attrId => {
//                         if (parseInt(attrId) === attribute.id) return true; // Bỏ qua thuộc tính hiện tại
//                         return cartItem.attribute_values.some(cartAttr => 
//                             cartAttr.attribute_id === parseInt(attrId) && 
//                             cartAttr.value_id === currentVariantAttributes[attrId]
//                         );
//                     })
//                 );

//                 // Xác định trạng thái `disabled` và `selected`
//                 if (currentVariant) {
//                     currentVariant.attributes.forEach(attr => {
//                         if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
//                             selectedClass = 'selected';
//                         }
//                     });
//                 }

//                 if (!validAttributeValues.includes(value.id) || isValueDisabled) {
//                     disabledClass = 'disabled';
//                 }

//                 return { selectedClass, disabledClass };
//             }

//     // Tạo HTML cho thuộc tính
//     function getAttributeHtml(value, attribute, selectedClass, disabledClass) {


//         if (/^#[0-9A-F]{6}$/i.test(value.value)) { // Nếu giá trị là màu (mã hex)
//             return `
//                 <li class="attribute_item ${selectedClass} ${disabledClass}" title="${value.name}"
//                     style="background-color: ${value.value}; border: 1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
//                     data-attribute-id="${attribute.id}" data-value-id="${value.id}">
//                 </li>
//             `;
//         } else {
//             return `
//                 <li>
//                     <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;"
//                         data-attribute-id="${attribute.id}" data-value-id="${value.id}">
//                         ${value.name}
//                     </button>
//                 </li>
//             `;
//         }
//     }

//     // Đóng hộp variant khi nhấn nút "Trở lại"
//     backButton.addEventListener("click", function () {
//         resetDisabledVariants(); // Xóa trạng thái disabled
//         variantBox.classList.remove("active");
//     });

//     // Đóng hộp variant khi nhấn ra ngoài
//     document.addEventListener("click", function (event) {
//         if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
//             resetDisabledVariants(); // Xóa trạng thái disabled
//             variantBox.classList.remove("active");
//         }
//     });

//     // Khi nhấn nút "Xác nhận"
//     confirmButton.addEventListener("click", function () {
//         if (selectedVariantId && cartId) {
//             $.ajax({
//                 url: `/cart/update-variant`, // Đảm bảo đường dẫn này đúng
//                 type: 'POST',
//                 data: {
//                     cart_id: cartId, // ID giỏ hàng
//                     variant_id: selectedVariantId, // ID biến thể đã chọn
//                     _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
//                 },
//                 success: function (response) {
//                     if (response.success) {
//                         notification('success', ' Sửa biến thể thành công!', 'Success!', '2000');
//                         location.reload(); // Tải lại trang để cập nhật giỏ hàng
//                     } else {
//                         alert(response.message); // Hiển thị thông báo lỗi
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     notification('warning', ' Có lỗi trong quá trình chọn biến thể!', 'Warning!', '2000');
//                     console.log('AJAX Error:', status, error);
//                 }
//             });
//         } else {
//             alert("Vui lòng chọn một biến thể hợp lệ trước khi xác nhận.");
//         }
//     });

//     function updateDisabledVariants() {
//             const selectedAttributes = {}; // Thuộc tính đã được chọn

//             // Thu thập tất cả các thuộc tính đã chọn
//             $('.btn-variant.selected, .attribute_item.selected').each(function () {
//                 const attributeId = $(this).data('attribute-id');
//                 const valueId = $(this).data('value-id');
//                 selectedAttributes[attributeId] = valueId;
//             });

//             // Kiểm tra và cập nhật trạng thái cho từng giá trị thuộc tính
//             $('.btn-variant, .attribute_item').each(function () {
//                 const valueId = $(this).data('value-id');
//                 const attributeId = $(this).data('attribute-id');

//                 let isAvailable = false; // Mặc định không khả dụng

//                 // Duyệt qua danh sách biến thể
//                 variants.forEach(function (variant) {
//                     let isMatch = true;

//                     // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính đã chọn không
//                     Object.keys(selectedAttributes).forEach(function (selectedAttributeId) {
//                         if (
//                             variant.attributes.some(attr =>
//                                 attr.attribute_id === parseInt(selectedAttributeId) &&
//                                 attr.value_id !== selectedAttributes[selectedAttributeId]
//                             ) === true
//                         ) {
//                             isMatch = false;
//                         }
//                     });

//                     // Nếu biến thể khớp với các thuộc tính đã chọn, kiểm tra giá trị hiện tại
//                     if (
//                         isMatch &&
//                         variant.attributes.some(attr =>
//                             attr.attribute_id === attributeId &&
//                             attr.value_id === valueId
//                         )
//                     ) {
//                         isAvailable = true; // Biến thể tồn tại và hợp lệ
//                     }
//                 });

//                 // Cập nhật trạng thái disabled
//                 if (isAvailable) {
//                     $(this).removeClass('disabled'); // Có thể chọn
//                 } else {
//                     $(this).addClass('disabled'); // Không thể chọn
//                 }
//             });
//         }




//         // Xóa trạng thái disabled khỏi các nút
//         function resetDisabledVariants() {
//             $('.btn-variant, .attribute_item').removeClass('disabled');
//         }

//     // Khởi tạo: tải dữ liệu giỏ hàng
//     fetchCartItems();
// });













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
                    // console.log(attributeData);

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

    // Hiển thị các thuộc tính của sản phẩm
    function displayAttributes(attributeData, variants, currentVariantId) {
        const attributesContainer = $('#attributes-container');
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
    }
    function getVariantClasses(value, attribute, variants, currentVariantId) {
        let selectedClass = '';
        let disabledClass = '';

        // Thuộc tính của biến thể hiện tại
        const currentVariantAttributes = {};

        // Lấy các thuộc tính của biến thể hiện tại
        const currentVariant = variants.find(variant => variant.product_variant_id === parseInt(currentVariantId));
        if (currentVariant) {
            currentVariant.attributes.forEach(attr => {
                currentVariantAttributes[attr.attribute_id] = attr.value_id;
            });
        }

        // Biến thể trong giỏ hàng
        const cartItems = window.cartItems || [];
        // console.log(cartItems);

        // Lấy các biến thể khác trong giỏ hàng (cùng `product_id` nhưng khác `currentVariantId`)
        const cartVariants = cartItems.filter(item =>
            item.product_id === variants[0].product_id &&
            item.variant_id !== parseInt(currentVariantId)
        );

        // Lấy tất cả các giá trị hợp lệ cho thuộc tính
        const validAttributeValues = variants
            .filter(variant => {
                // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính hiện tại (trừ thuộc tính đang xét)
                return Object.keys(currentVariantAttributes).every(attrId => {
                    // Bỏ qua thuộc tính đang xét
                    if (parseInt(attrId) === attribute.id) return true;
                    return variant.attributes.some(attr =>
                        attr.attribute_id === parseInt(attrId) &&
                        attr.value_id === currentVariantAttributes[attrId]
                    );
                });
            })
            .flatMap(variant => variant.attributes.filter(attr => attr.attribute_id === attribute.id))
            .map(attr => attr.value_id);
        // console.log(validAttributeValues);

        // Kiểm tra nếu giá trị đang xét đã tồn tại trong giỏ hàng (disabled nếu tồn tại)
        const isValueDisabled = cartVariants.some(cartItem =>
            cartItem.attribute_values.some(cartAttr =>
                cartAttr.attribute_id === attribute.id && cartAttr.value_id === value.id
            ) &&
            Object.keys(currentVariantAttributes).every(attrId => {
                if (parseInt(attrId) === attribute.id) return true; // Bỏ qua thuộc tính hiện tại
                return cartItem.attribute_values.some(cartAttr =>
                    cartAttr.attribute_id === parseInt(attrId) &&
                    cartAttr.value_id === currentVariantAttributes[attrId]
                );
            })
        );

        // Xác định trạng thái `disabled` và `selected`
        if (currentVariant) {
            currentVariant.attributes.forEach(attr => {
                if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
                    selectedClass = 'selected';
                }
            });
        }

        if (!validAttributeValues.includes(value.id) || isValueDisabled) {
            disabledClass = 'disabled';
        }

        return { selectedClass, disabledClass };
    }
    fetchCartItems().then(() => {
        // Tiếp tục xử lý giao diện hoặc logic liên quan đến giỏ hàng
        console.log('Cart items loaded.');
    });


    // Gọi API để lấy `cart_list`
    function fetchCartItems() {
        return fetch('/api/cart-items', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.cartItems = data.cart_list; // Lưu dữ liệu giỏ hàng vào biến toàn cục
                    // console.log('Cart Items:', window.cartItems);
                } else {
                    console.error('Failed to fetch cart items.');
                }
            })
            .catch(error => console.error('Error fetching cart items:', error));
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

    let selectedAttributes = {}; // Lưu các lựa chọn của người dùng
    //---------------------------v1------------------------
    // $(document).on('click', '.btn-variant, .attribute_item', function () {
    //     const selectedValueId = $(this).data('value-id');
    //     const selectedAttributeId = $(this).data('attribute-id');

    //     // Nếu người dùng nhấn vào giá trị đã được chọn thì không làm gì
    //     if ($(this).hasClass('selected')) {
    //         return; // Thoát sớm, không thực hiện các bước tiếp theo
    //     }

    //     // Cập nhật trạng thái selected
    //     $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
    //     $(this).addClass('selected');

    //     // Cập nhật thuộc tính được chọn
    //     selectedAttributes[selectedAttributeId] = selectedValueId;

    //     // Thu thập tất cả các giá trị đã chọn (bao gồm sẵn và mới chọn)
    //     const selectedValues = {};
    //     $('.btn-variant.selected, .attribute_item.selected').each(function () {
    //         const attrId = $(this).data('attribute-id');
    //         const valueId = $(this).data('value-id');
    //         selectedValues[attrId] = valueId; // Lưu tất cả các giá trị đã chọn vào object
    //     });

    //     console.log("Các giá trị đã chọn:", selectedValues);

    //     // Tìm biến thể phù hợp với tất cả các thuộc tính đã chọn
    //     selectedVariantId = null; // Reset lại ID biến thể

    //     // Lọc danh sách các biến thể phù hợp
    //     const matchingVariants = variants.filter(variant => {
    //         // Kiểm tra biến thể có khớp với các thuộc tính đã chọn không
    //         const isMatch = Object.keys(selectedValues).every(attrId => {
    //             return variant.attributes.some(attr =>
    //                 attr.attribute_id === parseInt(attrId) &&
    //                 attr.value_id === selectedValues[attrId]
    //             );
    //         });

    //         // Kiểm tra thêm tồn tại và tồn kho
    //         return isMatch && variant.stock > 0; // Chỉ chọn biến thể còn hàng
    //     });

    //     // Nếu tìm thấy các biến thể khớp, lấy biến thể đầu tiên
    //     if (matchingVariants.length > 0) {
    //         selectedVariantId = matchingVariants[0].product_variant_id;
    //     } else {
    //         notification('warning', ' Không tìm thấy biến thể phù hợp hoặc biến thể không còn hàng!', 'Warning!', '2000');
    //         // console.log("Không tìm thấy biến thể phù hợp hoặc biến thể không còn hàng.");
    //     }

    //     // Cập nhật trạng thái disabled của các biến thể khác (nếu cần)
    //     updateDisabledVariants();

    //     if (selectedVariantId) {
    //         console.log("Biến thể đã chọn:", selectedVariantId);
    //     } else {
    //         console.log("Không tìm thấy biến thể phù hợp.");
    //     }
    // });


    $(document).on('click', '.btn-variant, .attribute_item', function () {
        const selectedValueId = $(this).data('value-id');
        const selectedAttributeId = $(this).data('attribute-id');

        // Nếu người dùng nhấn vào giá trị đã được chọn thì không làm gì
        if ($(this).hasClass('selected')) {
            return;
        }

        // Cập nhật trạng thái selected
        $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
        $(this).addClass('selected');

        // Cập nhật thuộc tính đã chọn
        selectedAttributes[selectedAttributeId] = selectedValueId;

        // Duyệt qua tất cả các giá trị của thuộc tính khác
        $('.btn-variant, .attribute_item').each(function () {
            const currentValueId = $(this).data('value-id');
            const currentAttributeId = $(this).data('attribute-id');

            // Không kiểm tra giá trị đã được chọn
            if (selectedAttributes[currentAttributeId] === currentValueId) {
                return;
            }

            // Kiểm tra xem giá trị hiện tại có tồn tại trong biến thể hợp lệ
            const isAvailable = variants.some(variant => {
                // Biến thể phải còn hàng
                if (variant.stock <= 0) return false;

                // Kiểm tra nếu giá trị hiện tại nằm trong biến thể
                const hasCurrentValue = variant.attributes.some(attr =>
                    attr.attribute_id === currentAttributeId && attr.value_id === currentValueId
                );

                // Kiểm tra nếu tất cả các giá trị đã chọn khớp với biến thể
                const matchesSelected = Object.keys(selectedAttributes).every(attrId => {
                    return variant.attributes.some(attr =>
                        attr.attribute_id === parseInt(attrId) &&
                        attr.value_id === selectedAttributes[attrId]
                    );
                });

                return hasCurrentValue && matchesSelected;
            });

            // Cập nhật trạng thái disabled
            if (isAvailable) {
                $(this).removeClass('disabled');
            } else {
                $(this).addClass('disabled');
            }
        });

        // Kiểm tra biến thể hiện tại
        const matchingVariants = variants.filter(variant => {
            const matchesSelected = Object.keys(selectedAttributes).every(attrId => {
                return variant.attributes.some(attr =>
                    attr.attribute_id === parseInt(attrId) &&
                    attr.value_id === selectedAttributes[attrId]
                );
            });

            return matchesSelected && variant.stock > 0;
        });

        selectedVariantId = matchingVariants.length > 0 ? matchingVariants[0].product_variant_id : null;

        if (selectedVariantId) {
            console.log("Biến thể đã chọn:", selectedVariantId);
        } else {
            console.log("Không tìm thấy biến thể phù hợp hoặc biến thể không còn hàng.");
        }
    });











    function updateDisabledVariants() {
        const selectedAttributes = {}; // Thuộc tính đã được chọn

        // Thu thập tất cả các thuộc tính đã chọn
        $('.btn-variant.selected, .attribute_item.selected').each(function () {
            const attributeId = $(this).data('attribute-id');
            const valueId = $(this).data('value-id');
            selectedAttributes[attributeId] = valueId;
        });

        // Duyệt qua tất cả các giá trị thuộc tính
        $('.btn-variant, .attribute_item').each(function () {
            const currentValueId = $(this).data('value-id');
            const currentAttributeId = $(this).data('attribute-id');
            let isAvailable = false; // Mặc định là không khả dụng

            // Duyệt qua tất cả các biến thể để kiểm tra xem biến thể có tồn tại với các thuộc tính đã chọn và còn hàng hay không
            variants.forEach(function (variant) {
                // Kiểm tra nếu biến thể có stock > 0 và có giá trị thuộc tính đang xét

                // console.log( variant.stock);

                if (variant.stock > 0) {
                    // Kiểm tra xem biến thể có chứa giá trị thuộc tính này và khớp với các thuộc tính đã chọn không
                    let isMatch = true;
                    for (const attrId in selectedAttributes) {
                        const selectedValueId = selectedAttributes[attrId];
                        if (!variant.attributes.some(attr =>
                            attr.attribute_id === parseInt(attrId) &&
                            attr.value_id === selectedValueId
                        )) {
                            isMatch = false; // Nếu không khớp thì dừng
                            break;
                        }
                    }

                    // Nếu tất cả các thuộc tính đã chọn khớp và biến thể có tồn kho, giá trị này có sẵn
                    if (isMatch && variant.attributes.some(attr =>
                        attr.attribute_id === currentAttributeId &&
                        attr.value_id === currentValueId
                    )) {
                        isAvailable = true; // Biến thể hợp lệ
                    }
                }
            });

            // Cập nhật trạng thái disabled
            // if (isAvailable) {
            //     $(this).removeClass('disabled'); // Có thể chọn
            // } else {
            //     $(this).addClass('disabled'); // Không thể chọn
            // }
        });
    }




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

    // Xóa trạng thái disabled khỏi các nút
    function resetDisabledVariants() {
        $('.btn-variant, .attribute_item').removeClass('disabled');
    }
});



