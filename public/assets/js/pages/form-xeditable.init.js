/******/ (function() { // webpackBootstrap
/*!***************************************************!*\
  !*** ./resources/js/pages/form-xeditable.init.js ***!
  \***************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form-Xeditable Js File
*/
$(function () {
  //modify buttons style
  $.fn.editableform.buttons = '<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button>' + '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="mdi mdi-close"></i></button>'; //inline

  $('#inline-username').editable({
    type: 'text',
    pk: 1,
    name: 'username',
    title: 'Enter username',
    mode: 'inline',
    inputclass: 'form-control-sm'
  });
  $('#inline-firstname').editable({
    validate: function validate(value) {
      if ($.trim(value) == '') return 'This field is required';
    },
    mode: 'inline',
    inputclass: 'form-control-sm'
  });
  $('#inline-sex').editable({
    prepend: "not selected",
    mode: 'inline',
    inputclass: 'form-select form-select-sm',
    source: [{
      value: 1,
      text: 'Male'
    }, {
      value: 2,
      text: 'Female'
    }],
    display: function display(value, sourceData) {
      var colors = {
        "": "#98a6ad",
        1: "#5fbeaa",
        2: "#5d9cec"
      },
          elem = $.grep(sourceData, function (o) {
        return o.value == value;
      });

      if (elem.length) {
        $(this).text(elem[0].text).css("color", colors[value]);
      } else {
        $(this).empty();
      }
    }
  });
  $('#inline-group').editable({
    showbuttons: false,
    mode: 'inline',
    inputclass: 'form-select form-select-sm'
  });
  $('#inline-dob').editable({
    mode: 'inline',
    inputclass: 'form-select form-select-sm'
  });
  $('#inline-comments').editable({
    showbuttons: 'bottom',
    mode: 'inline',
    inputclass: 'form-control-sm'
  });
});
/******/ })()
;