'use strict';
$(document).ready(function () {

    $('.js-example-basic-single').select2({
        placeholder: 'Select',
        dir: $('body').hasClass('rtl') ? 'rtl' : ''
    });

});
