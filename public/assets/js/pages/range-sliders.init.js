/******/ (function() { // webpackBootstrap
/*!**************************************************!*\
  !*** ./resources/js/pages/range-sliders.init.js ***!
  \**************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Range sliders Js File
*/
$(document).ready(function () {
  $("#range_01").ionRangeSlider({
    skin: "square"
  });
  $("#range_02").ionRangeSlider({
    skin: "square",
    min: 100,
    max: 1000,
    from: 550
  });
  $("#range_03").ionRangeSlider({
    skin: "square",
    type: "double",
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800,
    prefix: "$"
  });
  $("#range_04").ionRangeSlider({
    skin: "square",
    type: "double",
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500
  });
  $("#range_05").ionRangeSlider({
    skin: "square",
    type: "double",
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500,
    step: 250
  });
  $("#range_06").ionRangeSlider({
    skin: "square",
    grid: true,
    from: 3,
    values: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
  });
  $("#range_07").ionRangeSlider({
    skin: "square",
    grid: true,
    min: 1000,
    max: 1000000,
    from: 200000,
    step: 1000,
    prettify_enabled: true
  });
  $("#range_08").ionRangeSlider({
    skin: "square",
    min: 100,
    max: 1000,
    from: 550,
    disable: true
  });
  $("#range_09").ionRangeSlider({
    skin: "square",
    grid: true,
    min: 18,
    max: 70,
    from: 30,
    prefix: "Age ",
    max_postfix: "+"
  });
  $("#range_10").ionRangeSlider({
    skin: "square",
    type: "double",
    min: 100,
    max: 200,
    from: 145,
    to: 155,
    prefix: "Weight: ",
    postfix: " million pounds",
    decorate_both: true
  });
  $("#range_11").ionRangeSlider({
    skin: "square",
    type: "single",
    grid: true,
    min: -90,
    max: 90,
    from: 0,
    postfix: "Ã‚Â°"
  });
  $("#range_12").ionRangeSlider({
    skin: "square",
    type: "double",
    min: 1000,
    max: 2000,
    from: 1200,
    to: 1800,
    hide_min_max: true,
    hide_from_to: true,
    grid: true
  });
});
/******/ })()
;