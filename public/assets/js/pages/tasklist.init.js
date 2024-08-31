/******/ (function() { // webpackBootstrap
/*!*********************************************!*\
  !*** ./resources/js/pages/tasklist.init.js ***!
  \*********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Task list Init Js File
*/
var options = {
  chart: {
    height: 280,
    type: 'line',
    stacked: false,
    toolbar: {
      show: false
    }
  },
  stroke: {
    width: [0, 2, 5],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '20%',
      endingShape: 'rounded'
    }
  },
  colors: ['#556ee6', '#34c38f'],
  series: [{
    name: 'Complete Tasks',
    type: 'column',
    data: [23, 11, 22, 27, 13, 22, 52, 21, 44, 22, 30]
  }, {
    name: 'All Tasks',
    type: 'line',
    data: [23, 11, 34, 27, 17, 22, 62, 32, 44, 22, 39]
  }],
  fill: {
    gradient: {
      inverseColors: false,
      shade: 'light',
      type: "vertical",
      opacityFrom: 0.85,
      opacityTo: 0.55,
      stops: [0, 100, 100, 100]
    }
  },
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
  markers: {
    size: 0
  },
  yaxis: {
    min: 0
  }
};
var chart = new ApexCharts(document.querySelector("#task-chart"), options);
chart.render();
/******/ })()
;