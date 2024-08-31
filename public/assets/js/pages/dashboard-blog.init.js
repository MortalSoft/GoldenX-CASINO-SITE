/******/ (function() { // webpackBootstrap
/*!***************************************************!*\
  !*** ./resources/js/pages/dashboard-blog.init.js ***!
  \***************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Dashboard Blog Init Js File
*/
var options = {
  series: [{
    name: 'Current',
    data: [18, 21, 45, 36, 65, 47, 51, 32, 40, 28, 31, 26]
  }, {
    name: 'Previous',
    data: [30, 11, 22, 18, 32, 23, 58, 45, 30, 36, 15, 34]
  }],
  chart: {
    height: 350,
    type: 'area',
    toolbar: {
      show: false
    }
  },
  colors: ['#556ee6', '#f1b44c'],
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 2
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      inverseColors: false,
      opacityFrom: 0.45,
      opacityTo: 0.05,
      stops: [20, 100, 100, 100]
    }
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  markers: {
    size: 3,
    strokeWidth: 3,
    hover: {
      size: 4,
      sizeOffset: 2
    }
  },
  legend: {
    position: 'top',
    horizontalAlign: 'right'
  }
};
var chart = new ApexCharts(document.querySelector("#area-chart"), options);
chart.render();
/******/ })()
;