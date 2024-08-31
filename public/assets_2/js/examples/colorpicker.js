'use strict';
$(document).ready(function () {

    $('.sample-selector').colorpicker();

    $('.sample-selector-2').colorpicker().on('changeColor', function (e) {
        $('.main-content')[0].style.backgroundColor = e.color.toString('rgba');
    });

    $('.sample-selector-3').colorpicker({
        color: "transparent",
        format: "hex"
    });

    $('.sample-selector-4').colorpicker({
        horizontal: true
    });

    $('.sample-selector-5').colorpicker({
        colorSelectors: {
            'black': '#000000',
            'white': '#ffffff',
            'red': '#FF0000',
            'default': '#777777',
            'primary': '#337ab7',
            'success': '#5cb85c',
            'info': '#5bc0de',
            'warning': '#f0ad4e',
            'danger': '#d9534f'
        }
    });

    $('.sample-selector-rgb').colorpicker({
        format: 'rgb'
    });

    $('.sample-selector-hex').colorpicker({
        format: 'hex'
    });

    $('.sample-selector-rgba').colorpicker({
        format: 'rgba'
    });

});