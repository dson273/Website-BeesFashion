//======================================Hàm gọi lại nhiều lần======================================
//-----------------Định dạng tiền tệ-----------------
function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 VND";
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
// ----------------Chuyển đổi đối tượng thành mảng-----------------
function convertObjectToArray(object) {
    if (object && !Array.isArray(object)) {
        return Object.values(object);
    }
    return object;
}
// ---------------Định dạng thời gian---------------
function formatDateTime(isoDate) {
    // Chuyển chuỗi ISO thành đối tượng Date
    let date = new Date(isoDate);

    // Lấy giờ và phút
    let hours = date.getHours().toString().padStart(2, '0');
    let minutes = date.getMinutes().toString().padStart(2, '0');

    // Lấy ngày, tháng, năm
    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Tháng bắt đầu từ 0
    let year = date.getFullYear();

    // Ghép lại thành chuỗi mong muốn
    return `${hours}:${minutes} ${day}-${month}-${year}`;
}
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const date = new Date(dateString); // Chuyển chuỗi thành đối tượng Date

    // Sử dụng Intl.DateTimeFormat để định dạng
    return new Intl.DateTimeFormat('en-US', options).format(date);
}

//Cập nhật profile
$('#edit-profile').on('hidden.bs.modal', function () {
    $('#edit-profile-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});
$(document).ready(function () {
    $('#edit-profile-form').on('submit', function (event) {
        event.preventDefault();

        // Lấy dữ liệu từ form
        let full_name = $('#edit-profile-form').find('input[name="full_name"]').val().trim();
        let phone = $('#edit-profile-form').find('input[name="phone"]').val().trim();
        let email = $('#edit-profile-form').find('input[name="email"]').val().trim();
        let _token = $('input[name="_token"]').val();
        let url = $(this).attr('action');

        // Gửi AJAX request
        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                full_name: full_name,
                phone: phone,
                email: email,
                _token: _token
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Thay đổi dữ liệu trên profile
                    $('.profile-name h6').text(email);
                    $('.profile-information li:contains("Name") p').text(response.data
                        .full_name || 'Not updated yet');
                    $('.profile-information li:contains("Phone") p').text(response.data
                        .phone || 'Not updated yet');
                    $('.profile-information li:contains("Email") p').text(response.data
                        .email);
                    $('.dashboard-user-name b').text(response.data.full_name ? response
                        .data.full_name : response.data.username);
                    // Đóng modal sau khi thành công
                    $('#edit-profile').modal('hide');
                    // Hiển thị thông báo thành công
                    notification('success', response.message, 'Successfully!');
                    // Xóa dữ liệu trong các ô input
                    $('#edit-profile-form')[0].reset();
                }
            },
            error: function (error) {
                // Xử lý lỗi trả về từ server (validation errors)
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    // Xóa các lỗi cũ
                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');
                    for (let key in errors) {
                        let input = $('input[name="' + key + '"]');
                        let errMsg = errors[key][0];
                        // Hiển thị thông báo lỗi
                        if (input.length) {
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(errMsg);
                        }
                    }
                } else {
                    console.error('Unknown error occurred');
                }
            }
        });
    });
});

//Edit password
$('#edit-password').on('hidden.bs.modal', function () {
    $('#edit-password-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});
$(document).ready(function () {
    $('#edit-password-form').on('submit', function (e) {
        e.preventDefault();
        // Lấy dữ liệu từ form
        let current_password = $('#edit-password-form').find('input[name="current_password"]').val()
            .trim();
        let new_password = $('#edit-password-form').find('input[name="new_password"]').val().trim();
        let new_password_confirmation = $('#edit-password-form').find(
            'input[name="new_password_confirmation"]').val().trim();
        let _token = $('input[name="_token"]').val();
        let url = $(this).attr('action');

        // Xóa các lỗi cũ
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');
        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                current_password: current_password,
                new_password: new_password,
                new_password_confirmation: new_password_confirmation,
                _token: _token
            },
            dataType: 'json',
            success: function (response) {
                // Đóng modal sau khi thành công
                $('#edit-password').modal('hide');
                // Hiển thị thông báo thành công
                notification('success', response.message, 'Successfully!');
                // Xóa dữ liệu trong các ô input
                $('#edit-password-form')[0].reset();
            },
            error: function (error) {
                // Xử lý lỗi trả về từ server (validation errors)
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    for (let key in errors) {
                        let input = $('input[name="' + key + '"]');
                        let errMsg = errors[key][0];

                        // Tìm phần tử chứa thông báo lỗi và đặt thông báo lỗi vào đó
                        let feedbackElement = input.siblings('.invalid-feedback');
                        if (feedbackElement.length) {
                            feedbackElement.text(errMsg);
                        } else {
                            // Nếu không tìm thấy phần tử invalid-feedback, tạo mới
                            input.after('<div class="invalid-feedback">' + errMsg +
                                '</div>');
                        }

                        input.addClass('is-invalid');
                    }
                    notification('error', error.responseJSON.errors, 'Error!');
                } else {
                    console.error('Unknown error occurred');
                }
            }
        })
    })
});

//Add address
$('#add-address').on('hidden.bs.modal', function () {
    $('#add-address-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});
$(document).ready(function () {
    $('#add-address-form').on('submit', function (event) {
        event.preventDefault();

        // Lấy dữ liệu từ form
        let full_name = $('#add-address-form').find('input[name="full_name"]').val().trim();
        let phone_number = $('#add-address-form').find('input[name="phone_number"]').val().trim();
        let address = $('#add-address-form').find('textarea[name="address"]').val().trim();
        let _token = $('input[name="_token"]').val();
        let url = $(this).attr('action');

        // Gửi AJAX request
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                full_name: full_name,
                phone_number: phone_number,
                address: address,
                _token: _token
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Đóng modal sau khi thành công
                    $('#add-address').modal('hide');
                    // Xóa dữ liệu trong các ô input
                    $('#add-address-form')[0].reset();
                    window.location.reload();
                    // Hiển thị thông báo thành công
                    notification('success', response.message, 'Successfully!');
                }
            },
            error: function (error) {
                // Xử lý lỗi trả về từ server (validation errors)
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;

                    // Xóa các thông báo lỗi cũ
                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid');

                    for (let key in errors) {
                        let input = $('input[name="' + key + '"]');
                        let textarea = $('textarea[name="' + key + '"]');
                        let errorMessage = errors[key][0];

                        // Thêm thông báo lỗi cho input
                        if (input.length) {
                            input.addClass('is-invalid');
                            let feedbackElement = input.siblings('.invalid-feedback');
                            if (feedbackElement.length) {
                                feedbackElement.text(errorMessage);
                            } else {
                                input.after('<div class="invalid-feedback">' +
                                    errorMessage + '</div>');
                            }
                        }

                        // Thêm thông báo lỗi cho textarea
                        if (textarea.length) {
                            textarea.addClass('is-invalid');
                            let feedbackElements = textarea.siblings(
                                '.invalid-feedback');
                            if (feedbackElements.length) {
                                feedbackElements.text(errorMessage);
                            } else {
                                textarea.after('<div class="invalid-feedback">' +
                                    errorMessage + '</div>');
                            }
                        }
                    }
                } else {
                    console.error('Unknown error occurred');
                }
            }

        });
    });
});

//edit address
$('#edit-address').on('hidden.bs.modal', function () {
    $('#edit-address-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});
$(document).ready(function () {
    // Mở modal và điền thông tin khi bấm "Edit"
    $('.btn_edit_address').on('click', function () {
        let addressId = $(this).data('id');
        let url = '/dashboard/edit-address/' + addressId;

        // Lấy thông tin hiện tại từ các thẻ HTML và điền vào form
        let full_name = $(this).data('full_name');
        let phone_number = $(this).data('phone_number');
        let address = $(this).data('address');

        $('#edit-address-form').find('input[name="full_name"]').val(full_name);
        $('#edit-address-form').find('input[name="phone_number"]').val(phone_number);
        $('#edit-address-form').find('textarea[name="address"]').val(address);
        $('#edit-address-form').attr('action', url);
        $('#edit-address-form').data('box', $(this).closest('.delivery-address-box'));
    });

    // Gửi form qua AJAX khi nhấn Submit
    $('#edit-address-form').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let url = $(this).attr('action');
        let addressBox = $(this).data('box');
        $.ajax({
            url: url,
            type: 'PUT',
            data: formData,
            success: function (response) {
                //Thay đổi dữ liệu trên address
                addressBox.find('.address-title').text(response.data.full_name);
                addressBox.find('.address-tag-office:contains("Address:")').next('p').text(response.data.address);
                addressBox.find('.address-tag-office:contains("Phone:")').next('p').text(response.data.phone_number);
                $('#edit-address').modal('hide');
                notification('success', response.message, 'Successfully!');
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    // Xóa lỗi cũ
                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');

                    for (let key in errors) {
                        let input = $('input[name="' + key + '"]');
                        let textarea = $('textarea[name="' + key + '"]');
                        let errorMessage = errors[key][0];

                        // Thêm thông báo lỗi cho input
                        if (input.length) {
                            input.addClass('is-invalid');
                            let feedbackElement = input.siblings('.invalid-feedback');
                            if (feedbackElement.length) {
                                feedbackElement.text(errorMessage);
                            } else {
                                input.after('<div class="invalid-feedback">' +
                                    errorMessage + '</div>');
                            }
                        }

                        // Thêm thông báo lỗi cho textarea
                        if (textarea.length) {
                            textarea.addClass('is-invalid');
                            let feedbackElements = textarea.siblings(
                                '.invalid-feedback');
                            if (feedbackElements.length) {
                                feedbackElements.text(errorMessage);
                            } else {
                                textarea.after('<div class="invalid-feedback">' +
                                    errorMessage + '</div>');
                            }
                        }
                    }
                } else {
                    console.error('Unknown error occurred');
                }
            }
        });
    });
});

//==================================ORDER==================================
var list_orders = [];
//-------Lấy dữ liệu đơn hàng từ db-------
function get_orders(status_order) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetOrders,
            method: "POST",
            data: {
                _token: csrf,
                status_order: status_order
            },
            success: function (response) {
                if (response.success) {
                    resolve(response.data);
                } else {
                    notification('error', response.message, 'Error!', 2000);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}

var urlParams = new URLSearchParams(window.location.search);
console.log(urlParams);

//=======================Kiểm tra nếu có tham số 'tab' và giá trị của nó là 'order'=========================
if (urlParams.has('tab') && urlParams.get('tab') === 'order') {
    (async function () {
        $('.container-spinner').removeClass('hidden');
        try {
            list_orders = await get_orders(0);
            list_orders = convertObjectToArray(list_orders);

            load_orders(list_orders);
        } catch (error) {
            console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    })();
}
//========================Xử lý khi click vào mục order============================
$('#order-tab').on('click', async function () {
    if (!$(this).data('clicked')) {
        $('.container-spinner').removeClass('hidden');
        try {
            var get_id = 0;
            $(this).data('clicked', true);
            $('.order_menu').each(function () {
                if ($(this).hasClass('active')) {
                    get_id = $(this).data('id');
                }
            })
            list_orders = await get_orders(get_id);
            if (list_orders && !Array.isArray(list_orders)) {
                list_orders = Object.values(list_orders);
            }
            load_orders(list_orders);
        } catch (error) {
            console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    }
})
//===============================Tải danh sách đơn hàng ra giao diện===============================
function load_orders(list_orders, status_order = 0) {
    var get_list_orders = document.getElementById('list_orders');
    get_list_orders.innerHTML = "";
    if (list_orders.length > 0) {
        list_orders.forEach(function (order_item) {
            // Tạo các phần tử
            let col12 = document.createElement('div');
            col12.classList.add('col-12', 'order_item');

            let orderBox = document.createElement('div');
            orderBox.classList.add('order-box');

            let orderContainer = document.createElement('div');
            orderContainer.classList.add('order-container');

            let orderIcon = document.createElement('div');
            orderIcon.classList.add('order-icon');
            let icon = document.createElement('i');
            icon.classList.add('iconsax');
            icon.setAttribute('data-icon', 'box');
            let couplet = document.createElement('div');
            couplet.classList.add('couplet');
            let checkIcon = document.createElement('i');
            checkIcon.classList.add('fa-solid', 'fa-check');
            couplet.appendChild(checkIcon);
            orderIcon.appendChild(icon);
            orderIcon.appendChild(couplet);

            let orderDetail = document.createElement('div');
            orderDetail.classList.add('order-detail');
            let orderTitle = document.createElement('h5');


            if (status_order != 0) {
                if (status_order == 1) {
                    orderTitle.textContent = 'Waiting for payment...';
                } else if (status_order == 2) {
                    orderTitle.textContent = 'Awaiting confirmation...';
                } else if (status_order == 3) {
                    orderTitle.textContent = 'In transit...';
                } else if (status_order == 4) {
                    orderTitle.textContent = 'Delivered';
                } else if (status_order == 5) {
                    orderTitle.textContent = 'Cancelled';
                } else {
                    orderTitle.textContent = 'Return';
                }
            } else {
                if (order_item['latest_status_id'] == 1) {
                    orderTitle.textContent = 'Waiting for payment...';
                } else if (order_item['latest_status_id'] == 2) {
                    orderTitle.textContent = 'Awaiting confirmation...';
                } else if (order_item['latest_status_id'] == 3) {
                    orderTitle.textContent = 'In transit...';
                } else if (order_item['latest_status_id'] == 4) {
                    orderTitle.textContent = 'Delivered';
                } else if (order_item['latest_status_id'] == 5) {
                    orderTitle.textContent = 'Cancelled';
                } else {
                    orderTitle.textContent = 'Return';
                }
            }

            // Chuyển chuỗi thành đối tượng Date
            const date = new Date(order_item['created_at']);

            // Định dạng ngày
            const options = { weekday: 'short', day: 'numeric', month: 'short' };
            const formattedDate = date.toLocaleDateString('en-US', options);

            let orderDate = document.createElement('p');
            orderDate.textContent = 'on ' + formattedDate;
            orderDetail.appendChild(orderTitle);
            orderDetail.appendChild(orderDate);

            orderContainer.appendChild(orderIcon);
            orderContainer.appendChild(orderDetail);

            // Tạo phần chi tiết sản phẩm
            let productOrderDetail = document.createElement('div');
            productOrderDetail.classList.add('product-order-detail');
            let productBox = document.createElement('div');
            productBox.classList.add('product-box');
            let productLink = document.createElement('a');
            productLink.setAttribute('href', 'javascript:void(0)');
            let productImage = document.createElement('img');

            var get_image_link = order_item['order_details'][0]['product_variant']['image'];
            productImage.setAttribute('src', `/uploads/products/images/${get_image_link}`);
            productImage.setAttribute('alt', '');
            productLink.appendChild(productImage);

            var get_product_name = order_item['order_details'][0]['product_variant']['product']['name'];
            var get_product_description = order_item['order_details'][0]['product_variant']['product']['description'];

            // Tạo đối tượng DOMParser để phân tích cú pháp HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(get_product_description, 'text/html');

            // Lấy nội dung văn bản trong thẻ
            const textContent = doc.body.textContent || doc.body.innerText;

            // Cắt chuỗi văn bản đến giới hạn ký tự
            const maxLength = 100;
            const truncatedText = textContent.length > maxLength
                ? textContent.substring(0, maxLength) + "..."
                : textContent;

            // Hiển thị kết quả
            let orderWrap = document.createElement('div');
            orderWrap.classList.add('order-wrap');
            let productName = document.createElement('h5');
            productName.textContent = get_product_name;
            let productDescription = document.createElement('p');
            productDescription.textContent = truncatedText;
            let productList = document.createElement('ul');
            let priceItem = document.createElement('li');
            let priceText = document.createElement('p');
            priceText.textContent = 'Price : ';
            let price = document.createElement('span');
            price.textContent = formatCurrency(order_item['total_payment']);
            priceItem.appendChild(priceText);
            priceItem.appendChild(price);

            let totalProductsItem = document.createElement('li');
            let totalProductsText = document.createElement('p');
            totalProductsText.textContent = 'Total products : ';
            let totalProducts = document.createElement('span');
            totalProducts.textContent = order_item['order_details'].length;
            totalProductsItem.appendChild(totalProductsText);
            totalProductsItem.appendChild(totalProducts);

            let orderIdItem = document.createElement('li');
            let orderIdText = document.createElement('p');
            orderIdText.textContent = 'Order Id :';
            let orderId = document.createElement('span');
            orderId.textContent = order_item['id'];
            orderIdItem.appendChild(orderIdText);
            orderIdItem.appendChild(orderId);

            productList.appendChild(priceItem);
            productList.appendChild(totalProductsItem);
            productList.appendChild(orderIdItem);

            orderWrap.appendChild(productName);
            orderWrap.appendChild(productDescription);
            orderWrap.appendChild(productList);

            productBox.appendChild(productLink);
            productBox.appendChild(orderWrap);

            productOrderDetail.appendChild(productBox);

            // Tạo phần Return Box
            let returnBox = document.createElement('div');
            returnBox.classList.add('return-box');

            let reviewBox = document.createElement('div');
            reviewBox.classList.add('review-box');
            let ratingList = document.createElement('ul');
            ratingList.classList.add('rating');
            let ratingItem = document.createElement('li');
            let starIcons = [
                ['fa-solid', 'fa-star'],
                ['fa-solid', 'fa-star'],
                ['fa-solid', 'fa-star'],
                ['fa-solid', 'fa-star-half-stroke'],
                ['fa-regular', 'fa-star']
            ];
            starIcons.forEach(iconClasses => {
                let star = document.createElement('i');
                star.classList.add(...iconClasses);
                ratingItem.appendChild(star);
            });
            ratingList.appendChild(ratingItem);
            reviewBox.appendChild(ratingList);

            let controlList = document.createElement('div');

            let detailText = document.createElement('span');
            detailText.classList.add('me-3', 'btn_view_order_detail', 'no-select');
            detailText.setAttribute('title', 'Detail');
            if (status_order != 0) {
                detailText.setAttribute('data-status_id', status_order);
            } else {
                detailText.setAttribute('data-status_id', order_item['latest_status_id']);
            }
            detailText.setAttribute('data-id', order_item['id']);
            detailText.textContent = 'Detail';
            controlList.appendChild(detailText);


            if (status_order != 0) {
                if (status_order == 1) {
                    let continuePayment = document.createElement('span');
                    continuePayment.classList.add('me-3', 'btn_continue_payment_order', 'no-select');
                    continuePayment.setAttribute('title', 'Continue Payment');
                    continuePayment.setAttribute('data-id', order_item['id']);
                    continuePayment.setAttribute('data-amount', order_item['total_payment']);
                    continuePayment.setAttribute('data-payment-method', order_item['payment_method']);
                    continuePayment.textContent = 'Continue Payment';
                    controlList.appendChild(continuePayment);

                    let cancelOrder = document.createElement('span');
                    cancelOrder.classList.add('text-danger', 'btn_cancel_order', 'no-select');
                    cancelOrder.setAttribute('data-bs-toggle', 'modal');
                    cancelOrder.setAttribute('data-bs-target', '#cancel-order-modal');
                    cancelOrder.setAttribute('title', 'Cancel');
                    cancelOrder.setAttribute('tabindex', '0');
                    cancelOrder.setAttribute('data-id', order_item['id']);
                    cancelOrder.textContent = 'Cancel';
                    controlList.appendChild(cancelOrder);
                } else if (status_order == 2) {
                    let cancelOrder = document.createElement('span');
                    cancelOrder.classList.add('text-danger', 'btn_cancel_order', 'no-select');
                    cancelOrder.setAttribute('data-bs-toggle', 'modal');
                    cancelOrder.setAttribute('data-bs-target', '#cancel-order-modal');
                    cancelOrder.setAttribute('title', 'Cancel');
                    cancelOrder.setAttribute('tabindex', '0');
                    cancelOrder.setAttribute('data-id', order_item['id']);
                    cancelOrder.textContent = 'Cancel';
                    controlList.appendChild(cancelOrder);
                } else if (status_order == 3) {
                    let cancelOrder = document.createElement('span');
                    cancelOrder.classList.add('btn_confirm_done_order', 'no-select');
                    cancelOrder.setAttribute('data-bs-toggle', 'modal');
                    cancelOrder.setAttribute('data-bs-target', '#confirm-done-order-modal');
                    cancelOrder.setAttribute('title', 'Confirm done');
                    cancelOrder.setAttribute('tabindex', '0');
                    cancelOrder.setAttribute('data-id', order_item['id']);
                    cancelOrder.textContent = 'Confirm done';
                    controlList.appendChild(cancelOrder);
                }
            } else {
                if (order_item['latest_status_id'] == 1) {
                    let continuePayment = document.createElement('span');
                    continuePayment.classList.add('me-3', 'btn_continue_payment_order', 'no-select');
                    continuePayment.setAttribute('title', 'Continue Payment');
                    continuePayment.setAttribute('data-id', order_item['id']);
                    continuePayment.setAttribute('data-amount', order_item['total_payment']);
                    continuePayment.setAttribute('data-payment-method', order_item['payment_method']);
                    continuePayment.textContent = 'Continue Payment';
                    controlList.appendChild(continuePayment);

                    let cancelOrder = document.createElement('span');
                    cancelOrder.classList.add('text-danger', 'btn_cancel_order', 'no-select');
                    cancelOrder.setAttribute('data-bs-toggle', 'modal');
                    cancelOrder.setAttribute('data-bs-target', '#cancel-order-modal');
                    cancelOrder.setAttribute('title', 'Cancel');
                    cancelOrder.setAttribute('tabindex', '0');
                    cancelOrder.setAttribute('data-id', order_item['id']);
                    cancelOrder.textContent = 'Cancel';
                    controlList.appendChild(cancelOrder);
                } else if (order_item['latest_status_id'] == 2) {
                    let cancelOrder = document.createElement('span');
                    cancelOrder.classList.add('text-danger', 'btn_cancel_order', 'no-select');
                    cancelOrder.setAttribute('data-bs-toggle', 'modal');
                    cancelOrder.setAttribute('data-bs-target', '#cancel-order-modal');
                    cancelOrder.setAttribute('title', 'Cancel');
                    cancelOrder.setAttribute('tabindex', '0');
                    cancelOrder.setAttribute('data-id', order_item['id']);
                    cancelOrder.textContent = 'Cancel';
                    controlList.appendChild(cancelOrder);
                }
            }

            reviewBox.appendChild(controlList);


            let exchangeText = document.createElement('h6');
            exchangeText.textContent = '* Exchange/Return window closed on 20 Dec';

            returnBox.appendChild(reviewBox);
            returnBox.appendChild(exchangeText);

            // Thêm tất cả vào orderBox
            orderBox.appendChild(orderContainer);
            orderBox.appendChild(productOrderDetail);
            orderBox.appendChild(returnBox);

            col12.appendChild(orderBox);
            // Cuối cùng, thêm vào phần tử cha (có thể là một container hoặc body)
            get_list_orders.appendChild(col12);
        })
    }
}

var order_status_selected = 0;
async function change_order_status(status_of_order) {
    if (order_status_selected != status_of_order) {
        order_status_selected = status_of_order;
        $('.container-spinner').removeClass('hidden');
        try {
            list_orders = await get_orders(status_of_order);
            if (list_orders && !Array.isArray(list_orders)) {
                list_orders = Object.values(list_orders);
            }

            load_orders(list_orders, status_of_order);
        } catch (error) {
            console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    }
}
//================================Xử lý tiếp tục mua hàng================================
$(document).off('click', '.btn_continue_payment_order').on('click', '.btn_continue_payment_order', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var order_id = $(this).data('id');
        var amount = $(this).data('amount');
        var payment_method = $(this).data('payment-method');
        if (payment_method == "vnpay" && (order_id != '' && amount != "")) {
            $('#form_vnpay').find('.order_id').val(order_id);
            $('#form_vnpay').find('.amount').val(amount);
            $('#form_vnpay').submit();
        } else if (payment_method == "momo" && (order_id != '' && amount != "")) {
            $('#form_momo').find('.order_id').val(order_id);
            $('#form_momo').find('.amount').val(amount);
            $('#form_momo').submit();
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//================================Xử lý hủy đơn hàng================================
$(document).on('click', '.btn_cancel_order', function () {
    var order_id = $(this).data('id');
    var cancel_order_modal = document.getElementById('cancel-order-modal');
    if (order_id) {
        cancel_order_modal.setAttribute('data-id', order_id);
    }
})

//===============================Xử lý hủy đơn hàng=================================
function cancel_order(order_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeCancelOrder,
            method: "POST",
            data: {
                _token: csrf,
                order_id: order_id
            },
            success: function (response) {
                if (response.success) {
                    notification('success', response.message, 'Successfully!', 2000);
                    resolve(response.success);
                } else {
                    notification('error', response.message, 'Error!', 2000);
                    resolve(response.success);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}
//================================Xử lý xác nhận hủy đơn hàng================================
$(document).on('click', '#btn_confirm_cancel_order', async function () {

    var cancel_order_modal = document.getElementById('cancel-order-modal');
    var order_id = cancel_order_modal.getAttribute('data-id');

    if (order_id) {
        $('.container-spinner').removeClass('hidden');
        try {
            if (await cancel_order(order_id)) {
                cancel_order_modal.removeAttribute('data-id');

                list_orders = await get_orders(order_status_selected);
                if (list_orders && !Array.isArray(list_orders)) {
                    list_orders = Object.values(list_orders);
                }
                console.log(list_orders);

                load_orders(list_orders, order_status_selected);
            } else {
                load_orders(list_orders, order_status_selected);
            }

        } catch (error) {
            console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    }
})
//================================Xử lý bấm vào nút xác nhận hoàn thành đơn hàng================================
$(document).on('click', '.btn_confirm_done_order', function () {
    var order_id = $(this).data('id');
    var confirm_done_order_modal = document.getElementById('confirm-done-order-modal');
    if (order_id) {
        confirm_done_order_modal.setAttribute('data-id', order_id);
    }
})
//=================================Xử lý hoàn thành đơn hàng trong db====================================
function confirm_done_order(order_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeConfirmDoneOrder,
            method: "POST",
            data: {
                _token: csrf,
                order_id: order_id
            },
            success: function (response) {
                if (response.success) {
                    notification('success', response.message, 'Successfully!', 2000);
                    resolve(response.success);
                } else {
                    notification('error', response.message, 'Error!', 2000);
                    resolve(response.success);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}
//================================Xử lý xác nhận hoàn thành đơn hàng================================
$(document).on('click', '#btn_confirm_done_order', async function () {

    var confirm_done_order_modal = document.getElementById('confirm-done-order-modal');
    var order_id = confirm_done_order_modal.getAttribute('data-id');

    if (order_id) {
        $('.container-spinner').removeClass('hidden');
        try {
            if (await confirm_done_order(order_id)) {
                confirm_done_order_modal.removeAttribute('data-id');

                list_orders = await get_orders(order_status_selected);
                if (list_orders && !Array.isArray(list_orders)) {
                    list_orders = Object.values(list_orders);
                }
                console.log(list_orders);

                load_orders(list_orders, order_status_selected);
            } else {
                load_orders(list_orders, order_status_selected);
            }

        } catch (error) {
            console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    }
})

//================================Xử lý lấy dữ liệu chi tiết đơn hàng từ db================================
function getOrderDetail(order_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetOrderDetail,
            method: "POST",
            data: {
                _token: csrf,
                order_id: order_id
            },
            success: function (response) {
                if (response.success) {
                    resolve(response.data);
                } else {
                    notification('error', response.message, 'Error!', 2000);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}
//==============================Xử lý click vào nút chi tiết để xem chi tiết đơn hàng================================
$(document).on('click', '.btn_view_order_detail', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var order_id = $(this).data('id');
        if (order_id) {
            var status_id_of_this_order = $(this).data('status_id');
            var data_order_detail_by_id = await getOrderDetail(order_id);
            data_order_detail_by_id = convertObjectToArray(data_order_detail_by_id);
            console.log(data_order_detail_by_id);


            $('#span_order_code').text(data_order_detail_by_id[0]['id']);
            if (status_id_of_this_order == 1) {
                $('#span_order_status').text("WAITING FOR PAYMENT");
            } else if (status_id_of_this_order == 2) {
                $('#span_order_status').text("Awaiting confirmation".toUpperCase());
            } else if (status_id_of_this_order == 3) {
                $('#span_order_status').text("On Delivery".toUpperCase());
            } else if (status_id_of_this_order == 4) {
                $('#span_order_status').text("Delivered".toUpperCase());
            } else if (status_id_of_this_order == 5) {
                $('#span_order_status').text("Cancelled".toUpperCase());
            } else {
                $('#span_order_status').text("Return".toUpperCase());
            }
            //--------Hiển thị vòng đời của đơn hàng---------
            var progress_container = document.getElementById("progress-container");
            progress_container.innerHTML = "";

            //---1---
            // Tạo phần tử <div class="progress-step completed"></div>
            let progressStep = document.createElement('div');
            progressStep.classList.add('progress-step', 'completed');

            let stepIcon = document.createElement('div');
            stepIcon.classList.add('step-icon', 'bg-of-theme');
            stepIcon.textContent = '📄'; // Icon

            // Tạo phần tử <div class="step-text">Đã Xác Nhận TTTT & Đặt Hàng</div>
            let stepText = document.createElement('div');
            stepText.classList.add('step-text');
            stepText.textContent = 'Tạo Mới Đơn Hàng';

            // Tạo phần tử <span class="step-time no-wrap">03:13 23-05-2024</span>
            let stepTime = document.createElement('span');
            stepTime.classList.add('step-time', 'no-wrap');
            stepTime.textContent = formatDateTime(data_order_detail_by_id[0]['created_at']);

            // Gắn các phần tử con vào phần tử cha `progressStep`
            progressStep.appendChild(stepIcon);
            progressStep.appendChild(stepText);
            progressStep.appendChild(stepTime);

            let progressLine = document.createElement('div');
            progressLine.classList.add('progress-line', 'bg-of-theme');

            progress_container.appendChild(progressStep);
            progress_container.appendChild(progressLine);

            var get_all_status_of_order = [];
            data_order_detail_by_id[0]['status_orders'].forEach(function (status_order_item) {
                get_all_status_of_order.push(status_order_item['status_id']);
            });


            function returnTimeOfStatusOrder(status_id) {
                var status = data_order_detail_by_id[0]['status_orders'].find((status_order_item) => {
                    return status_order_item['status_id'] == status_id;
                });
                return status ? formatDateTime(status['created_at']) : null;
            }
            if (get_all_status_of_order.length > 0) {
                if (get_all_status_of_order.includes(5)) {
                    // Chỉ hiển thị các trạng thái đã xảy ra
                    if (get_all_status_of_order.includes(1) && !get_all_status_of_order.includes(2)) {

                        var elements = createProgressOrder(true, false, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        var time = returnTimeOfStatusOrder(5);
                        console.log(time);

                        elements = createProgressOrder(false, true, '❌', 'Đã Hủy', time, false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else if (get_all_status_of_order.includes(1) && get_all_status_of_order.includes(2) && !get_all_status_of_order.includes(3)) {
                        //-----1-----
                        var time = returnTimeOfStatusOrder(1);

                        var elements = createProgressOrder(true, true, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        //-----2-----

                        elements = createProgressOrder(true, false, '✅', 'Đã Kiểm Tra Đơn Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(5);

                        elements = createProgressOrder(false, true, '❌', 'Đã Hủy', time, false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    }
                } else if (!get_all_status_of_order.includes(4)) {
                    if (get_all_status_of_order.includes(1) && !get_all_status_of_order.includes(2)) {
                        var elements = createProgressOrder(false, false, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '✅', 'Đã Kiểm Tra Đơn Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🚚', 'Đã Giao Cho DVC', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🌟', 'Đã Nhận Hàng Thành Công', "", false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else if (!get_all_status_of_order.includes(1) && get_all_status_of_order.includes(2) && !get_all_status_of_order.includes(3)) {
                        var elements = createProgressOrder(false, false, '✅', 'Đã Kiểm Tra Đơn Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🚚', 'Đã Giao Cho DVC', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🌟', 'Đã Nhận Hàng Thành Công', "", false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else if (get_all_status_of_order.includes(1) && get_all_status_of_order.includes(2) && !get_all_status_of_order.includes(3)) {
                        var time = returnTimeOfStatusOrder(1);
                        var elements = createProgressOrder(true, true, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '✅', 'Đã Kiểm Tra Đơn Hàng', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🚚', 'Đã Giao Cho DVC', "", true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🌟', 'Đã Nhận Hàng Thành Công', "", false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else if (get_all_status_of_order.includes(1) && get_all_status_of_order.includes(2) && get_all_status_of_order.includes(3)) {
                        var time = returnTimeOfStatusOrder(1);
                        var elements = createProgressOrder(true, true, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(2);
                        elements = createProgressOrder(true, true, '✅', 'Đã Kiểm Tra Đơn Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(3);
                        elements = createProgressOrder(true, true, '🚚', 'Đã Giao Cho DVC', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🌟', 'Đã Nhận Hàng Thành Công', "", false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else if (!get_all_status_of_order.includes(1) && get_all_status_of_order.includes(2) && get_all_status_of_order.includes(3)) {
                        var time = returnTimeOfStatusOrder(2);
                        elements = createProgressOrder(true, true, '✅', 'Đã Kiểm Tra Đơn Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(3);
                        elements = createProgressOrder(true, true, '🚚', 'Đã Giao Cho DVC', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        elements = createProgressOrder(false, false, '🌟', 'Đã Nhận Hàng Thành Công', "", false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    }
                } else if (get_all_status_of_order.includes(4)) {
                    if (get_all_status_of_order.includes(1)) {
                        var time = returnTimeOfStatusOrder(1);
                        var elements = createProgressOrder(true, true, '💳', 'Đã Xác Nhận TTTT & Đặt Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(2);
                        elements = createProgressOrder(true, true, '✅', 'Đã Kiểm Tra Đơn Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(3);
                        elements = createProgressOrder(true, true, '🚚', 'Đã Giao Cho DVC', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(4);
                        elements = createProgressOrder(false, true, '🌟', 'Đã Nhận Hàng Thành Công', time, false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    } else {
                        var time = returnTimeOfStatusOrder(2);
                        elements = createProgressOrder(true, true, '✅', 'Đã Kiểm Tra Đơn Hàng', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(3);
                        elements = createProgressOrder(true, true, '🚚', 'Đã Giao Cho DVC', time, true);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })

                        time = returnTimeOfStatusOrder(4);
                        elements = createProgressOrder(false, true, '🌟', 'Đã Nhận Hàng Thành Công', time, false);
                        elements.forEach(function (element) {
                            progress_container.appendChild(element);
                        })
                    }
                }
            }

            // ================Đổ dữ liệu sản phẩm ra list sp==================
            var body_of_list_product = document.getElementById("body_of_list_product");
            body_of_list_product.innerHTML = "";

            var amounts = {
                original_amount: 0,
                discounted_amount: 0
            }

            if (data_order_detail_by_id[0]['order_details'].length > 0) {
                for (const order_detail_item of data_order_detail_by_id[0]['order_details']) {
                    await loadListProductInOrderDetail(get_all_status_of_order, order_detail_item, amounts, body_of_list_product);
                }
                loadSubTotalUnderListProductInOrderDetail(amounts, body_of_list_product);
            } else {
                let notHaveProductRow = document.createElement('tr');

                // Tạo phần tử <td> và thiết lập thuộc tính colspan, class
                let notHaveProductCell = document.createElement('td');
                notHaveProductCell.setAttribute('colspan', '6');
                notHaveProductCell.classList.add('text-center');

                // Tạo phần tử <span> và thêm nội dung, class
                let notHaveProductSpan = document.createElement('span');
                notHaveProductSpan.classList.add('text-danger');
                notHaveProductSpan.textContent = 'Không có dữ liệu sản phẩm';

                // Gắn <span> vào <td>
                notHaveProductCell.appendChild(notHaveProductSpan);

                // Gắn <td> vào <tr>
                notHaveProductRow.appendChild(notHaveProductCell);
                body_of_list_product.appendChild(notHaveProductRow);
            }
            //===============Đổ dữ liệu ra chi tiết đơn hàng phụ===============
            $('#sod_total_products').text(data_order_detail_by_id[0]['order_details'].length);
            $('#sod_sub_total_payment').text(formatCurrency(data_order_detail_by_id[0]['total_cost']));
            $('#sod_payment_method').text(data_order_detail_by_id[0]['payment_method']);
            $('#sod_shipping_costs').text(formatCurrency(data_order_detail_by_id[0]['shipping_price']));
            $('#sod_tax').text(formatCurrency(data_order_detail_by_id[0]['tax']));
            $('#sod_shipping_voucher').text("-" + formatCurrency(data_order_detail_by_id[0]['shipping_voucher']));
            $('#sod_voucher').text("-" + formatCurrency(data_order_detail_by_id[0]['voucher']));
            $('#sod_total_payment').text(formatCurrency(data_order_detail_by_id[0]['total_payment']));
            $('#sod_full_name').text(data_order_detail_by_id[0]['full_name']);
            $('#sod_phone_number').text(data_order_detail_by_id[0]['phone_number']);
            $('#sod_address').text(data_order_detail_by_id[0]['address']);
            $('#sod_ordered_at').text(formatDate(data_order_detail_by_id[0]['created_at']));


            $('.tab-pane.show.active').removeClass('show active');


            if (!$('#order_details').hasClass('active show')) {
                $('#order_details').addClass('show active');
            }
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//============================================Hàm tạo tiến độ của đơn hàng============================================
function createProgressOrder(line_active, active, icon_status, content_status, time, has_line) {
    // Tạo phần tử <div class="progress-step completed"></div>
    var elements = [];
    let progressStep = document.createElement('div');
    progressStep.classList.add('progress-step', 'completed');

    let stepIcon = document.createElement('div');
    stepIcon.classList.add('step-icon');
    if (active) stepIcon.classList.add('bg-of-theme');
    stepIcon.textContent = icon_status; // Icon

    // Tạo phần tử <div class="step-text">Đã Xác Nhận TTTT & Đặt Hàng</div>
    let stepText = document.createElement('div');
    stepText.classList.add('step-text');
    stepText.textContent = content_status;

    // Tạo phần tử <span class="step-time no-wrap">03:13 23-05-2024</span>
    let stepTime = document.createElement('span');
    stepTime.classList.add('step-time', 'no-wrap');
    stepTime.textContent = time;

    // Gắn các phần tử con vào phần tử cha `progressStep`
    progressStep.appendChild(stepIcon);
    progressStep.appendChild(stepText);
    if (time) progressStep.appendChild(stepTime);

    elements.push(progressStep);
    if (has_line) {
        let progressLine = document.createElement('div');
        progressLine.classList.add('progress-line');
        if (line_active) progressLine.classList.add('bg-of-theme');
        elements.push(progressLine);
    }
    return elements;
}
//============================================Hiển thị danh sách sản phẩm trong chi tiết đơn hàng============================================
async function loadListProductInOrderDetail(get_all_status_of_order, order_detail_item, amounts, body_of_list_product) {
    amounts.original_amount += order_detail_item['original_price'] * order_detail_item['quantity'];
    amounts.discounted_amount += order_detail_item['amount_reduced'];

    const row = document.createElement("tr");

    // Cột 1: Cart Box
    const cartBoxCell = document.createElement("td");
    const cartBoxDiv = document.createElement("div");
    cartBoxDiv.classList.add("cart-box");

    const linkImage = document.createElement("a");
    linkImage.href = "productDetail/" + order_detail_item['product_variant']['product']['SKU'];

    const image = document.createElement("img");
    image.src = `uploads/products/images/` + order_detail_item['product_variant']['image'];
    image.alt = "image";

    const flexColumnDiv = document.createElement("div");
    flexColumnDiv.classList.add("d-flex", "flex-column");

    const productLink = document.createElement("a");
    productLink.href = "productDetail/" + order_detail_item['product_variant']['product']['SKU'];


    const productTitle = document.createElement("h5");
    productTitle.classList.add("fs-12");
    productTitle.textContent = order_detail_item['product_variant']['product']['name'];

    const sizeSpan = document.createElement("span");
    sizeSpan.classList.add("fs-12");
    sizeSpan.textContent = order_detail_item['product_variant']['name'];

    // Gắn các phần tử con vào cartBoxDiv
    productLink.appendChild(productTitle);
    flexColumnDiv.appendChild(productLink);
    flexColumnDiv.appendChild(sizeSpan);
    linkImage.appendChild(image);
    cartBoxDiv.appendChild(linkImage);
    cartBoxDiv.appendChild(flexColumnDiv);

    // Gắn vào ô đầu tiên
    cartBoxCell.appendChild(cartBoxDiv);
    row.appendChild(cartBoxCell);

    // Cột 2: Giá sản phẩm
    const priceCell = document.createElement("td");
    const priceSpan = document.createElement("span");
    priceSpan.classList.add("fs-12");
    priceSpan.textContent = formatCurrency(order_detail_item['original_price']);
    priceCell.appendChild(priceSpan);
    row.appendChild(priceCell);

    // Cột 3: Số lượng
    const quantityCell = document.createElement("td");
    quantityCell.classList.add("fs-12");
    quantityCell.textContent = order_detail_item['quantity'];
    row.appendChild(quantityCell);

    // Cột 4: Giá trị
    const valueCell = document.createElement("td");
    const valueDiv = document.createElement("div");
    valueDiv.classList.add("d-flex", "flex-column", "justify-content-end");

    const valuePositiveSpan = document.createElement("span");
    valuePositiveSpan.classList.add("fs-12");
    valuePositiveSpan.textContent = formatCurrency(order_detail_item['original_price'] * order_detail_item['quantity']);

    valueDiv.appendChild(valuePositiveSpan);
    if (order_detail_item['amount_reduced'] > 0) {
        const valueNegativeSpan = document.createElement("span");
        valueNegativeSpan.classList.add("text-danger", "fs-12");
        valueNegativeSpan.textContent = "-" + formatCurrency(order_detail_item['amount_reduced']);
        valueDiv.appendChild(valueNegativeSpan);
    }

    // Gắn vào valueDiv và valueCell
    valueCell.appendChild(valueDiv);
    row.appendChild(valueCell);

    // Cột 5: Tổng giá trị
    const totalValueCell = document.createElement("td");
    totalValueCell.classList.add("fw-bold", "text-success", "fs-12");
    totalValueCell.textContent = formatCurrency((order_detail_item['original_price'] * order_detail_item['quantity']) - order_detail_item['amount_reduced']);
    row.appendChild(totalValueCell);

    // Cột 6: Nút
    var show_star = false;
    var sub_data_vote = null;
    const buttonCell = document.createElement("td");
    if (get_all_status_of_order.includes(4)) {
        const buttonSpan = document.createElement("span");
        var data_vote = await getVoteOrder(order_detail_item['id']);
        if (data_vote) {
            const divControlVote = document.createElement('div');
            divControlVote.classList.add('d-flex', 'flex-column', 'align-items-center');

            sub_data_vote = data_vote;
            const viewRatedButton = document.createElement("span");
            viewRatedButton.classList.add("btn", "btn-outline-dark", "btn-sm", "mb-1", "btn_view_rated");
            viewRatedButton.setAttribute('data-id', order_detail_item['id']);
            viewRatedButton.setAttribute('data-product-name', order_detail_item['product_variant']['product']['name']);
            viewRatedButton.setAttribute('data-product-variant-name', order_detail_item['product_variant']['name']);
            viewRatedButton.setAttribute('data-product-variant-image', order_detail_item['product_variant']['image']);
            viewRatedButton.setAttribute('data-price', order_detail_item['original_price']);
            viewRatedButton.setAttribute('data-vote-id', data_vote.id);
            viewRatedButton.setAttribute('data-star', data_vote.star);
            viewRatedButton.setAttribute('data-review-content', data_vote.content);
            viewRatedButton.setAttribute('data-edit-status', data_vote.edit);
            viewRatedButton.setAttribute('data-bs-toggle', 'modal');
            viewRatedButton.setAttribute('data-bs-target', '#review-vote-order-detail-modal');
            viewRatedButton.textContent = "View rated";

            // Tạo div 'order_detail_1'
            const showStarsDiv = document.createElement("div");
            showStarsDiv.id = "order_detail_" + order_detail_item['id'];
            show_star = true;
            divControlVote.appendChild(viewRatedButton);
            divControlVote.appendChild(showStarsDiv);
            buttonCell.appendChild(divControlVote);
        } else {
            buttonSpan.classList.add("fs-12", "btn", "color-of-theme", "btn_vote_order_detail");
            buttonSpan.setAttribute('data-id', order_detail_item['id']);
            buttonSpan.setAttribute('data-product-name', order_detail_item['product_variant']['product']['name']);
            buttonSpan.setAttribute('data-product-variant-name', order_detail_item['product_variant']['name']);
            buttonSpan.setAttribute('data-product-variant-image', order_detail_item['product_variant']['image']);
            buttonSpan.setAttribute('data-price', order_detail_item['original_price']);
            buttonSpan.setAttribute('data-bs-toggle', 'modal');
            buttonSpan.setAttribute('data-bs-target', '#vote-order-detail-modal');
            buttonSpan.textContent = "Vote now";
            buttonCell.appendChild(buttonSpan);
        }
    } else {
        const buttonSpan = document.createElement("span");
        buttonSpan.classList.add("fs-12", "color-of-theme", "no-select");
        buttonSpan.textContent = "Cannot be rated yet";
        buttonCell.appendChild(buttonSpan);
    }
    row.appendChild(buttonCell);

    body_of_list_product.appendChild(row);
    if (show_star) {
        $("#order_detail_" + order_detail_item['id']).rateYo({
            rating: parseFloat(sub_data_vote.star),
            fullStar: true,
            precision: 1,
            starWidth: "15px",
            readOnly: true,
            ratedFill: "#cca270",
        });
    }
}
//===========================================Xử lý tải dòng hiển thị tổng sp phụ===========================================
function loadSubTotalUnderListProductInOrderDetail(amounts, body_of_list_product) {
    let toSumUpRow = document.createElement('tr');

    // Tạo các phần tử <td> rỗng
    for (let i = 0; i < 4; i++) {
        let cell = document.createElement('td');
        toSumUpRow.appendChild(cell);
    }

    // Tạo phần tử <td> với class "total fw-bold" cho tổng
    let totalCell = document.createElement('td');
    totalCell.classList.add('total', 'fw-bold');
    totalCell.textContent = 'Total :';

    // Tạo phần tử <td> cho giá trị tổng với flex container
    let valueCell = document.createElement('td');
    valueCell.classList.add('total', 'fw-bold');

    // Tạo phần tử d-flex chứa các giá trị
    let flexContainer = document.createElement('div');
    flexContainer.classList.add('d-flex', 'flex-column', 'align-items-end');

    // Tạo các phần tử <span> cho các giá trị tiền
    let originalAmount = document.createElement('span');
    originalAmount.classList.add('fs-6', 'text-dark');
    originalAmount.textContent = formatCurrency(amounts.original_amount); // Thay giá trị tương ứng
    let discountedAmount = document.createElement('span');
    var hasDiscountedAmount = false;
    if (amounts.discounted_amount > 0) {
        hasDiscountedAmount = true;
        originalAmount.classList.add('text-decoration-line-through');
        discountedAmount.classList.add('fs-6', 'text-success', 'fw-bold');
        discountedAmount.textContent = formatCurrency(amounts.original_amount - amounts.discounted_amount);; // Thay giá trị tương ứng
    }

    // Thêm các phần tử <span> vào container
    flexContainer.appendChild(originalAmount);
    if (hasDiscountedAmount) {
        flexContainer.appendChild(discountedAmount);
    }

    // Gắn flex container vào <td>
    valueCell.appendChild(flexContainer);

    // Gắn các <td> vào <tr>
    toSumUpRow.appendChild(totalCell);
    toSumUpRow.appendChild(valueCell);

    // Ví dụ: Gắn vào bảng
    body_of_list_product.appendChild(toSumUpRow);
}
//================================Lấy dữ liệu đánh giá item đơn hàng============================================
function getVoteOrder(order_detail_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetVoteOrderDetail,
            method: "POST",
            data: {
                _token: csrf,
                order_detail_id: order_detail_id
            },
            success: function (response) {
                if (response.success) {
                    resolve(response.data);
                } else {
                    resolve(response.success);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}

//=====================================XỬ LÝ ĐÁNH GIÁ ĐƠN HÀNG==========================================
var order_detail_id_of_order_detail_voting = null;
var voted = false;
var voted_star = 0;
$(document).on('click', '.btn_vote_order_detail', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var order_detail_id = $(this).data('id');
        var order_detail_product_name = $(this).data('product-name');
        var order_detail_product_variant_name = $(this).data('product-variant-name');
        var order_detail_product_variant_image = $(this).data('product-variant-image');
        var order_detail_price = $(this).data('price');
        var number_of_stars = 0;
        if (order_detail_id_of_order_detail_voting != order_detail_id) {
            $('#btn_submit_vote_order_detail').data('order-detail-id', order_detail_id);
            voted_star = 0;
            voted = false;
            order_detail_id_of_order_detail_voting = order_detail_id;

            $("#vote_by_star").rateYo({
                rating: 5,
                fullStar: true,
                precision: 1,
                starWidth: "35px",
                readOnly: false,
                step: 1,
                ratedFill: "#cca270",
                onSet: function (rating) {
                    number_of_stars = rating;
                    notification('success', 'Đánh giá của bạn là: ' + number_of_stars + ' sao!', '', 2000);
                    if (rating > 0) {
                        voted = true;
                        voted_star = rating;
                    } else {
                        $(this).rateYo("rating", 1);
                    }
                },
            });
            $("#vote_by_star").rateYo("rating", 5);
            $('#product_name_vote_order_detail_modal').text(order_detail_product_name);
            $('#product_variant_name_vote_order_detail_modal').text(order_detail_product_variant_name);
            $('#product_variant_image_vote_order_detail_modal').attr('src', `uploads/products/images/${order_detail_product_variant_image}`);
            $('#price_vote_order_detail_modal').text(formatCurrency(order_detail_price));
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//===============================Xử lý bấm vào nút xác nộp thông tin đánh giá=================================
$('#btn_submit_vote_order_detail').on('click', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var content = $('#content_vote').val();
        var order_detail_id = $(this).data('order-detail-id');

        if (voted && voted_star != 0) {
            var result_of_vote_order_detail = await vote_order_detail(order_detail_id, content, voted_star);
            if (result_of_vote_order_detail != false) {
                var modalElement = document.getElementById('vote-order-detail-modal')
                var modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();
                var get_all_status_of_order = [];
                result_of_vote_order_detail['status_orders'].forEach(function (status_order_item) {
                    get_all_status_of_order.push(status_order_item['status_id']);
                });
                // ================Đổ dữ liệu sản phẩm ra list sp==================
                var body_of_list_product = document.getElementById("body_of_list_product");
                body_of_list_product.innerHTML = "";

                var amounts = {
                    original_amount: 0,
                    discounted_amount: 0
                }

                if (result_of_vote_order_detail['order_details'].length > 0) {
                    for (const order_detail_item of result_of_vote_order_detail['order_details']) {
                        await loadListProductInOrderDetail(get_all_status_of_order, order_detail_item, amounts, body_of_list_product);
                    }
                    loadSubTotalUnderListProductInOrderDetail(amounts, body_of_list_product);
                    // Tạo phần tử <tr>
                } else {
                    let notHaveProductRow = document.createElement('tr');

                    // Tạo phần tử <td> và thiết lập thuộc tính colspan, class
                    let notHaveProductCell = document.createElement('td');
                    notHaveProductCell.setAttribute('colspan', '6');
                    notHaveProductCell.classList.add('text-center');

                    // Tạo phần tử <span> và thêm nội dung, class
                    let notHaveProductSpan = document.createElement('span');
                    notHaveProductSpan.classList.add('text-danger');
                    notHaveProductSpan.textContent = 'Không có dữ liệu sản phẩm';

                    // Gắn <span> vào <td>
                    notHaveProductCell.appendChild(notHaveProductSpan);

                    // Gắn <td> vào <tr>
                    notHaveProductRow.appendChild(notHaveProductCell);
                    body_of_list_product.appendChild(notHaveProductRow);
                }
                notification('success', 'Đánh giá sản phẩm thành công!', 'Successfully!', 2000);
            } else {
                notification('error', 'Có lỗi xảy ra khi đánh giá sản phẩm, vui lòng tải lại trang!', 'Error!', 2000);
            }
        } else {
            notification('warning', 'Vui lòng đánh giá số sao và có thể thêm nội dung nếu cần!', 'Chưa đánh giá!', 2000);
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//==============================Xử lý tạo mới dữ liệu đánh giá sau khi bấm nút submit=================================
function vote_order_detail(order_detail_id, content, star) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeSubmitVoteOrderDetail,
            method: "POST",
            data: {
                _token: csrf,
                order_detail_id: order_detail_id,
                content: content,
                star: star
            },
            success: function (response) {
                if (response.success) {
                    resolve(response.data);
                } else {
                    resolve(response.success);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}

//===========================================Xử lý click vào nút xem lại đánh giá (view rated)===========================================
var edit_voted = false;
var edit_voted_star = 0;
var order_detail_id_of_review_order_detail_voting = null;

$(document).on('click', '.btn_view_rated', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var order_detail_id = $(this).data('id');
        var order_detail_product_name = $(this).data('product-name');
        var order_detail_product_variant_name = $(this).data('product-variant-name');
        var order_detail_product_variant_image = $(this).data('product-variant-image');
        var order_detail_price = $(this).data('price');
        var order_detail_vote_id = $(this).data('vote-id');
        var order_detail_star = $(this).data('star');
        var order_detail_review_content = $(this).data('review-content');
        var order_detail_edit_status = $(this).data('edit-status');



        var number_of_stars = 0;

        console.log(order_detail_id_of_review_order_detail_voting);
        if (order_detail_id_of_review_order_detail_voting != order_detail_id) {
            edit_voted_star = order_detail_star;
            edit_voted = false;
            if (order_detail_id_of_review_order_detail_voting != null) {
                $("#review_vote_by_star_modal").rateYo("destroy");
            }
            order_detail_id_of_review_order_detail_voting = order_detail_id;

            $("#review_vote_by_star_modal").rateYo({
                rating: order_detail_star,
                fullStar: true,
                precision: 1,
                starWidth: "35px",
                readOnly: true,
                ratedFill: "#cca270",
                onSet: function (rating) {
                    number_of_stars = rating;
                    notification('success', 'Đánh giá của bạn là: ' + number_of_stars + ' sao!', '', 2000);
                    if (rating != 0) {
                        edit_voted = true;
                        edit_voted_star = rating;
                    }
                },
            });
            $('#review_product_name_vote_order_detail_modal').text(order_detail_product_name);
            $('#review_product_variant_name_vote_order_detail_modal').text(order_detail_product_variant_name);
            $('#review_product_variant_image_vote_order_detail_modal').attr('src', `uploads/products/images/${order_detail_product_variant_image}`);
            $('#review_price_vote_order_detail_modal').text(formatCurrency(order_detail_price));
            $('#review_content_vote_modal').val(order_detail_review_content);

            if (order_detail_edit_status) {
                $('#btn_edit_vote_order_detail').addClass('hidden');
            } else {
                $('#btn_edit_vote_order_detail').removeClass('hidden');
                $('#btn_edit_vote_order_detail').data('star', order_detail_star);
                $('#btn_cancel_edit_vote_order_detail').data('star', order_detail_star);
                $('#btn_submit_edit_vote_order_detail').data('vote-id', order_detail_vote_id);
                $('#btn_submit_edit_vote_order_detail').data('order-detail-id', order_detail_id);
            }
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//)===========================================Xử lý khi modal review ẩn)===========================================
$('#review-vote-order-detail-modal').on('hidden.bs.modal', function (e) {
    $('#btn_edit_vote_order_detail').removeClass('hidden');
    $('#div_btn_confirm_edit_done_and_btn_cancel_edit').addClass('hidden');
    $('#review_content_vote_modal').attr('disabled', true);
});
//===========================================Xử lý khi bấm vào nút edit của form review modal===========================================
$(document).on('click', '#btn_edit_vote_order_detail', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var old_star = $(this).data('star');
        $(this).addClass('hidden');
        $('#div_btn_confirm_edit_done_and_btn_cancel_edit').removeClass('hidden');
        $('#review_content_vote_modal').removeAttr('disabled');
        $("#review_vote_by_star_modal").rateYo("destroy");
        $("#review_vote_by_star_modal").rateYo({
            rating: old_star,
            fullStar: true,
            precision: 1,
            starWidth: "35px",
            readOnly: false,
            step: 1,
            ratedFill: "#cca270",
            onSet: function (rating) {
                notification('success', 'Đánh giá của bạn là: ' + rating + ' sao!', '', 2000);
                if (rating > 0) {
                    edit_voted = true;
                    edit_voted_star = rating;
                } else {
                    edit_voted_star = 0;
                    edit_voted = false;
                    $(this).rateYo("rating", 1);
                }
            },
        });
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//===========================================Xử lý khi bấm vào nút hủy edit của form review modal===========================================
$(document).on('click', '#btn_cancel_edit_vote_order_detail', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var old_star = $(this).data('star');
        $("#review_vote_by_star_modal").rateYo("destroy");
        $("#review_vote_by_star_modal").rateYo({
            rating: old_star,
            fullStar: true,
            precision: 1,
            starWidth: "35px",
            readOnly: true,
            ratedFill: "#cca270",
        });
        $('#btn_edit_vote_order_detail').removeClass('hidden');
        $('#review_content_vote_modal').attr('disabled', true);
        $('#div_btn_confirm_edit_done_and_btn_cancel_edit').addClass('hidden');
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//===================================Xử lý submit chỉnh sửa đánh giá ===========================================
$('#btn_submit_edit_vote_order_detail').on('click', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var vote_id = $(this).data('vote-id');
        var order_detail_id = $(this).data('order-detail-id');
        var content_vote = $('#review_content_vote_modal').val();
        if (edit_voted_star > 0) {
            var result_of_edit_vote_order_detail = await edit_vote_order_detail(order_detail_id, vote_id, content_vote, edit_voted_star);
            console.log(result_of_edit_vote_order_detail);

            if (result_of_edit_vote_order_detail) {
                var get_all_status_of_order = [];
                result_of_edit_vote_order_detail['status_orders'].forEach(function (status_order_item) {
                    get_all_status_of_order.push(status_order_item['status_id']);
                });
                // ================Đổ dữ liệu sản phẩm ra list sp==================
                var body_of_list_product = document.getElementById("body_of_list_product");
                body_of_list_product.innerHTML = "";

                var amounts = {
                    original_amount: 0,
                    discounted_amount: 0
                }

                if (result_of_edit_vote_order_detail['order_details'].length > 0) {
                    for (const order_detail_item of result_of_edit_vote_order_detail['order_details']) {
                        await loadListProductInOrderDetail(get_all_status_of_order, order_detail_item, amounts, body_of_list_product);
                    }
                    loadSubTotalUnderListProductInOrderDetail(amounts, body_of_list_product);
                    // Tạo phần tử <tr>
                } else {
                    let notHaveProductRow = document.createElement('tr');

                    // Tạo phần tử <td> và thiết lập thuộc tính colspan, class
                    let notHaveProductCell = document.createElement('td');
                    notHaveProductCell.setAttribute('colspan', '6');
                    notHaveProductCell.classList.add('text-center');

                    // Tạo phần tử <span> và thêm nội dung, class
                    let notHaveProductSpan = document.createElement('span');
                    notHaveProductSpan.classList.add('text-danger');
                    notHaveProductSpan.textContent = 'Không có dữ liệu sản phẩm';

                    // Gắn <span> vào <td>
                    notHaveProductCell.appendChild(notHaveProductSpan);

                    // Gắn <td> vào <tr>
                    notHaveProductRow.appendChild(notHaveProductCell);
                    body_of_list_product.appendChild(notHaveProductRow);
                }
                notification('success', 'Sửa đánh giá sản phẩm thành công!', 'Successfully!', 2000);
                var modalElement = document.getElementById('review-vote-order-detail-modal')
                var modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();
                $('#btn_edit_vote_order_detail').removeClass('hidden');
                $('#review_content_vote_modal').attr('disabled', true);
                $('#div_btn_confirm_edit_done_and_btn_cancel_edit').addClass('hidden');
                edit_voted = false;
                edit_voted_star = 0;
                order_detail_id_of_review_order_detail_voting = null;
                $("#review_vote_by_star_modal").rateYo("destroy");
            } else {
                notification('error', 'Có lỗi xảy ra khi sửa đánh giá sản phẩm, vui lòng tải lại trang!', 'Error!', 2000);
            }
        } else {
            notification('warning', 'Vui lòng đánh giá số sao và có thể thêm nội dung nếu cần!', 'Chưa đánh giá!', 2000);
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy đơn hàng:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//===========================================Xử lý khi cập nhật đánh giá===========================================
function edit_vote_order_detail(order_detail_id, vote_id, content, star) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeSubmitEditVoteOrderDetail,
            method: "POST",
            data: {
                _token: csrf,
                order_detail_id: order_detail_id,
                vote_id: vote_id,
                content: content,
                star: star
            },
            success: function (response) {
                console.log(response);

                if (response.success) {
                    resolve(response.data);
                } else {
                    notification('error', response.message, 'Error!', 2000);
                    resolve(response.success);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}

//====================================Xử lý quay lại trang danh sách đơn hàng khi bấm nút back===========================================
$(document).on('click', '#btn_back_to_list_orders', function () {
    if ($('#order_details').hasClass('show active')) {
        $('#order_details').removeClass('show active');
    }
    if (!$('#order').hasClass('show active')) {
        $('#order').addClass('show active');
    }
})

