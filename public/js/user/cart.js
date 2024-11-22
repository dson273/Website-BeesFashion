function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 VND";
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

// const variantButtons = document.querySelectorAll('.btn-variant');
// const variantDefault = document.querySelectorAll('.btn-variant-default');
// const variantColors = document.querySelectorAll('.btn-color');
// variantButtons.forEach(button => {
//     button.addEventListener('click', () => {
//         variantButtons.forEach(btn => btn.classList.remove('selected'));
//         button.classList.add('selected');
//     });
// });
// variantDefault.forEach(button => {
//     button.addEventListener('click', () => {
//         variantDefault.forEach(btn => btn.classList.remove('selected'));
//         button.classList.add('selected');
//     });
// });
// variantColors.forEach(button => {
//     button.addEventListener('click', () => {
//         variantColors.forEach(btn => btn.classList.remove('selected'));
//         button.classList.add('selected');
//     });
// });

// document.addEventListener("DOMContentLoaded", function () {
//     const variantButton = document.getElementById("variantButton");
//     const variantBox = document.getElementById("variantBox");
//     const backButton = document.getElementById("backButton");

//     // Hàm hiển thị box dưới nút
//     variantButton.addEventListener("click", function (event) {
//         event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
//         const rect = variantButton.getBoundingClientRect();

//         // Cập nhật vị trí của variantBox ngay dưới nút
//         variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//         variantBox.style.left = `${rect.left + window.scrollX}px`;

//         variantBox.classList.toggle("active"); // Hiển thị box
//     });

//     // Đóng box khi nhấn nút "Trở lại"
//     backButton.addEventListener("click", function () {
//         variantBox.classList.remove("active");
//     });

//     // Đóng box khi nhấn ra ngoài
//     document.addEventListener("click", function (event) {
//         if (!variantBox.contains(event.target) && !variantButton.contains(event.target)) {
//             variantBox.classList.remove("active");
//         }
//     });

document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        $('#total-payment').text("0đ");
        $('#total-discount').text("0đ");
        $('#total-price').text("0đ");
        $('#cart-details span').text('(0 Sản phẩm)'); 
        $(document).on('change', '.product_checkbox', function () {
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
                const totalItemPrice = regularPrice * quantity;  // Sử dụng salePrice thay vì regularPrice, vì có thể đang áp dụng giảm giá
                const itemDiscount = regularPrice - salePrice;   // Giảm giá sản phẩm (regularPrice - salePrice)
                // Cộng vào tổng tiền và tổng giảm giá
                totalPayment += totalItemPrice;
                totalDiscount += itemDiscount * quantity;  // Giảm giá cho mỗi sản phẩm, nhân với số lượng
                $(this).find('#total-price').text(formatCurrency(totalItemPrice));  // Cập nhật tổng giá cho dòng sản phẩm
            } else {
                $(this).find('#total-price').text('0đ');  // Cập nhật giá thành 0đ nếu không được chọn
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

    $('#check_out').on('click', function(){
        var selected_cart_item = false;
        $('.product_checkbox').each(function(){
            if($(this).prop('checked')){
                selected_cart_item = true;
            }
        })

        if (selected_cart_item) {
            console.log(selected_cart_item);
        }else{
            notification('warning', ' Vui lòng chọn sản phẩm cần thanh toán!', 'Warning!', '2000');
        }
    })
});

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

//hiển thị form thay đổi của biến thể sản phẩm
// const variantButton = document.getElementById("variantButton");
// const variantBox = document.getElementById("variantBox");
// const backButton = document.getElementById("backButton");

// // Hàm hiển thị box dưới nút
// variantButton.addEventListener("click", function (event) {
//     event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
//     const rect = variantButton.getBoundingClientRect();

//     // Cập nhật vị trí của variantBox ngay dưới nút
//     variantBox.style.top = `${rect.bottom + window.scrollY}px`;
//     variantBox.style.left = `${rect.left + window.scrollX}px`;

//     variantBox.classList.toggle("active"); // Hiển thị box
// });

// // Đóng box khi nhấn nút "Trở lại"
// backButton.addEventListener("click", function () {
//     variantBox.classList.remove("active");
// });

// // Đóng box khi nhấn ra ngoài
// document.addEventListener("click", function (event) {
//     if (!variantBox.contains(event.target) && !variantButton.contains(event.target)) {
//         variantBox.classList.remove("active");
//     }
// });