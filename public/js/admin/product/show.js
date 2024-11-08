$(document).ready(function () {
    //Hiển thị số sao
    const productStar = $('#productStarRating').text();
    $("#productRate").rateYo({
        rating: productStar,
        fullStar: false,
        precision: 1,
        starWidth: "25px",
        readOnly: true,
        ratedFill: "#ffff00",
        // onSet: function (rating, rateYoInstance) {
        //     alert("Đánh giá của bạn là: " + rating);
        // },
    });
});