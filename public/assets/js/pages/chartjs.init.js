/******/ (function() { // webpackBootstrap
/*!********************************************!*\
  !*** ./resources/js/pages/chartjs.init.js ***!
  \********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: ChartJs init Js File
*/
!function ($) {
  "use strict";

  var ChartJs = function ChartJs() {};

  ChartJs.prototype.respChart = function (selector, type, data, options) {
    Chart.defaults.global.defaultFontColor = "#8791af", Chart.defaults.scale.gridLines.color = "rgba(166, 176, 207, 0.1)"; // get selector by context

    var ctx = selector.get(0).getContext("2d"); // pointing parent container to make chart js inherit its width

    var container = $(selector).parent(); // enable resizing matter

    $(window).resize(generateChart); // this function produce the responsive Chart JS

    function generateChart() {
      // make chart width fit with its container
      var ww = selector.attr('width', $(container).width());

      switch (type) {
        case 'Line':
          new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
          });
          break;

        case 'Doughnut':
          new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
          });
          break;

        case 'Pie':
          new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
          });
          break;

        case 'Bar':
          new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
          });
          break;

        case 'Radar':
          new Chart(ctx, {
            type: 'radar',
            data: data,
            options: options
          });
          break;

        case 'PolarArea':
          new Chart(ctx, {
            data: data,
            type: 'polarArea',
            options: options
          });
          break;
      } // Initiate new chart or Redraw

    }

    ; // run function - render chart at first load

    generateChart();
  }, //init
  ChartJs.prototype.init = function () {
    //creating lineChart
    var lineChart = {
      labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
      datasets: [{
        label: "Sales Analytics",
        fill: true,
        lineTension: 0.5,
        backgroundColor: "rgba(85, 110, 230, 0.2)",
        borderColor: "#556ee6",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "#556ee6",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "#556ee6",
        pointHoverBorderColor: "#fff",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: [65, 59, 80, 81, 56, 55, 40, 55, 30, 80]
      }, {
        label: "Monthly Earnings",
        fill: true,
        lineTension: 0.5,
        backgroundColor: "rgba(235, 239, 242, 0.2)",
        borderColor: "#ebeff2",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: "#ebeff2",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "#ebeff2",
        pointHoverBorderColor: "#eef0f2",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: [80, 23, 56, 65, 23, 35, 85, 25, 92, 36]
      }]
    };
    var lineOpts = {
      scales: {
        yAxes: [{
          ticks: {
            max: 100,
            min: 20,
            stepSize: 10
          }
        }]
      }
    };
    this.respChart($("#lineChart"), 'Line', lineChart, lineOpts); //donut chart

    var donutChart = {
      labels: ["Desktops", "Tablets"],
      datasets: [{
        data: [300, 210],
        backgroundColor: ["#556ee6", "#ebeff2"],
        hoverBackgroundColor: ["#556ee6", "#ebeff2"],
        hoverBorderColor: "#fff"
      }]
    };
    this.respChart($("#doughnut"), 'Doughnut', donutChart); //Pie chart

    var pieChart = {
      labels: ["Desktops", "Tablets"],
      datasets: [{
        data: [300, 180],
        backgroundColor: ["#34c38f", "#ebeff2"],
        hoverBackgroundColor: ["#34c38f", "#ebeff2"],
        hoverBorderColor: "#fff"
      }]
    };
    this.respChart($("#pie"), 'Pie', pieChart); //barchart

    var barChart = {
      labels: ["January", "February", "March", "April", "May", "June", "July"],
      datasets: [{
        label: "Sales Analytics",
        backgroundColor: "rgba(52, 195, 143, 0.8)",
        borderColor: "rgba(52, 195, 143, 0.8)",
        borderWidth: 1,
        hoverBackgroundColor: "rgba(52, 195, 143, 0.9)",
        hoverBorderColor: "rgba(52, 195, 143, 0.9)",
        data: [65, 59, 81, 45, 56, 80, 50, 20]
      }]
    };
    var barOpts = {
      scales: {
        xAxes: [{
          barPercentage: 0.4
        }]
      }
    };
    this.respChart($("#bar"), 'Bar', barChart, barOpts); //radar chart

    var radarChart = {
      labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
      datasets: [{
        label: "Desktops",
        backgroundColor: "rgba(52, 195, 143, 0.2)",
        borderColor: "#34c38f",
        pointBackgroundColor: "#34c38f",
        pointBorderColor: "#fff",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "#34c38f",
        data: [65, 59, 90, 81, 56, 55, 40]
      }, {
        label: "Tablets",
        backgroundColor: "rgba(85, 110, 230, 0.2)",
        borderColor: "#556ee6",
        pointBackgroundColor: "#556ee6",
        pointBorderColor: "#fff",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "#556ee6",
        data: [28, 48, 40, 19, 96, 27, 100]
      }]
    };
    this.respChart($("#radar"), 'Radar', radarChart); //Polar area  chart

    var polarChart = {
      datasets: [{
        data: [11, 16, 7, 18],
        backgroundColor: ["#f46a6a", "#34c38f", "#f1b44c", "#556ee6"],
        label: 'My dataset',
        // for legend
        hoverBorderColor: "#fff"
      }],
      labels: ["Series 1", "Series 2", "Series 3", "Series 4"]
    };
    this.respChart($("#polarArea"), 'PolarArea', polarChart);
  }, $.ChartJs = new ChartJs(), $.ChartJs.Constructor = ChartJs;
}(window.jQuery), //initializing
function ($) {
  "use strict";

  $.ChartJs.init();
}(window.jQuery);
/******/ })()
;