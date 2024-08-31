'use strict';
$(document).ready(function () {

    $('.clockpicker-demo').clockpicker({
        donetext: 'Done'
    });

    $('.clockpicker-autoclose-demo').clockpicker({
        autoclose: true
    });

    var input = $('.clockpicker-minutes-demo').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $(document).on('click', '#check-minutes', function (e) {
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });

    $('.create-event-demo').clockpicker({
        donetext: 'Done',
        autoclose: true
    });

});