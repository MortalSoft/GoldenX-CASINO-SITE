/******/ (function() { // webpackBootstrap
/*!**************************************************!*\
  !*** ./resources/js/pages/crypto-orders.init.js ***!
  \**************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Crypto orders select2 Js File
*/
// Select2
$(".select2-search-disable").select2({
  minimumResultsForSearch: Infinity
}); // datatable

$(document).ready(function () {
  $('.datatable').DataTable();
  $(".dataTables_length select").addClass('form-select form-select-sm');
});
/******/ })()
;