/******/ (function() { // webpackBootstrap
/*!**********************************************************!*\
  !*** ./resources/js/pages/two-step-verification.init.js ***!
  \**********************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: two step verification Init Js File
*/
// move next
$('input[id^=digit]').on('keyup', function (e) {
  var id = $(this).attr("id");
  var count = id.replace("digit", '');
  count++;
  $("#digit" + count).focus();
});
/******/ })()
;