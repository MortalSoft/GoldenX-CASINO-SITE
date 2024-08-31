/******/ (function() { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./resources/js/pages/project-overview.init.js ***!
  \*****************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Project overview init js
*/

/********** overview chart ********/
var options = {
  chart: {
    height: 290,
    type: 'bar',
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      columnWidth: '14%',
      endingShape: 'rounded'
    }
  },
  dataLabels: {
    enabled: false
  },
  series: [{
    name: 'Overview',
    data: [42, 56, 40, 64, 26, 42, 56, 35, 62]
  }],
  grid: {
    yaxis: {
      lines: {
        show: false
      }
    }
  },
  yaxis: {
    title: {
      text: '% (Percentage)'
    }
  },
  xaxis: {
    labels: {
      rotate: -90
    },
    categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
    title: {
      text: 'Week'
    }
  },
  colors: ['#556ee6']
};
var chart = new ApexCharts(document.querySelector("#overview-chart"), options);
chart.render();
/******/ })()
;