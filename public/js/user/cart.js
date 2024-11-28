function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 VND";
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
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
                var cart_id = product_item.data('cart-id');
                cart_ids.push(cart_id);
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





// $(document).ready(function () {
//     const variantBox = document.getElementById("variantBox");
//     const backButton = document.getElementById("backButton");

//     let selectedVariantId = null; // Khởi tạo selectedVariantId là null
//     let selectedColorName = ''; // Khởi tạo biến để lưu tên màu
//     // Hàm hiển thị box dưới nút
//     $(document).on('click', '.variant-button', function (event) {
//         event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
//         const button = $(this);
//         const rect = button[0].getBoundingClientRect();
//         // Cập nhật vị trí của variantBox ngay dưới nút
//         variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//         variantBox.style.left = `${rect.left + window.scrollX}px`;
//         variantBox.classList.toggle("active");
//         var productId = button.closest('tr').data('product-id'); // Lấy ID sản phẩm từ tr tương ứng

//         $.ajax({
//             url: '/product/' + productId + '/variants', // Đảm bảo đúng URL
//             type: 'GET',
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     var variants = response.variants;
//                     var attribute_data = response.attribute_data;
//                     displayAttributes(attribute_data, variants);
//                 } else {
//                     console.log('Lỗi phản hồi:', response);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.log('AJAX Error:', status, error);
//             }
//         });


//     function displayAttributes(attribute_data, variants) {
//         var attributesContainer = $('#attributesContainer');
//         var data_variant_id = parseFloat(button.closest('tr').attr('data-variant-id')); // Lấy ID của biến thể

//         attributesContainer.empty();

//         if (!Array.isArray(attribute_data)) {
//             attribute_data = Object.values(attribute_data);
//         }

//         attribute_data.forEach(function (attribute) {
//             var attributeHtml = `
//                 <div class="attribute">
//                     <h6 class="p-1">${attribute.name} :</h6> 
//                     <ul class="attribute-values">
//                         ${attribute.attribute_values.map(function (value) {
//                             var selectedClass = '';  // Mặc định không chọn
//                             var disabledClass = '';  // Mặc định không vô hiệu hóa

//                             // Kiểm tra tất cả các biến thể và xem liệu có tồn tại biến thể với giá trị thuộc tính này
//                             variants.forEach(function (variant) {
//                                 // Kiểm tra nếu biến thể có thuộc tính trùng với giá trị thuộc tính hiện tại
//                                 variant.attributes.forEach(function (attr) {
//                                     // Kiểm tra sự trùng khớp giữa thuộc tính của biến thể và giá trị thuộc tính
//                                     if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
//                                         // Kiểm tra stock của biến thể, nếu stock < 1 thì disabled class
//                                         if (variant.stock < 1) {
//                                             disabledClass = 'disabled'; // Đánh dấu disabled nếu stock < 1
//                                         }

//                                         // Đánh dấu selected nếu giá trị thuộc tính trùng với biến thể đã chọn
//                                         if (variant.product_variant_id === data_variant_id) {
//                                             selectedClass = 'selected';
//                                         }
//                                     }
//                                 });
//                             });

//                             // Kiểm tra nếu giá trị thuộc tính là màu sắc (mã màu hex)
//                             if (/^#[0-9A-F]{6}$/i.test(value.value)) {
//                                 return `
//                                     <li class="attribute_item able ${selectedClass} ${disabledClass}" title="${value.name}"
//                                         style="background-color: ${value.value}; border:1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
//                                         value="${value.id}" data-attribute-id="${attribute.id}" data-color-name="${value.name}">
//                                     </li>
//                                 `;
//                             } else {
//                                 return `
//                                     <li>
//                                         <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;" data-attribute-id="${attribute.id}" data-value-id="${value.id}" value="${value.id}">
//                                             ${value.name}
//                                         </button>
//                                     </li>
//                                 `;
//                             }
//                         }).join('')}
//                     </ul>
//                 </div>
//             `;
//             // Thêm HTML đã tạo vào container
//             attributesContainer.append(attributeHtml);
//         });

//         // Xử lý sự kiện khi người dùng chọn thuộc tính
//         $('#attributesContainer').on('click', '.btn-variant', function () {
//             var selectedValueId = $(this).data('value-id');
//             var selectedAttributeId = $(this).data('attribute-id');

//             // Kiểm tra stock của các biến thể tương ứng với thuộc tính và giá trị đã chọn
//             variants.forEach(function (variant) {
//                 variant.attributes.forEach(function (attr) {
//                     if (attr.attribute_id === selectedAttributeId && attr.value_id === selectedValueId) {
//                         // Nếu stock của biến thể nhỏ hơn 1, thêm class 'disabled'
//                         if (variant.stock < 1) {
//                             $(this).addClass('disabled'); // Vô hiệu hóa giá trị thuộc tính đã chọn
//                         } else {
//                             $(this).removeClass('disabled');
//                         }
//                     }
//                 });
//             });
//         });
//     }



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

//     // Xử lý khi chọn thuộc tính
//     $(document).on('click', '.btn-variant', function () {
//         if ($(this).hasClass('disabled')) return; // Nếu phần tử bị vô hiệu hóa thì không làm gì

//         const selectedValueId = $(this).data('value-id');
//         const selectedAttributeId = $(this).data('attribute-id');

//         // Nếu đã chọn một giá trị, bỏ chọn tất cả các giá trị trước đó
//         $(`.btn-variant[data-attribute-id=${selectedAttributeId}]`).removeClass('selected');

//         // Đánh dấu giá trị hiện tại là đã chọn
//         $(this).addClass('selected');


//     });

//     // Xử lý khi chọn màu (dành cho màu hex)
//     $(document).on('click', '.attribute_item', function () {
//         if ($(this).hasClass('disabled')) return; // Nếu phần tử bị vô hiệu hóa thì không làm gì

//         const selectedAttributeId = $(this).data('attribute-id');

//         // Nếu đã chọn một giá trị, bỏ chọn tất cả các giá trị trước đó
//         $(`.attribute_item[data-attribute-id=${selectedAttributeId}]`).removeClass('selected');

//         // Đánh dấu màu hiện tại là đã chọn
//         $(this).addClass('selected');

//     });
// });



//add



$(document).ready(function () {
    const variantBox = document.getElementById("variantBox");
    const backButton = document.getElementById("backButton");

    let selectedVariantId = null; // Khởi tạo selectedVariantId là null
    let selectedColorName = ''; // Khởi tạo biến để lưu tên màu
    // Hàm hiển thị box dưới nút
    $(document).on('click', '.variant-button', function (event) {
        event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
        const button = $(this);
        const rect = button[0].getBoundingClientRect();
        variantBox.style.top = `${rect.bottom + window.scrollY}px`;
        variantBox.style.left = `${rect.left + window.scrollX}px`;
        variantBox.classList.toggle("active");
        var productId = button.closest('tr').data('product-id'); // Lấy ID sản phẩm từ tr tương ứng
    
        $.ajax({
            url: '/product/' + productId + '/variants', // Đảm bảo đúng URL
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    var variants = response.variants;
                    var attribute_data = response.attribute_data;
                    displayAttributes(attribute_data, variants);
                } else {
                    console.log('Lỗi phản hồi:', response);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
            }
        });
    
        // Hàm hiển thị các thuộc tính của sản phẩm
        function displayAttributes(attribute_data, variants) {
            var attributesContainer = $('#attributesContainer');
            attributesContainer.empty(); // Xóa bỏ nội dung cũ
    
            if (!Array.isArray(attribute_data)) {
                attribute_data = Object.values(attribute_data);
            }
    
            attribute_data.forEach(function (attribute) {
                var attributeHtml = `
                    <div class="attribute">
                        <h6 class="p-1">${attribute.name} :</h6> 
                        <ul class="attribute-values">
                            ${attribute.attribute_values.map(function (value) {
                                var { selectedClass, disabledClass } = getVariantClasses(value, attribute, variants);
                                return getAttributeHtml(value, attribute, selectedClass, disabledClass);
                            }).join('')}
                        </ul>
                    </div>
                `;
                attributesContainer.append(attributeHtml);
            });
    
            // Xử lý sự kiện khi người dùng chọn thuộc tính
            $('#attributesContainer').on('click', '.btn-variant', function () {
                var selectedValueId = $(this).data('value-id');
                var selectedAttributeId = $(this).data('attribute-id');
    
                // Kiểm tra stock của các biến thể tương ứng với thuộc tính và giá trị đã chọn
                variants.forEach(function (variant) {
                    variant.attributes.forEach(function (attr) {
                        if (attr.attribute_id === selectedAttributeId && attr.value_id === selectedValueId) {
                            // Nếu stock của biến thể nhỏ hơn 1, thêm class 'disabled'
                            if (variant.stock < 1) {
                                $(this).addClass('disabled'); // Vô hiệu hóa giá trị thuộc tính đã chọn
                            } else {
                                $(this).removeClass('disabled');
                            }
                        }
                    });
                });
            });
        }
    
        // Hàm lấy các class cho thuộc tính
        function getVariantClasses(value, attribute, variants) {
            let selectedClass = '';  // Mặc định không chọn
            let disabledClass = '';  // Mặc định không vô hiệu hóa
    
            variants.forEach(function (variant) {
                variant.attributes.forEach(function (attr) {
                    if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
                        if (variant.stock < 1) {
                            disabledClass = 'disabled'; // Đánh dấu disabled nếu stock < 1
                        }
    
                        if (variant.product_variant_id === parseFloat(button.closest('tr').attr('data-variant-id'))) {
                            selectedClass = 'selected'; // Đánh dấu selected nếu trùng ID biến thể
                        }
                    }
                });
            });
    
            return { selectedClass, disabledClass };
        }
    
        // Hàm trả về HTML cho từng thuộc tính
        function getAttributeHtml(value, attribute, selectedClass, disabledClass) {
            if (/^#[0-9A-F]{6}$/i.test(value.value)) {
                return `
                    <li class="attribute_item able ${selectedClass} ${disabledClass}" title="${value.name}"
                        style="background-color: ${value.value}; border:1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
                        value="${value.id}" data-attribute-id="${attribute.id}" data-color-name="${value.name}">
                    </li>
                `;
            } else {
                return `
                    <li>
                        <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;" data-attribute-id="${attribute.id}" data-value-id="${value.id}" value="${value.id}">
                            ${value.name}
                        </button>
                    </li>
                `;
            }
        }
    });
    
    

    // Đóng box khi nhấn nút "Trở lại"
    backButton.addEventListener("click", function () {
        variantBox.classList.remove("active");
    });

    // Đóng box khi nhấn ra ngoài
    document.addEventListener("click", function (event) {
        if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
            variantBox.classList.remove("active");
        }
    });

    // Xử lý khi chọn thuộc tính
    $(document).on('click', '.btn-variant', function () {
        if ($(this).hasClass('disabled')) return; // Nếu phần tử bị vô hiệu hóa thì không làm gì

        const selectedValueId = $(this).data('value-id');
        const selectedAttributeId = $(this).data('attribute-id');

        // Nếu đã chọn một giá trị, bỏ chọn tất cả các giá trị trước đó
        $(`.btn-variant[data-attribute-id=${selectedAttributeId}]`).removeClass('selected');

        // Đánh dấu giá trị hiện tại là đã chọn
        $(this).addClass('selected');


    });

    // Xử lý khi chọn màu (dành cho màu hex)
    $(document).on('click', '.attribute_item', function () {
        if ($(this).hasClass('disabled')) return; // Nếu phần tử bị vô hiệu hóa thì không làm gì

        const selectedAttributeId = $(this).data('attribute-id');

        // Nếu đã chọn một giá trị, bỏ chọn tất cả các giá trị trước đó
        $(`.attribute_item[data-attribute-id=${selectedAttributeId}]`).removeClass('selected');

        // Đánh dấu màu hiện tại là đã chọn
        $(this).addClass('selected');

    });
});







