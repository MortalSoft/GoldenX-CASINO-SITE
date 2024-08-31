/******/ (function() { // webpackBootstrap
/*!***********************************************!*\
  !*** ./resources/js/pages/tui-charts.init.js ***!
  \***********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Tui charts init Js File
*/
// Bar charts
var barChartWidth = $("#bar-charts").width();
var container = document.getElementById('bar-charts');
var data = {
  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
  series: [{
    name: 'Budget',
    data: [5000, 3000, 5000, 7000, 6000, 4000]
  }, {
    name: 'Income',
    data: [8000, 1000, 7000, 2000, 5000, 3000]
  }]
};
var options = {
  chart: {
    width: barChartWidth,
    height: 380,
    title: 'Monthly Revenue',
    format: '1,000'
  },
  yAxis: {
    title: 'Month'
  },
  xAxis: {
    title: 'Amount',
    min: 0,
    max: 9000,
    suffix: '$'
  },
  series: {
    showLabel: false
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  series: {
    colors: ['#556ee6', '#34c38f']
  },
  legend: {
    label: {
      color: '#8791af'
    }
  }
};
tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var barChart = tui.chart.barChart(container, data, options);
$(window).resize(function () {
  barChartWidth = $("#bar-charts").width();
  barChart.resize({
    width: barChartWidth,
    height: 350
  });
}); // column charts

var columnChartWidth = $("#column-charts").width();
var container = document.getElementById('column-charts');
var data = {
  categories: ['Jun, 2019', 'Jul, 2019', 'Aug, 2019', 'Sep, 2019', 'Oct, 2019', 'Nov, 2019', 'Dec, 2019'],
  series: [{
    name: 'Budget',
    data: [5000, 3000, 5000, 7000, 6000, 4000, 1000]
  }, {
    name: 'Income',
    data: [8000, 1000, 7000, 2000, 6000, 3000, 5000]
  }, {
    name: 'Expenses',
    data: [4000, 4000, 6000, 3000, 4000, 5000, 7000]
  }]
};
var options = {
  chart: {
    width: columnChartWidth,
    height: 380,
    title: 'Monthly Revenue',
    format: '1,000'
  },
  yAxis: {
    title: 'Amount',
    min: 0,
    max: 9000
  },
  xAxis: {
    title: 'Month'
  },
  legend: {
    align: 'top'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#34c38f', '#556ee6', '#f46a6a']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var columnChart = tui.chart.columnChart(container, data, options);
$(window).resize(function () {
  columnChartWidth = $("#column-charts").width();
  columnChart.resize({
    width: columnChartWidth,
    height: 350
  });
}); // Line charts

var lineChartWidth = $("#line-charts").width();
var container = document.getElementById('line-charts');
var data = {
  categories: ['June', 'July', 'Aug', 'Sep', 'Oct', 'Nov'],
  series: [{
    name: 'Budget',
    data: [5000, 3000, 6000, 3000, 6000, 4000]
  }, {
    name: 'Income',
    data: [8000, 1000, 7000, 2000, 5000, 3000]
  }, {
    name: 'Outgo',
    data: [900, 6000, 1000, 9000, 3000, 1000]
  }]
};
var options = {
  chart: {
    width: lineChartWidth,
    height: 380,
    title: '24-hr Average Temperature'
  },
  yAxis: {
    title: 'Amount',
    pointOnColumn: true
  },
  xAxis: {
    title: 'Month'
  },
  series: {
    spline: true,
    showDot: false
  },
  tooltip: {
    suffix: '°C'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#f46a6a', '#34c38f', '#556ee6']
  }
};
tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var lineChart = tui.chart.lineChart(container, data, options);
$(window).resize(function () {
  lineChartWidth = $("#line-charts").width();
  lineChart.resize({
    width: lineChartWidth,
    height: 350
  });
}); // Area charts

var areaChartWidth = $("#area-charts").width();
var container = document.getElementById('area-charts');
var data = {
  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  series: [{
    name: 'Seoul',
    data: [20, 40, 25, 50, 15, 45, 33, 34, 20, 30, 22, 13]
  }, {
    name: 'Sydney',
    data: [5, 30, 21, 18, 59, 50, 28, 33, 7, 20, 10, 30]
  }, {
    name: 'Moskva',
    data: [30, 5, 18, 21, 33, 41, 29, 15, 30, 10, 33, 5]
  }]
};
var options = {
  chart: {
    width: areaChartWidth,
    height: 380,
    title: '24-hr Average Temperature'
  },
  series: {
    zoomable: true,
    showDot: false,
    areaOpacity: 1
  },
  yAxis: {
    title: 'Temperature (Celsius)',
    pointOnColumn: true
  },
  xAxis: {
    title: 'Month'
  },
  tooltip: {
    suffix: '°C'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#f46a6a', '#34c38f', '#556ee6']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var areaChart = tui.chart.areaChart(container, data, options);
$(window).resize(function () {
  areaChartWidth = $("#area-charts").width();
  areaChart.resize({
    width: areaChartWidth,
    height: 350
  });
}); // Radial charts

var radialChartWidth = $("#radial-charts").width();
var container = document.getElementById('radial-charts');
var data = {
  categories: ["Jan", "Feb", "Mar", "April", "May", "Jun"],
  series: [{
    name: 'Budget',
    data: [5000, 3000, 5000, 7000, 6000, 4000]
  }, {
    name: 'Income',
    data: [8000, 8000, 7000, 2000, 5000, 3000]
  }, {
    name: 'Expenses',
    data: [4000, 4000, 6000, 3000, 4000, 5000]
  }, {
    name: 'Debt',
    data: [6000, 3000, 3000, 1000, 2000, 4000]
  }]
};
var options = {
  chart: {
    title: 'Annual Incomes',
    width: radialChartWidth,
    height: 380
  },
  series: {
    showDot: false,
    showArea: false
  },
  plot: {
    type: 'circle'
  },
  legend: {
    align: 'bottom'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f', '#f1b44c', '#f46a6a']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var radialChart = tui.chart.radialChart(container, data, options);
$(window).resize(function () {
  radialChartWidth = $("#radial-charts").width();
  radialChart.resize({
    width: radialChartWidth,
    height: 350
  });
}); // Bubble chart

var bubbleChartWidth = $("#bubble-charts").width();
var container = document.getElementById('bubble-charts');
var data = {
  series: [{
    name: 'Africa',
    data: [{
      x: 4200,
      y: 70.35,
      r: 32209101,
      label: 'Morocco'
    }, {
      x: 4200,
      y: 70.71,
      r: 76117421,
      label: 'Egypt'
    }, {
      x: 5900,
      y: 56.46,
      r: 1355246,
      label: 'Gabon'
    }, {
      x: 6600,
      y: 72.74,
      r: 32129324,
      label: 'Algeria'
    }, {
      x: 6700,
      y: 76.28,
      r: 5631585,
      label: 'Libya'
    }, {
      x: 7100,
      y: 74.66,
      r: 9974722,
      label: 'Tunisia'
    }, {
      x: 10500,
      y: 69.28,
      r: 1096585,
      label: 'Trinidad and Tobago'
    }, {
      x: 12800,
      y: 72.09,
      r: 1220481,
      label: 'Mauritius'
    }, {
      x: 18200,
      y: 78.68,
      r: 396851,
      label: 'Malta'
    }]
  }, {
    name: 'America',
    data: [{
      x: 4800,
      y: 74.64,
      r: 6191368,
      label: 'Paraguay'
    }, {
      x: 4900,
      y: 70.92,
      r: 6587541,
      label: 'El Salvador'
    }, {
      x: 5600,
      y: 69.22,
      r: 2754430,
      label: 'Peru'
    }, {
      x: 5800,
      y: 74.06,
      r: 2501738,
      label: 'Venezuela'
    }, {
      x: 6300,
      y: 67.63,
      r: 8833634,
      label: 'Dominican Republic'
    }, {
      x: 6500,
      y: 67.43,
      r: 272945,
      label: 'Belize'
    }, {
      x: 6600,
      y: 71.43,
      r: 4231077,
      label: 'Colombia'
    }, {
      x: 6900,
      y: 72.14,
      r: 3000463,
      label: 'Panama'
    }, {
      x: 8100,
      y: 71.41,
      r: 78410118,
      label: 'Brazil'
    }, {
      x: 9600,
      y: 76.63,
      r: 3956507,
      label: 'Costa Rica'
    }, {
      x: 9600,
      y: 74.94,
      r: 4495959,
      label: 'Mexico'
    }, {
      x: 12400,
      y: 75.7,
      r: 6914475,
      label: 'Argentina'
    }, {
      x: 14500,
      y: 75.92,
      r: 3399237,
      label: 'Uruguay'
    }, {
      x: 16400,
      y: 71.64,
      r: 278289,
      label: 'Barbados'
    }, {
      x: 17700,
      y: 65.63,
      r: 299697,
      label: 'Bahamas, The'
    }, {
      x: 17700,
      y: 77.49,
      r: 3897960,
      label: 'Puerto Rico'
    }, {
      x: 31500,
      y: 79.96,
      r: 32507874,
      label: 'Canada'
    }, {
      x: 32100,
      y: 77.43,
      r: 89302754,
      label: 'United States'
    }]
  }, {
    name: 'Asia',
    data: [{
      x: 5600,
      y: 71.96,
      r: 92988000,
      label: 'China'
    }, {
      x: 5700,
      y: 61.29,
      r: 4863169,
      label: 'Turkmenistan'
    }, {
      x: 7700,
      y: 69.66,
      r: 19018924,
      label: 'Iran'
    }, {
      x: 7800,
      y: 66.07,
      r: 1514370,
      label: 'Kazakhstan'
    }, {
      x: 8100,
      y: 71.41,
      r: 14865523,
      label: 'Thailand'
    }, {
      x: 9700,
      y: 71.95,
      r: 23522482,
      label: 'Malaysia'
    }, {
      x: 12000,
      y: 75.23,
      r: 25795938,
      label: 'Saudi Arabia'
    }, {
      x: 13100,
      y: 72.85,
      r: 2903165,
      label: 'Oman'
    }, {
      x: 19200,
      y: 75.58,
      r: 48598170,
      label: 'Korea, South'
    }, {
      x: 19200,
      y: 73.98,
      r: 677886,
      label: 'Bahrain'
    }, {
      x: 20800,
      y: 79.17,
      r: 6199008,
      label: 'Israel'
    }, {
      x: 21300,
      y: 76.84,
      r: 2257549,
      label: 'Kuwait'
    }, {
      x: 23200,
      y: 73.4,
      r: 840290,
      label: 'Qatar'
    }, {
      x: 25200,
      y: 74.99,
      r: 2523915,
      label: 'United Arab Emirates'
    }, {
      x: 25300,
      y: 77.06,
      r: 22749838,
      label: 'Taiwan'
    }, {
      x: 27800,
      y: 81.53,
      r: 4353893,
      label: 'Singapore'
    }, {
      x: 29400,
      y: 81.04,
      r: 52733300,
      label: 'Japan'
    }, {
      x: 34200,
      y: 81.39,
      r: 6855125,
      label: 'Hong Kong'
    }]
  }, {
    name: 'Europe',
    data: [{
      x: 7700,
      y: 71.12,
      r: 2235555,
      label: 'Romania'
    }, {
      x: 8200,
      y: 71.75,
      r: 7517973,
      label: 'Bulgaria'
    }, {
      x: 9800,
      y: 66.39,
      r: 54378233,
      label: 'Russia'
    }, {
      x: 10700,
      y: 76.38,
      r: 1582395,
      label: 'Chile'
    }, {
      x: 11200,
      y: 74.14,
      r: 4496869,
      label: 'Croatia'
    }, {
      x: 11500,
      y: 70.86,
      r: 2306306,
      label: 'Latvia'
    }, {
      x: 12000,
      y: 74.16,
      r: 38626349,
      label: 'Poland'
    }, {
      x: 12500,
      y: 73.46,
      r: 3607899,
      label: 'Lithuania'
    }, {
      x: 14300,
      y: 71.38,
      r: 1341664,
      label: 'Estonia'
    }, {
      x: 14500,
      y: 74.19,
      r: 5423567,
      label: 'Slovakia'
    }, {
      x: 14900,
      y: 72.25,
      r: 1003237,
      label: 'Hungary'
    }, {
      x: 16800,
      y: 75.78,
      r: 1024617,
      label: 'Czech Republic'
    }, {
      x: 17900,
      y: 77.35,
      r: 1052414,
      label: 'Portugal'
    }, {
      x: 19600,
      y: 75.93,
      r: 2011473,
      label: 'Slovenia'
    }, {
      x: 21300,
      y: 78.94,
      r: 10647529,
      label: 'Greece'
    }, {
      x: 23300,
      y: 79.37,
      r: 40280780,
      label: 'Spain'
    }, {
      x: 27700,
      y: 79.54,
      r: 58057477,
      label: 'Italy'
    }, {
      x: 28400,
      y: 80.3,
      r: 898640,
      label: 'Sweden'
    }, {
      x: 28700,
      y: 78.54,
      r: 22424609,
      label: 'Germany'
    }, {
      x: 28700,
      y: 79.44,
      r: 30424213,
      label: 'France'
    }, {
      x: 29000,
      y: 78.24,
      r: 5214512,
      label: 'Finland'
    }, {
      x: 29500,
      y: 78.68,
      r: 16318199,
      label: 'Netherlands'
    }, {
      x: 29600,
      y: 78.27,
      r: 60270708,
      label: 'United Kingdom'
    }, {
      x: 30600,
      y: 78.44,
      r: 10348276,
      label: 'Belgium'
    }, {
      x: 31300,
      y: 78.87,
      r: 8174762,
      label: 'Austria'
    }, {
      x: 31900,
      y: 77.36,
      r: 3969558,
      label: 'Ireland'
    }, {
      x: 31900,
      y: 80.18,
      r: 293966,
      label: 'Iceland'
    }, {
      x: 32200,
      y: 77.44,
      r: 5413392,
      label: 'Denmark'
    }, {
      x: 33800,
      y: 80.31,
      r: 7450867,
      label: 'Switzerland'
    }]
  }, {
    name: 'Oceania',
    data: [{
      x: 2200,
      y: 64.56,
      r: 5420280,
      label: 'Papua New Guinea'
    }, {
      x: 2700,
      y: 61.32,
      r: 100798,
      label: 'Kiribati'
    }, {
      x: 5900,
      y: 69.2,
      r: 880874,
      label: 'Fiji'
    }, {
      x: 14500,
      y: 78.75,
      r: 108775,
      label: 'Virgin Islands'
    }, {
      x: 23200,
      y: 78.49,
      r: 1993817,
      label: 'New Zealand'
    }, {
      x: 30700,
      y: 80.26,
      r: 5991314,
      label: 'Australia'
    }]
  }]
};
var options = {
  chart: {
    width: radialChartWidth,
    height: 380,
    title: 'Life Expectancy per GDP',
    format: function format(value, chartType, areaType, valueType) {
      if (valueType === 'r' || valueType === 'x') {
        value = tui.chart.renderUtil.formatToComma(value);

        if (valueType === 'x') {
          value = '$' + value;
        }
      }

      return value;
    }
  },
  yAxis: {
    title: 'Life Expectancy (years)'
  },
  xAxis: {
    title: 'GDP'
  },
  tooltip: {
    template: function template(category, items) {
      return '<div class="tui-chart-default-tooltip">' + '<div class="tui-chart-tooltip-head">' + '<span class="tui-chart-legend-rect" style="' + items.cssText + '; width: 10px; height: 10px"></span>' + '<span>' + items.legend + '</span>' + '<span>' + items.label + '</span>' + '</div>' + '<table class="tui-chart-tooltip-body">' + '<tr>' + '<td>GDP</td>' + '<td class="tui-chart-tooltip-value">' + items.x + '</td>' + '</tr>' + '<tr>' + '<td>Life Expectancy</td>' + '<td class="tui-chart-tooltip-value">' + items.y + '</td>' + '</tr>' + '<tr>' + '<td>Population</td>' + '<td class="tui-chart-tooltip-value">' + items.r + '</td>' + '</tr>' + '</table>';
      '</div>';
    }
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f', '#f1b44c', '#f46a6a']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var bubbleChart = tui.chart.bubbleChart(container, data, options);
$(window).resize(function () {
  bubbleChartWidth = $("#bubble-charts").width();
  bubbleChart.resize({
    width: bubbleChartWidth,
    height: 350
  });
}); // Scatter chart

var scatterChartWidth = $("#scatter-charts").width();
var container = document.getElementById('scatter-charts');
var data = {
  series: [{
    name: 'male',
    data: [{
      x: 174,
      y: 65.6
    }, {
      x: 175.3,
      y: 71.8
    }, {
      x: 193.5,
      y: 80.7
    }, {
      x: 186.5,
      y: 72.6
    }, {
      x: 187.2,
      y: 78.8
    }, {
      x: 181.5,
      y: 74.8
    }, {
      x: 184,
      y: 86.4
    }, {
      x: 184.5,
      y: 78.4
    }, {
      x: 175,
      y: 62
    }, {
      x: 184,
      y: 81.6
    }, {
      x: 180,
      y: 76.6
    }, {
      x: 177.8,
      y: 83.6
    }, {
      x: 192,
      y: 90
    }, {
      x: 176,
      y: 74.6
    }, {
      x: 174,
      y: 71
    }, {
      x: 184,
      y: 79.6
    }, {
      x: 192.7,
      y: 93.8
    }, {
      x: 171.5,
      y: 70
    }, {
      x: 173,
      y: 72.4
    }, {
      x: 176,
      y: 85.9
    }, {
      x: 176,
      y: 78.8
    }, {
      x: 180.5,
      y: 77.8
    }, {
      x: 172.7,
      y: 66.2
    }, {
      x: 176,
      y: 86.4
    }, {
      x: 173.5,
      y: 81.8
    }, {
      x: 178,
      y: 89.6
    }, {
      x: 180.3,
      y: 82.8
    }, {
      x: 180.3,
      y: 76.4
    }, {
      x: 164.5,
      y: 63.2
    }, {
      x: 173,
      y: 60.9
    }, {
      x: 183.5,
      y: 74.8
    }, {
      x: 175.5,
      y: 70
    }, {
      x: 188,
      y: 72.4
    }, {
      x: 189.2,
      y: 84.1
    }, {
      x: 172.8,
      y: 69.1
    }, {
      x: 170,
      y: 59.5
    }, {
      x: 182,
      y: 67.2
    }, {
      x: 170,
      y: 61.3
    }, {
      x: 177.8,
      y: 68.6
    }, {
      x: 184.2,
      y: 80.1
    }, {
      x: 186.7,
      y: 87.8
    }, {
      x: 171.4,
      y: 84.7
    }, {
      x: 172.7,
      y: 73.4
    }, {
      x: 175.3,
      y: 72.1
    }, {
      x: 180.3,
      y: 82.6
    }, {
      x: 182.9,
      y: 88.7
    }, {
      x: 188,
      y: 84.1
    }, {
      x: 177.2,
      y: 94.1
    }, {
      x: 172.1,
      y: 74.9
    }, {
      x: 167,
      y: 59.1
    }, {
      x: 169.5,
      y: 75.6
    }, {
      x: 174,
      y: 86.2
    }, {
      x: 172.7,
      y: 75.3
    }, {
      x: 182.2,
      y: 87.1
    }, {
      x: 164.1,
      y: 55.2
    }, {
      x: 163,
      y: 57
    }, {
      x: 171.5,
      y: 61.4
    }, {
      x: 184.2,
      y: 76.8
    }, {
      x: 174,
      y: 86.8
    }, {
      x: 174,
      y: 72.2
    }, {
      x: 177,
      y: 71.6
    }, {
      x: 186,
      y: 84.8
    }, {
      x: 167,
      y: 68.2
    }, {
      x: 171.8,
      y: 66.1
    }, {
      x: 182,
      y: 72
    }, {
      x: 167,
      y: 64.6
    }, {
      x: 177.8,
      y: 74.8
    }, {
      x: 164.5,
      y: 70
    }, {
      x: 192,
      y: 101.6
    }, {
      x: 175.5,
      y: 63.2
    }, {
      x: 171.2,
      y: 79.1
    }, {
      x: 181.6,
      y: 78.9
    }, {
      x: 167.4,
      y: 67.7
    }, {
      x: 181.1,
      y: 66
    }, {
      x: 177,
      y: 68.2
    }, {
      x: 174.5,
      y: 63.9
    }, {
      x: 177.5,
      y: 72
    }, {
      x: 170.5,
      y: 56.8
    }, {
      x: 182.4,
      y: 74.5
    }, {
      x: 197.1,
      y: 90.9
    }, {
      x: 180.1,
      y: 93
    }, {
      x: 175.5,
      y: 80.9
    }, {
      x: 180.6,
      y: 72.7
    }, {
      x: 184.4,
      y: 68
    }, {
      x: 175.5,
      y: 70.9
    }, {
      x: 180.6,
      y: 72.5
    }, {
      x: 177,
      y: 72.5
    }, {
      x: 177.1,
      y: 83.4
    }, {
      x: 181.6,
      y: 75.5
    }, {
      x: 176.5,
      y: 73
    }, {
      x: 175,
      y: 70.2
    }, {
      x: 174,
      y: 73.4
    }, {
      x: 165.1,
      y: 70.5
    }, {
      x: 177,
      y: 68.9
    }, {
      x: 192,
      y: 102.3
    }, {
      x: 176.5,
      y: 68.4
    }, {
      x: 169.4,
      y: 65.9
    }, {
      x: 182.1,
      y: 75.7
    }, {
      x: 179.8,
      y: 84.5
    }, {
      x: 175.3,
      y: 87.7
    }, {
      x: 184.9,
      y: 86.4
    }, {
      x: 177.3,
      y: 73.2
    }, {
      x: 167.4,
      y: 53.9
    }, {
      x: 178.1,
      y: 72
    }, {
      x: 168.9,
      y: 55.5
    }, {
      x: 157.2,
      y: 58.4
    }, {
      x: 180.3,
      y: 83.2
    }, {
      x: 170.2,
      y: 72.7
    }, {
      x: 177.8,
      y: 64.1
    }, {
      x: 172.7,
      y: 72.3
    }, {
      x: 165.1,
      y: 65
    }, {
      x: 186.7,
      y: 86.4
    }, {
      x: 165.1,
      y: 65
    }, {
      x: 174,
      y: 88.6
    }, {
      x: 175.3,
      y: 84.1
    }, {
      x: 185.4,
      y: 66.8
    }, {
      x: 177.8,
      y: 75.5
    }, {
      x: 180.3,
      y: 93.2
    }, {
      x: 180.3,
      y: 82.7
    }, {
      x: 177.8,
      y: 58
    }, {
      x: 177.8,
      y: 79.5
    }, {
      x: 177.8,
      y: 78.6
    }, {
      x: 177.8,
      y: 71.8
    }, {
      x: 177.8,
      y: 116.4
    }, {
      x: 163.8,
      y: 72.2
    }, {
      x: 188,
      y: 83.6
    }, {
      x: 198.1,
      y: 85.5
    }, {
      x: 175.3,
      y: 90.9
    }, {
      x: 166.4,
      y: 85.9
    }, {
      x: 190.5,
      y: 89.1
    }, {
      x: 166.4,
      y: 75
    }, {
      x: 177.8,
      y: 77.7
    }, {
      x: 179.7,
      y: 86.4
    }, {
      x: 172.7,
      y: 90.9
    }, {
      x: 190.5,
      y: 73.6
    }, {
      x: 185.4,
      y: 76.4
    }, {
      x: 168.9,
      y: 69.1
    }, {
      x: 167.6,
      y: 84.5
    }, {
      x: 175.3,
      y: 64.5
    }, {
      x: 170.2,
      y: 69.1
    }, {
      x: 190.5,
      y: 108.6
    }, {
      x: 177.8,
      y: 86.4
    }, {
      x: 190.5,
      y: 80.9
    }, {
      x: 177.8,
      y: 87.7
    }, {
      x: 184.2,
      y: 94.5
    }, {
      x: 176.5,
      y: 80.2
    }, {
      x: 177.8,
      y: 72
    }, {
      x: 180.3,
      y: 71.4
    }, {
      x: 171.4,
      y: 72.7
    }, {
      x: 172.7,
      y: 84.1
    }, {
      x: 172.7,
      y: 76.8
    }, {
      x: 177.8,
      y: 63.6
    }, {
      x: 177.8,
      y: 80.9
    }, {
      x: 182.9,
      y: 80.9
    }, {
      x: 170.2,
      y: 85.5
    }, {
      x: 167.6,
      y: 68.6
    }, {
      x: 175.3,
      y: 67.7
    }, {
      x: 165.1,
      y: 66.4
    }, {
      x: 185.4,
      y: 102.3
    }, {
      x: 181.6,
      y: 70.5
    }, {
      x: 172.7,
      y: 95.9
    }, {
      x: 190.5,
      y: 84.1
    }, {
      x: 179.1,
      y: 87.3
    }, {
      x: 175.3,
      y: 71.8
    }, {
      x: 170.2,
      y: 65.9
    }, {
      x: 193,
      y: 95.9
    }, {
      x: 171.4,
      y: 91.4
    }, {
      x: 177.8,
      y: 81.8
    }, {
      x: 177.8,
      y: 96.8
    }, {
      x: 167.6,
      y: 69.1
    }, {
      x: 167.6,
      y: 82.7
    }, {
      x: 180.3,
      y: 75.5
    }, {
      x: 182.9,
      y: 79.5
    }, {
      x: 176.5,
      y: 73.6
    }, {
      x: 186.7,
      y: 91.8
    }, {
      x: 188,
      y: 84.1
    }, {
      x: 188,
      y: 85.9
    }, {
      x: 177.8,
      y: 81.8
    }, {
      x: 174,
      y: 82.5
    }, {
      x: 177.8,
      y: 80.5
    }, {
      x: 171.4,
      y: 70
    }, {
      x: 185.4,
      y: 81.8
    }, {
      x: 185.4,
      y: 84.1
    }, {
      x: 188,
      y: 90.5
    }, {
      x: 188,
      y: 91.4
    }, {
      x: 182.9,
      y: 89.1
    }, {
      x: 176.5,
      y: 85
    }, {
      x: 175.3,
      y: 69.1
    }, {
      x: 175.3,
      y: 73.6
    }, {
      x: 188,
      y: 80.5
    }, {
      x: 188,
      y: 82.7
    }, {
      x: 175.3,
      y: 86.4
    }, {
      x: 170.5,
      y: 67.7
    }, {
      x: 179.1,
      y: 92.7
    }, {
      x: 177.8,
      y: 93.6
    }, {
      x: 175.3,
      y: 70.9
    }, {
      x: 182.9,
      y: 75
    }, {
      x: 170.8,
      y: 93.2
    }, {
      x: 188,
      y: 93.2
    }, {
      x: 180.3,
      y: 77.7
    }, {
      x: 177.8,
      y: 61.4
    }, {
      x: 185.4,
      y: 94.1
    }, {
      x: 168.9,
      y: 75
    }, {
      x: 185.4,
      y: 83.6
    }, {
      x: 180.3,
      y: 85.5
    }, {
      x: 174,
      y: 73.9
    }, {
      x: 167.6,
      y: 66.8
    }, {
      x: 182.9,
      y: 87.3
    }, {
      x: 160,
      y: 72.3
    }, {
      x: 180.3,
      y: 88.6
    }, {
      x: 167.6,
      y: 75.5
    }, {
      x: 186.7,
      y: 101.4
    }, {
      x: 175.3,
      y: 91.1
    }, {
      x: 175.3,
      y: 67.3
    }, {
      x: 175.9,
      y: 77.7
    }, {
      x: 175.3,
      y: 81.8
    }, {
      x: 179.1,
      y: 75.5
    }, {
      x: 181.6,
      y: 84.5
    }, {
      x: 177.8,
      y: 76.6
    }, {
      x: 182.9,
      y: 85
    }, {
      x: 177.8,
      y: 102.5
    }, {
      x: 184.2,
      y: 77.3
    }, {
      x: 179.1,
      y: 71.8
    }, {
      x: 176.5,
      y: 87.9
    }, {
      x: 188,
      y: 94.3
    }, {
      x: 174,
      y: 70.9
    }, {
      x: 167.6,
      y: 64.5
    }, {
      x: 170.2,
      y: 77.3
    }, {
      x: 167.6,
      y: 72.3
    }, {
      x: 188,
      y: 87.3
    }, {
      x: 174,
      y: 80
    }, {
      x: 176.5,
      y: 82.3
    }, {
      x: 180.3,
      y: 73.6
    }, {
      x: 167.6,
      y: 74.1
    }, {
      x: 188,
      y: 85.9
    }, {
      x: 180.3,
      y: 73.2
    }, {
      x: 167.6,
      y: 76.3
    }, {
      x: 183,
      y: 65.9
    }, {
      x: 183,
      y: 90.9
    }, {
      x: 179.1,
      y: 89.1
    }, {
      x: 170.2,
      y: 62.3
    }, {
      x: 177.8,
      y: 82.7
    }, {
      x: 179.1,
      y: 79.1
    }, {
      x: 190.5,
      y: 98.2
    }, {
      x: 177.8,
      y: 84.1
    }, {
      x: 180.3,
      y: 83.2
    }, {
      x: 180.3,
      y: 83.2
    }]
  }, {
    name: 'female',
    data: [{
      x: 161.2,
      y: 51.6
    }, {
      x: 167.5,
      y: 59
    }, {
      x: 159.5,
      y: 49.2
    }, {
      x: 157,
      y: 63
    }, {
      x: 155.8,
      y: 53.6
    }, {
      x: 170,
      y: 59
    }, {
      x: 159.1,
      y: 47.6
    }, {
      x: 166,
      y: 69.8
    }, {
      x: 176.2,
      y: 66.8
    }, {
      x: 160.2,
      y: 75.2
    }, {
      x: 172.5,
      y: 55.2
    }, {
      x: 170.9,
      y: 54.2
    }, {
      x: 172.9,
      y: 62.5
    }, {
      x: 153.4,
      y: 42
    }, {
      x: 160,
      y: 50
    }, {
      x: 147.2,
      y: 49.8
    }, {
      x: 168.2,
      y: 49.2
    }, {
      x: 175,
      y: 73.2
    }, {
      x: 157,
      y: 47.8
    }, {
      x: 167.6,
      y: 68.8
    }, {
      x: 159.5,
      y: 50.6
    }, {
      x: 175,
      y: 82.5
    }, {
      x: 166.8,
      y: 57.2
    }, {
      x: 176.5,
      y: 87.8
    }, {
      x: 170.2,
      y: 72.8
    }, {
      x: 174,
      y: 54.5
    }, {
      x: 173,
      y: 59.8
    }, {
      x: 179.9,
      y: 67.3
    }, {
      x: 170.5,
      y: 67.8
    }, {
      x: 160,
      y: 47
    }, {
      x: 154.4,
      y: 46.2
    }, {
      x: 162,
      y: 55
    }, {
      x: 176.5,
      y: 83
    }, {
      x: 160,
      y: 54.4
    }, {
      x: 152,
      y: 45.8
    }, {
      x: 162.1,
      y: 53.6
    }, {
      x: 170,
      y: 73.2
    }, {
      x: 160.2,
      y: 52.1
    }, {
      x: 161.3,
      y: 67.9
    }, {
      x: 166.4,
      y: 56.6
    }, {
      x: 168.9,
      y: 62.3
    }, {
      x: 163.8,
      y: 58.5
    }, {
      x: 167.6,
      y: 54.5
    }, {
      x: 160,
      y: 50.2
    }, {
      x: 161.3,
      y: 60.3
    }, {
      x: 167.6,
      y: 58.3
    }, {
      x: 165.1,
      y: 56.2
    }, {
      x: 160,
      y: 50.2
    }, {
      x: 170,
      y: 72.9
    }, {
      x: 157.5,
      y: 59.8
    }, {
      x: 167.6,
      y: 61
    }, {
      x: 160.7,
      y: 69.1
    }, {
      x: 163.2,
      y: 55.9
    }, {
      x: 152.4,
      y: 46.5
    }, {
      x: 157.5,
      y: 54.3
    }, {
      x: 168.3,
      y: 54.8
    }, {
      x: 180.3,
      y: 60.7
    }, {
      x: 165.5,
      y: 60
    }, {
      x: 165,
      y: 62
    }, {
      x: 164.5,
      y: 60.3
    }, {
      x: 156,
      y: 52.7
    }, {
      x: 160,
      y: 74.3
    }, {
      x: 163,
      y: 62
    }, {
      x: 165.7,
      y: 73.1
    }, {
      x: 161,
      y: 80
    }, {
      x: 162,
      y: 54.7
    }, {
      x: 166,
      y: 53.2
    }, {
      x: 174,
      y: 75.7
    }, {
      x: 172.7,
      y: 61.1
    }, {
      x: 167.6,
      y: 55.7
    }, {
      x: 151.1,
      y: 48.7
    }, {
      x: 164.5,
      y: 52.3
    }, {
      x: 163.5,
      y: 50
    }, {
      x: 152,
      y: 59.3
    }, {
      x: 169,
      y: 62.5
    }, {
      x: 164,
      y: 55.7
    }, {
      x: 161.2,
      y: 54.8
    }, {
      x: 155,
      y: 45.9
    }, {
      x: 170,
      y: 70.6
    }, {
      x: 176.2,
      y: 67.2
    }, {
      x: 170,
      y: 69.4
    }, {
      x: 162.5,
      y: 58.2
    }, {
      x: 170.3,
      y: 64.8
    }, {
      x: 164.1,
      y: 71.6
    }, {
      x: 169.5,
      y: 52.8
    }, {
      x: 163.2,
      y: 59.8
    }, {
      x: 154.5,
      y: 49
    }, {
      x: 159.8,
      y: 50
    }, {
      x: 173.2,
      y: 69.2
    }, {
      x: 170,
      y: 55.9
    }, {
      x: 161.4,
      y: 63.4
    }, {
      x: 169,
      y: 58.2
    }, {
      x: 166.2,
      y: 58.6
    }, {
      x: 159.4,
      y: 45.7
    }, {
      x: 162.5,
      y: 52.2
    }, {
      x: 159,
      y: 48.6
    }, {
      x: 162.8,
      y: 57.8
    }, {
      x: 159,
      y: 55.6
    }, {
      x: 179.8,
      y: 66.8
    }, {
      x: 162.9,
      y: 59.4
    }, {
      x: 161,
      y: 53.6
    }, {
      x: 151.1,
      y: 73.2
    }, {
      x: 168.2,
      y: 53.4
    }, {
      x: 168.9,
      y: 69
    }, {
      x: 173.2,
      y: 58.4
    }, {
      x: 171.8,
      y: 56.2
    }, {
      x: 178,
      y: 70.6
    }, {
      x: 164.3,
      y: 59.8
    }, {
      x: 163,
      y: 72
    }, {
      x: 168.5,
      y: 65.2
    }, {
      x: 166.8,
      y: 56.6
    }, {
      x: 172.7,
      y: 105.2
    }, {
      x: 163.5,
      y: 51.8
    }, {
      x: 169.4,
      y: 63.4
    }, {
      x: 167.8,
      y: 59
    }, {
      x: 159.5,
      y: 47.6
    }, {
      x: 167.6,
      y: 63
    }, {
      x: 161.2,
      y: 55.2
    }, {
      x: 160,
      y: 45
    }, {
      x: 163.2,
      y: 54
    }, {
      x: 162.2,
      y: 50.2
    }, {
      x: 161.3,
      y: 60.2
    }, {
      x: 149.5,
      y: 44.8
    }, {
      x: 157.5,
      y: 58.8
    }, {
      x: 163.2,
      y: 56.4
    }, {
      x: 172.7,
      y: 62
    }, {
      x: 155,
      y: 49.2
    }, {
      x: 156.5,
      y: 67.2
    }, {
      x: 164,
      y: 53.8
    }, {
      x: 160.9,
      y: 54.4
    }, {
      x: 162.8,
      y: 58
    }, {
      x: 167,
      y: 59.8
    }, {
      x: 160,
      y: 54.8
    }, {
      x: 160,
      y: 43.2
    }, {
      x: 168.9,
      y: 60.5
    }, {
      x: 158.2,
      y: 46.4
    }, {
      x: 156,
      y: 64.4
    }, {
      x: 160,
      y: 48.8
    }, {
      x: 167.1,
      y: 62.2
    }, {
      x: 158,
      y: 55.5
    }, {
      x: 167.6,
      y: 57.8
    }, {
      x: 156,
      y: 54.6
    }, {
      x: 162.1,
      y: 59.2
    }, {
      x: 173.4,
      y: 52.7
    }, {
      x: 159.8,
      y: 53.2
    }, {
      x: 170.5,
      y: 64.5
    }, {
      x: 159.2,
      y: 51.8
    }, {
      x: 157.5,
      y: 56
    }, {
      x: 161.3,
      y: 63.6
    }, {
      x: 162.6,
      y: 63.2
    }, {
      x: 160,
      y: 59.5
    }, {
      x: 168.9,
      y: 56.8
    }, {
      x: 165.1,
      y: 64.1
    }, {
      x: 162.6,
      y: 50
    }, {
      x: 165.1,
      y: 72.3
    }, {
      x: 166.4,
      y: 55
    }, {
      x: 160,
      y: 55.9
    }, {
      x: 152.4,
      y: 60.4
    }, {
      x: 170.2,
      y: 69.1
    }, {
      x: 162.6,
      y: 84.5
    }, {
      x: 170.2,
      y: 55.9
    }, {
      x: 158.8,
      y: 55.5
    }, {
      x: 172.7,
      y: 69.5
    }, {
      x: 167.6,
      y: 76.4
    }, {
      x: 162.6,
      y: 61.4
    }, {
      x: 167.6,
      y: 65.9
    }, {
      x: 156.2,
      y: 58.6
    }, {
      x: 175.2,
      y: 66.8
    }, {
      x: 172.1,
      y: 56.6
    }, {
      x: 162.6,
      y: 58.6
    }, {
      x: 160,
      y: 55.9
    }, {
      x: 165.1,
      y: 59.1
    }, {
      x: 182.9,
      y: 81.8
    }, {
      x: 166.4,
      y: 70.7
    }, {
      x: 165.1,
      y: 56.8
    }, {
      x: 177.8,
      y: 60
    }, {
      x: 165.1,
      y: 58.2
    }, {
      x: 175.3,
      y: 72.7
    }, {
      x: 154.9,
      y: 54.1
    }, {
      x: 158.8,
      y: 49.1
    }, {
      x: 172.7,
      y: 75.9
    }, {
      x: 168.9,
      y: 55
    }, {
      x: 161.3,
      y: 57.3
    }, {
      x: 167.6,
      y: 55
    }, {
      x: 165.1,
      y: 65.5
    }, {
      x: 175.3,
      y: 65.5
    }, {
      x: 157.5,
      y: 48.6
    }, {
      x: 163.8,
      y: 58.6
    }, {
      x: 167.6,
      y: 63.6
    }, {
      x: 165.1,
      y: 55.2
    }, {
      x: 165.1,
      y: 62.7
    }, {
      x: 168.9,
      y: 56.6
    }, {
      x: 162.6,
      y: 53.9
    }, {
      x: 164.5,
      y: 63.2
    }, {
      x: 176.5,
      y: 73.6
    }, {
      x: 168.9,
      y: 62
    }, {
      x: 175.3,
      y: 63.6
    }, {
      x: 159.4,
      y: 53.2
    }, {
      x: 160,
      y: 53.4
    }, {
      x: 170.2,
      y: 55
    }, {
      x: 162.6,
      y: 70.5
    }, {
      x: 167.6,
      y: 54.5
    }, {
      x: 162.6,
      y: 54.5
    }, {
      x: 160.7,
      y: 55.9
    }, {
      x: 160,
      y: 59
    }, {
      x: 157.5,
      y: 63.6
    }, {
      x: 162.6,
      y: 54.5
    }, {
      x: 152.4,
      y: 47.3
    }, {
      x: 170.2,
      y: 67.7
    }, {
      x: 165.1,
      y: 80.9
    }, {
      x: 172.7,
      y: 70.5
    }, {
      x: 165.1,
      y: 60.9
    }, {
      x: 170.2,
      y: 63.6
    }, {
      x: 170.2,
      y: 54.5
    }, {
      x: 170.2,
      y: 59.1
    }, {
      x: 161.3,
      y: 70.5
    }, {
      x: 167.6,
      y: 52.7
    }, {
      x: 167.6,
      y: 62.7
    }, {
      x: 165.1,
      y: 86.3
    }, {
      x: 162.6,
      y: 66.4
    }, {
      x: 152.4,
      y: 67.3
    }, {
      x: 168.9,
      y: 63
    }, {
      x: 170.2,
      y: 73.6
    }, {
      x: 175.2,
      y: 62.3
    }, {
      x: 175.2,
      y: 57.7
    }, {
      x: 160,
      y: 55.4
    }, {
      x: 165.1,
      y: 104.1
    }, {
      x: 174,
      y: 55.5
    }, {
      x: 170.2,
      y: 77.3
    }, {
      x: 160,
      y: 80.5
    }, {
      x: 167.6,
      y: 64.5
    }, {
      x: 167.6,
      y: 72.3
    }, {
      x: 167.6,
      y: 61.4
    }, {
      x: 154.9,
      y: 58.2
    }, {
      x: 162.6,
      y: 81.8
    }, {
      x: 175.3,
      y: 63.6
    }, {
      x: 171.4,
      y: 53.4
    }, {
      x: 157.5,
      y: 54.5
    }, {
      x: 165.1,
      y: 53.6
    }, {
      x: 160,
      y: 60
    }, {
      x: 174,
      y: 73.6
    }, {
      x: 162.6,
      y: 61.4
    }, {
      x: 174,
      y: 55.5
    }, {
      x: 162.6,
      y: 63.6
    }, {
      x: 161.3,
      y: 60.9
    }, {
      x: 156.2,
      y: 60
    }, {
      x: 149.9,
      y: 46.8
    }, {
      x: 169.5,
      y: 57.3
    }, {
      x: 160,
      y: 64.1
    }, {
      x: 175.3,
      y: 63.6
    }, {
      x: 169.5,
      y: 67.3
    }, {
      x: 160,
      y: 75.5
    }, {
      x: 172.7,
      y: 68.2
    }, {
      x: 162.6,
      y: 61.4
    }, {
      x: 157.5,
      y: 76.8
    }, {
      x: 176.5,
      y: 71.8
    }, {
      x: 164.4,
      y: 55.5
    }, {
      x: 160.7,
      y: 48.6
    }, {
      x: 174,
      y: 66.4
    }, {
      x: 163.8,
      y: 67.3
    }]
  }]
};
var options = {
  chart: {
    width: scatterChartWidth,
    height: 380,
    title: 'Height vs Weight'
  },
  yAxis: {
    title: 'Weight (kg)'
  },
  xAxis: {
    title: 'Height (cm)'
  },
  tooltip: {
    template: function template(category, items) {
      return '<div class="tui-chart-default-tooltip">' + '<div class="tui-chart-tooltip-head">' + items.legend + '</div>' + '<table class="tui-chart-tooltip-body">' + '<tr>' + '<td>Weight</td>' + '<td class="tui-chart-tooltip-value">' + items.x + 'kg</td>' + '</tr>' + '<tr>' + '<td>Height</td>' + '<td class="tui-chart-tooltip-value">' + items.y + 'cm</td>' + '</tr>' + '</table>' + '</div>';
    }
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#34c38f', '#556ee6']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var scatterChart = tui.chart.scatterChart(container, data, options);
$(window).resize(function () {
  scatterChartWidth = $("#scatter-charts").width();
  scatterChart.resize({
    width: scatterChartWidth,
    height: 350
  });
}); // Pie charts

var pieChartWidth = $("#pie-charts").width();
var container = document.getElementById('pie-charts');
var data = {
  categories: ['Browser'],
  series: [{
    name: 'Chrome',
    data: 46.02
  }, {
    name: 'IE',
    data: 20.47
  }, {
    name: 'Firefox',
    data: 17.71
  }, {
    name: 'Safari',
    data: 5.45
  }, {
    name: 'Etc',
    data: 10.35
  }]
};
var options = {
  chart: {
    width: pieChartWidth,
    height: 380,
    title: 'Usage share of web browsers'
  },
  tooltip: {
    suffix: '%'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var pieChart = tui.chart.pieChart(container, data, options);
$(window).resize(function () {
  pieChartWidth = $("#pie-charts").width();
  pieChart.resize({
    width: pieChartWidth,
    height: 350
  });
}); // Donut pie chart

var donutpieChartWidth = $("#donut-charts").width();
var container = document.getElementById('donut-charts');
var data = {
  categories: ['Browser'],
  series: [{
    name: 'Chrome',
    data: 46.02
  }, {
    name: 'IE',
    data: 20.47
  }, {
    name: 'Firefox',
    data: 17.71
  }, {
    name: 'Safari',
    data: 5.45
  }, {
    name: 'Etc',
    data: 10.35
  }]
};
var options = {
  chart: {
    width: donutpieChartWidth,
    height: 380,
    title: 'Usage share of web browsers',
    format: function format(value, chartType, areaType, valuetype, legendName) {
      if (areaType === 'makingSeriesLabel') {
        // formatting at series area
        value = value + '%';
      }

      return value;
    }
  },
  series: {
    radiusRange: ['40%', '100%'],
    showLabel: true
  },
  tooltip: {
    suffix: '%'
  },
  legend: {
    align: 'bottom'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    series: {
      colors: ['#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c']
    },
    label: {
      color: '#fff',
      fontFamily: 'sans-serif'
    }
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var donutChart = tui.chart.pieChart(container, data, options);
$(window).resize(function () {
  donutpieChartWidth = $("#donut-charts").width();
  donutChart.resize({
    width: donutpieChartWidth,
    height: 350
  });
}); // Heatmap chart

var heatmapchartsWidth = $("#heatmap-charts").width();
var container = document.getElementById('heatmap-charts');
var data = {
  categories: {
    x: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    y: ['Seoul', 'Seattle', 'Sydney', 'Moskva', 'Jungfrau']
  },
  series: [[-3.5, -1.1, 4.0, 11.3, 17.5, 21.5, 24.9, 25.2, 20.4, 13.9, 6.6, -0.6], [3.8, 5.6, 7.0, 9.1, 12.4, 15.3, 17.5, 17.8, 15.0, 10.6, 6.4, 3.7], [22.1, 22.0, 20.9, 18.3, 15.2, 12.8, 11.8, 13.0, 15.2, 17.6, 19.4, 21.2], [-10.3, -9.1, -4.1, 4.4, 12.2, 16.3, 18.5, 16.7, 10.9, 4.2, -2.0, -7.5], [-13.2, -13.7, -13.1, -10.3, -6.1, -3.2, 0.0, -0.1, -1.8, -4.5, -9.0, -10.9]]
};
var options = {
  chart: {
    width: heatmapchartsWidth,
    height: 380,
    title: '24-hr Average Temperature'
  },
  yAxis: {
    title: 'City'
  },
  xAxis: {
    title: 'Month'
  },
  series: {
    showLabel: true
  },
  tooltip: {
    suffix: '°C'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    startColor: '#556ee6',
    endColor: '#34c38f',
    overColor: '#75b5aa',
    borderColor: '#F4511E'
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var heatmapChart = tui.chart.heatmapChart(container, data, options);
$(window).resize(function () {
  heatmapChartChartWidth = $("#heatmap-charts").width();
  heatmapChart.resize({
    width: heatmapChartChartWidth,
    height: 350
  });
}); // Treemap chart

var treemapchartsWidth = $("#treemap-charts").width();
var container = document.getElementById('treemap-charts');
var data = {
  series: [{
    label: 'Documents',
    children: [{
      label: 'docs',
      children: [{
        label: 'pages',
        value: 1.3
      }, {
        label: 'keynote',
        value: 2.5
      }, {
        label: 'numbers',
        value: 1.2
      }]
    }, {
      label: 'photos',
      value: 5.5
    }, {
      label: 'videos',
      value: 20.7
    }]
  }, {
    label: 'Downloads',
    children: [{
      label: 'recents',
      value: 5.3
    }, {
      label: '2015',
      value: 10.1
    }, {
      label: '2014',
      value: 8.2
    }]
  }, {
    label: 'Application',
    value: 16.4
  }, {
    label: 'Desktop',
    value: 4.5
  }]
};
var options = {
  chart: {
    width: treemapchartsWidth,
    height: 380,
    title: 'Used disk space'
  },
  series: {
    showLabel: true,
    zoomable: false,
    useLeafLabel: true
  },
  tooltip: {
    suffix: 'GB'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f', '#f1b44c', '#f46a6a'],
    borderColor: 'rgba(255, 255, 255, 0.4)',
    borderWidth: 4
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var treemapChart = tui.chart.treemapChart(container, data, options);
$(window).resize(function () {
  treemapChartChartWidth = $("#treemap-charts").width();
  treemapChart.resize({
    width: treemapChartChartWidth,
    height: 350
  });
}); // Map charts

var mapchartsWidth = $("#map-charts").width();
var container = document.getElementById('map-charts');
var data = {
  series: [{
    code: 'US-AK',
    data: -3.0
  }, {
    code: 'US-AL',
    data: 17.1
  }, {
    code: 'US-AZ',
    data: 15.7
  }, {
    code: 'US-CA',
    data: 15.2
  }, {
    code: 'US-CO',
    data: 7.3
  }, {
    code: 'US-CT',
    data: 9.4
  }, {
    code: 'US-DC',
    data: 12.3
  }, {
    code: 'US-DE',
    data: 12.9
  }, {
    code: 'US-FL',
    data: 21.5
  }, {
    code: 'US-GA',
    data: 17.5
  }, {
    code: 'US-HI',
    data: 21.1
  }, {
    code: 'US-IA',
    data: 8.8
  }, {
    code: 'US-ID',
    data: 6.9
  }, {
    code: 'US-IL',
    data: 11.0
  }, {
    code: 'US-IN',
    data: 10.9
  }, {
    code: 'US-KS',
    data: 12.4
  }, {
    code: 'US-KY',
    data: 13.1
  }, {
    code: 'US-LA',
    data: 19.1
  }, {
    code: 'US-MA',
    data: 8.8
  }, {
    code: 'US-MD',
    data: 12.3
  }, {
    code: 'US-ME',
    data: 5.0
  }, {
    code: 'US-MI',
    data: 6.9
  }, {
    code: 'US-MN',
    data: 5.1
  }, {
    code: 'US-MO',
    data: 12.5
  }, {
    code: 'US-MS',
    data: 17.4
  }, {
    code: 'US-NC',
    data: 15.0
  }, {
    code: 'US-ND',
    data: 4.7
  }, {
    code: 'US-NE',
    data: 9.3
  }, {
    code: 'US-NH',
    data: 6.6
  }, {
    code: 'US-NJ',
    data: 11.5
  }, {
    code: 'US-NM',
    data: 11.9
  }, {
    code: 'US-NV',
    data: 9.9
  }, {
    code: 'US-NY',
    data: 7.4
  }, {
    code: 'US-OH',
    data: 10.4
  }, {
    code: 'US-OK',
    data: 15.3
  }, {
    code: 'US-OR',
    data: 9.1
  }, {
    code: 'US-PA',
    data: 9.3
  }, {
    code: 'US-RI',
    data: 10.1
  }, {
    code: 'US-SC',
    data: 16.9
  }, {
    code: 'US-SD',
    data: 7.3
  }, {
    code: 'US-TN',
    data: 14.2
  }, {
    code: 'US-TX',
    data: 18.2
  }, {
    code: 'US-UT',
    data: 9.2
  }, {
    code: 'US-VA',
    data: 12.8
  }, {
    code: 'US-VT',
    data: 6.1
  }, {
    code: 'US-WA',
    data: 9.1
  }, {
    code: 'US-WI',
    data: 11.0
  }, {
    code: 'US-WV',
    data: 6.2
  }, {
    code: 'US-WY',
    data: 5.6
  }]
};
var options = {
  chart: {
    width: mapchartsWidth,
    height: 380,
    title: 'Average annual temperature of USA (°C)'
  },
  map: 'usa',
  legend: {
    align: 'right'
  },
  tooltip: {
    suffix: '°C'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    startColor: '#556ee6',
    endColor: '#34c38f',
    overColor: '#75b5aa',
    borderColor: '#F4511E'
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var mapChart = tui.chart.mapChart(container, data, options);
$(window).resize(function () {
  mapChartChartWidth = $("#map-charts").width();
  mapChart.resize({
    width: mapChartChartWidth,
    height: 350
  });
}); // Boxplot charts

var boxplotchartsWidth = $("#boxplot-charts").width();
var container = document.getElementById('boxplot-charts');
var data = {
  categories: ['Budget', 'Income', 'Expenses', 'Debt'],
  series: [{
    name: '2015',
    data: [[1000, 2500, 3714, 5500, 7000], [1000, 2750, 4571, 5250, 8000], [3000, 4000, 4714, 6000, 7000], [1000, 2250, 3142, 4750, 6000]],
    outliers: [[0, 14000], [2, 10000], [3, 9600]]
  }, {
    name: '2016',
    data: [[2000, 4500, 6714, 11500, 13000], [3000, 5750, 7571, 8250, 9000], [5000, 8000, 8714, 9000, 10000], [7000, 9250, 10142, 11750, 12000]],
    outliers: [[1, 14000]]
  }]
};
var options = {
  chart: {
    width: boxplotchartsWidth,
    height: 380,
    title: 'Monthly Revenue',
    format: '1,000'
  },
  yAxis: {
    title: 'Amount',
    min: 0,
    max: 15000
  },
  xAxis: {
    title: 'Month'
  },
  legend: {
    align: 'bottom'
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f']
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var boxplotChart = tui.chart.boxplotChart(container, data, options);
$(window).resize(function () {
  boxplotChartChartWidth = $("#boxplot-charts").width();
  boxplotChart.resize({
    width: boxplotChartChartWidth,
    height: 350
  });
}); // Bullet charts

var bulletchartsWidth = $("#bullet-charts").width();
var container = document.getElementById('bullet-charts');
var data = {
  categories: ['July', 'August'],
  series: [{
    name: 'Budget',
    data: 25,
    markers: [28, 2, 15],
    ranges: [[-1, 10], [10, 20], [20, 30]]
  }, {
    name: 'Hello',
    data: 11,
    markers: [20],
    ranges: [[0, 8], [8, 15]]
  }, {
    name: 'World',
    data: 30,
    markers: [25],
    ranges: [[0, 10], [10, 19], [19, 28]]
  }, {
    name: 'Income',
    data: 23,
    markers: [],
    ranges: [[19, 25], [13, 19], [0, 13]]
  }]
};
var options = {
  chart: {
    width: bulletchartsWidth,
    height: 380,
    title: 'Monthly Revenue',
    format: '1,000'
  },
  legend: {
    visible: true
  },
  xAxis: {
    max: 35
  },
  series: {
    showLabel: true,
    vertical: false
  }
};
var theme = {
  chart: {
    background: {
      color: '#fff',
      opacity: 0
    }
  },
  title: {
    color: '#8791af'
  },
  xAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  yAxis: {
    title: {
      color: '#8791af'
    },
    label: {
      color: '#8791af'
    },
    tickColor: '#8791af'
  },
  plot: {
    lineColor: 'rgba(166, 176, 207, 0.1)'
  },
  legend: {
    label: {
      color: '#8791af'
    }
  },
  series: {
    colors: ['#556ee6', '#34c38f', '#f1b44c', '#f46a6a'],
    ranges: [{
      color: '#eee',
      opacity: 0.7
    }, null, {
      color: '#556ee6'
    }]
  }
}; // For apply theme

tui.chart.registerTheme('myTheme', theme);
options.theme = 'myTheme';
var bulletChart = tui.chart.bulletChart(container, data, options);
$(window).resize(function () {
  bulletChartWidth = $("#bullet-charts").width();
  bulletChart.resize({
    width: bulletChartWidth,
    height: 350
  });
});
/******/ })()
;