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
        let address = $('#edit-profile-form').find('textarea[name="address"]').val().trim();
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
                address: address,
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
                    $('.profile-information li:contains("Address") p').text(response
                        .data.address || 'Not updated yet');
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
                        let textarea = $('textarea[name="' + key + '"]');
                        let errMsg = errors[key][0];

                        // Hiển thị thông báo lỗi
                        if (input.length) {
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(errMsg);
                        } else if (textarea.length) {
                            textarea.addClass('is-invalid');
                            textarea.next('.invalid-feedback').text(errMsg);
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
                    // Hiển thị thông báo thành công
                    notification('success', response.message, 'Successfully!');
                    // Xóa dữ liệu trong các ô input
                    $('#add-address-form')[0].reset();
                    window.location.reload();
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
        let fullName = $(this).data('full_name');
        let phoneNumber = $(this).data('phone_number');
        let address = $(this).data('address');

        $('#edit-address-form').find('input[name="full_name"]').val(fullName);
        $('#edit-address-form').find('input[name="phone_number"]').val(phoneNumber);
        $('#edit-address-form').find('textarea[name="address"]').val(address);
        $('#edit-address-form').attr('action', url);
    });

    // Gửi form qua AJAX khi nhấn Submit
    $('#edit-address-form').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'PUT',
            data: formData,
            success: function (response) {
                $('#edit-address').modal('hide');
                notification('success', response.message, 'Successfully!');
                window.location.reload();
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


