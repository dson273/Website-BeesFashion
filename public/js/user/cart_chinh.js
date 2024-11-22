$('#check_out').on('click', function (e) {
    var cart_ids = [];

    $('.product_item').each(function () {
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
})  