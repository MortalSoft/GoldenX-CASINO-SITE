'use strict';
$(document).ready(function () {

    var colors = {
        primary: $('.colors .bg-primary').css('background-color'),
        primaryLight: $('.colors .bg-primary-bright').css('background-color'),
        secondary: $('.colors .bg-secondary').css('background-color'),
        secondaryLight: $('.colors .bg-secondary-bright').css('background-color'),
        info: $('.colors .bg-info').css('background-color'),
        infoLight: $('.colors .bg-info-bright').css('background-color'),
        success: $('.colors .bg-success').css('background-color'),
        successLight: $('.colors .bg-success-bright').css('background-color'),
        danger: $('.colors .bg-danger').css('background-color'),
        dangerLight: $('.colors .bg-danger-bright').css('background-color'),
        warning: $('.colors .bg-warning').css('background-color'),
        warningLight: $('.colors .bg-warning-bright').css('background-color'),
    };

    $("span.pie").peity("pie");

    $(".pie-1").peity("pie", {
        "fill": [colors.primary, colors.primaryLight],
        "radius": 30
    });

    $(".pie-2").peity("pie", {
        "fill": [colors.secondary, colors.secondaryLight],
        "radius": 30
    });

    $(".pie-3").peity("pie", {
        "fill": [colors.success, colors.successLight],
        "radius": 30
    });

    $(".pie-4").peity("pie", {
        "fill": [colors.danger, colors.dangerLight],
        "radius": 30
    });

    $(".pie-5").peity("pie", {
        "fill": [colors.warning, colors.warningLight],
        "radius": 30
    });

    $(".pie-6").peity("pie", {
        "fill": [colors.primary, colors.primaryLight],
        "radius": 30,
        "innerRadius": 20
    });

    $(".pie-7").peity("pie", {
        "fill": [colors.secondary, colors.secondaryLight],
        "radius": 30,
        "innerRadius": 20
    });

    $(".pie-8").peity("pie", {
        "fill": [colors.success, colors.successLight],
        "radius": 30,
        "innerRadius": 20
    });

    $(".pie-9").peity("pie", {
        "fill": [colors.danger, colors.dangerLight],
        "radius": 30,
        "innerRadius": 20
    });

    $(".pie-10").peity("pie", {
        "fill": [colors.warning, colors.warningLight],
        "radius": 30,
        "innerRadius": 20
    });

    $(".line-1").peity("line", {
        "fill": colors.primaryLight,
        "stroke": colors.primary,
        "height": 80,
        "width": 100
    });

    $(".line-2").peity("line", {
        "fill": colors.secondaryLight,
        "stroke": colors.secondary,
        "height": 80,
        "width": 100
    });

    $(".line-3").peity("line", {
        "fill": colors.secondaryLight,
        "stroke": colors.success,
        "height": 80,
        "width": 100
    });

    $(".line-4").peity("line", {
        "fill": colors.dangerLight,
        "stroke": colors.danger,
        "height": 80,
        "width": 100
    });

    $(".line-5").peity("line", {
        "fill": colors.warningLight,
        "stroke": colors.warning,
        "height": 80,
        "width": 100
    });

    $(".bar-1").peity("bar", {
        "fill": [colors.primary, colors.primaryLight],
        "height": 50,
        "width": 100
    });

    $(".bar-2").peity("bar", {
        "fill": [colors.secondary, colors.secondaryLight],
        "height": 50,
        "width": 100
    });

    $(".bar-3").peity("bar", {
        "fill": [colors.success, colors.successLight],
        "height": 50,
        "width": 100
    });

    $(".bar-4").peity("bar", {
        "fill": [colors.danger, colors.dangerLight],
        "height": 50,
        "width": 100
    });

    $(".bar-5").peity("bar", {
        "fill": [colors.warning, colors.warningLight],
        "height": 50,
        "width": 100
    });

    $('.peity [data-title]').mousemove(function (e) {
        $('#peity-tooltip').html($(this).data('title')).css({left: e.pageX + 8, top: e.pageY + 8});
    }).hover(
        function () {
            $('#peity-tooltip').addClass('show');
        }, function () {
            $('#peity-tooltip').removeClass('show');
        }
    );

});