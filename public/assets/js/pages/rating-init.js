/******/ (function() { // webpackBootstrap
/*!*******************************************!*\
  !*** ./resources/js/pages/rating-init.js ***!
  \*******************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Rating Js File
*/
$(function () {
  $('input.check').on('change', function () {
    alert('Rating: ' + $(this).val());
  });
  $('.rating-tooltip').rating({
    extendSymbol: function extendSymbol(rate) {
      $(this).tooltip({
        container: 'body',
        placement: 'bottom',
        title: 'Rate ' + rate
      });
    }
  });
  $('.rating-tooltip-manual').rating({
    extendSymbol: function extendSymbol() {
      var _title;

      $(this).tooltip({
        container: 'body',
        placement: 'bottom',
        trigger: 'manual',
        title: function title() {
          return _title;
        }
      });
      $(this).on('rating.rateenter', function (e, rate) {
        _title = rate;
        $(this).tooltip('show');
      }).on('rating.rateleave', function () {
        $(this).tooltip('hide');
      });
    }
  });
  $('.rating').each(function () {
    $('<span class="badge bg-info"></span>').text($(this).val() || '').insertAfter(this);
  });
  $('.rating').on('change', function () {
    $(this).next('.badge').text($(this).val());
  });
});
/******/ })()
;