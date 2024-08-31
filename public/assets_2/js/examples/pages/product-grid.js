$(function () {
    // Add to cart example
    $(document).on('click', '.add-to-card', function () {
        $(this)
            .removeClass('btn-primary')
            .addClass('btn-success')
            .text('View Cart');
    });

    // Range slider example
    $("#rangeSlider-example").ionRangeSlider({
        type: "double",
        min: 10,
        max: 5000,
        from: 2000,
        to: 4000,
        skin: "round",
        prefix: '$'
    });
});
