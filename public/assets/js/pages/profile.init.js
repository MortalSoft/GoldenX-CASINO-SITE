/******/ (function() { // webpackBootstrap
/*!********************************************!*\
  !*** ./resources/js/pages/profile.init.js ***!
  \********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Profile Init Js File
*/
var options = {
  chart: {
    height: 330,
    type: 'bar',
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '14%',
      endingShape: 'rounded'
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  series: [{
    name: 'Revenue',
    data: [42, 85, 101, 56, 37, 105, 38, 58, 92, 82, 72, 32]
  }],
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  yaxis: {
    title: {
      text: '$ (thousands)'
    }
  },
  fill: {
    opacity: 1
  },
  colors: ['#556ee6']
};
var chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
chart.render();
/******/ })()
;