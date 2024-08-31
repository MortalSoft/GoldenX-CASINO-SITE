'use strict';
$(document).ready(function () {

    function vmap_init(item) {
        if ($('#vmap_' + item).length > 0) {
            $('#vmap_' + item).vectorMap({
                map: item,
                backgroundColor: '#fff',
                color: '#ffffff',
                hoverOpacity: 0.7,
                borderColor: '#fff',
                selectedColor: '#666666',
                enableZoom: false,
                showTooltip: true,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var message = 'You clicked "'
                        + region
                        + '" which has the code: '
                        + code.toUpperCase();

                    alert(message);
                }
            });
        }
    }

    vmap_init('world_en');

    vmap_init('canada_en');

    vmap_init('usa_en');

});