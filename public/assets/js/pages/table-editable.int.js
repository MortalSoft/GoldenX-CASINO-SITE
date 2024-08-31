/******/ (function() { // webpackBootstrap
/*!**************************************************!*\
  !*** ./resources/js/pages/table-editable.int.js ***!
  \**************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Table editable Init Js File
*/
// table edits table
$(function () {
  var pickers = {};
  $('.table-edits tr').editable({
    dropdowns: {
      gender: ['Male', 'Female']
    },
    edit: function edit(values) {
      $(".edit i", this).removeClass('fa-pencil-alt').addClass('fa-save').attr('title', 'Save');
    },
    save: function save(values) {
      $(".edit i", this).removeClass('fa-save').addClass('fa-pencil-alt').attr('title', 'Edit');

      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    },
    cancel: function cancel(values) {
      $(".edit i", this).removeClass('fa-save').addClass('fa-pencil-alt').attr('title', 'Edit');

      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    }
  });
});
/******/ })()
;