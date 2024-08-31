$(function () {

    $(window).on('load', function () {
        var $container = $('.gallery-container');

        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        $('.gallery-filter a').click(function () {
            var $this = $(this);

            $('.gallery-filter .active').removeClass('active');
            $this.addClass('active');

            var selector = $this.attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 300,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    });

    $('.image-popup-gallery-item').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function (openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });

});
