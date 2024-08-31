/******/ (function() { // webpackBootstrap
/*!*************************************************!*\
  !*** ./resources/js/pages/form-repeater.int.js ***!
  \*************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form repeater Js File
*/
$(document).ready(function () {
  'use strict';

  $('.repeater').repeater({
    defaultValues: {
      'textarea-input': 'foo',
      'text-input': 'bar',
      'select-input': 'B',
      'checkbox-input': ['A', 'B'],
      'radio-input': 'B'
    },
    show: function show() {
      $(this).slideDown();
    },
    hide: function hide(deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    },
    ready: function ready(setIndexes) {}
  });
  window.outerRepeater = $('.outer-repeater').repeater({
    defaultValues: {
      'text-input': 'outer-default'
    },
    show: function show() {
      console.log('outer show');
      $(this).slideDown();
    },
    hide: function hide(deleteElement) {
      console.log('outer delete');
      $(this).slideUp(deleteElement);
    },
    repeaters: [{
      selector: '.inner-repeater',
      defaultValues: {
        'inner-text-input': 'inner-default'
      },
      show: function show() {
        console.log('inner show');
        $(this).slideDown();
      },
      hide: function hide(deleteElement) {
        console.log('inner delete');
        $(this).slideUp(deleteElement);
      }
    }]
  });
});
/******/ })()
;