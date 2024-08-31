'use strict';
$(document).ready(function () {

    $('[data-input-mask="phone"]').mask('(000) 000-0000');

    $('[data-input-mask="money"]').mask('#.##0,00', {reverse: true});

    $('[data-input-mask="date"]').mask('0000/00/00');

    $('[data-input-mask="time"]').mask('00:00:00');

    $('[data-input-mask="ip_address"]').mask('099.099.099.099');

});