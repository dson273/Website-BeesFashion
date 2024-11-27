$(document).ready(function () {
    // Sự kiện click cho nút "Add to Cart"
    $(".add-to-cart").on("click", function () {
        var productId = $(this).data("product-id");
        var sizeList = $('.list-size[data-product-id="' + productId + '"]');
        
        sizeList.toggleClass("open");
    });

    // Đảm bảo rằng mỗi sản phẩm có màu đầu tiên được checked khi trang tải
    $(".color-box").each(function () {
        $(this).find(".color-variant .color-item").first().addClass("checked");
    });

    // Khi người dùng click vào một màu của sản phẩm
    $(".color-item").on("click", function () {
        var colorBox = $(this).closest(".color-box");
        colorBox.find(".color-item").removeClass("checked");
        $(this).addClass("checked");
        colorBox.find(".checkmark").css("opacity", 0);
        $(this).find(".checkmark").css("opacity", 1);
    });

    // Xử lý click vào size
    $(".size-item").on("click", function () {
        var selectedSizeId = $(this).data("size");
        var selectedColorItem = $(".color-item.checked");

        if (!selectedColorItem.length) {
            alert('Vui lòng chọn màu sắc trước!');
            return;
        }

        var selectedColorId = selectedColorItem.data("color");
        var productId = $(this).closest('.product-box').data("product-id");

        if (!productId) {
            alert('Không tìm thấy sản phẩm!');
            return;
        }

        // Gửi dữ liệu đến server để thêm vào giỏ hàng
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                product_id: productId,
                size_id: selectedSizeId,
                color_id: selectedColorId
            },
            success: function (data) {
                if (data.success) {
                    var successMessage = $('#fancybox-add-to-cart');
                    successMessage.removeClass('hide').addClass('show'); // Hiển thị thông báo

                    setTimeout(function () {
                        successMessage.removeClass('show').addClass('hide'); // Ẩn thông báo sau 2 giây
                    }, 2000);

                    $('.list-size[data-product-id="' + productId + '"]').removeClass('open');
                } else {
                    alert(data.message);
                }
            },
            error: function (error) {
                console.error('Lỗi:', error);
                alert('Đã xảy ra lỗi, vui lòng thử lại sau!');
            }
        });
    });
});
