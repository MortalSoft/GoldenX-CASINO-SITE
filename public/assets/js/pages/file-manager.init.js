/******/ (function() { // webpackBootstrap
/*!*************************************************!*\
  !*** ./resources/js/pages/file-manager.init.js ***!
  \*************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: file manager Init Js File
*/
var options = {
  series: [76],
  chart: {
    height: 150,
    type: 'radialBar',
    sparkline: {
      enabled: true
    }
  },
  colors: ['#556ee6'],
  plotOptions: {
    radialBar: {
      startAngle: -90,
      endAngle: 90,
      track: {
        background: "#e7e7e7",
        strokeWidth: '97%',
        margin: 5 // margin is in pixels

      },
      hollow: {
        size: '60%'
      },
      dataLabels: {
        name: {
          show: false
        },
        value: {
          offsetY: -2,
          fontSize: '16px'
        }
      }
    }
  },
  grid: {
    padding: {
      top: -10
    }
  },
  stroke: {
    dashArray: 3
  },
  labels: ['Storage']
};
var chart = new ApexCharts(document.querySelector("#radial-chart"), options);
chart.render();
/******/ })()
;