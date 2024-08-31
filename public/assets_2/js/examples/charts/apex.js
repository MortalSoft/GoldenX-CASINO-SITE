'use strict';
$(document).ready(function () {

    apex_chart_one();

    apex_chart_two();

    apex_chart_three();

    apex_chart_four();

    apex_chart_five();

    apex_chart_six();

    apex_chart_seven();

    apex_chart_eight();

    apex_chart_nine();

    function apex_chart_one() {
        var lastDate = 0;
        var data = []
        var TICKINTERVAL = 86400000
        let XAXISRANGE = 777600000

        function getDayWiseTimeSeries(baseval, count, yrange) {
            var i = 0;
            while (i < count) {
                var x = baseval;
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                data.push({
                    x, y
                });
                lastDate = baseval
                baseval += TICKINTERVAL;
                i++;
            }
        }

        getDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 10, {
            min: 10,
            max: 90
        });

        function getNewSeries(baseval, yrange) {
            var newDate = baseval + TICKINTERVAL;
            lastDate = newDate;

            for (var i = 0; i < data.length - 10; i++) {
                // IMPORTANT
                // we reset the x and y of the data which is out of drawing area
                // to prevent memory leaks
                data[i].x = newDate - XAXISRANGE - TICKINTERVAL
                data[i].y = 0
            }

            data.push({
                x: newDate,
                y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
            })

        }

        var options = {
            chart: {
                height: 350,
                type: 'line',
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            series: [{
                data: data
            }],
            title: {
                text: 'Dynamic Updating Chart',
                align: 'left'
            },
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime',
                range: XAXISRANGE,
            },
            yaxis: {
                max: 100
            },
            legend: {
                show: false
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_one"),
            options
        );

        chart.render();

        window.setInterval(function () {
            getNewSeries(lastDate, {
                min: 10,
                max: 90
            })
            chart.updateSeries([{
                data: data
            }])
        }, 1000)
    }

    function apex_chart_two() {
        var ts2 = 1484418600000;
        var dates = [];
        var spikes = [5, -5, 3, -3, 8, -8]
        for (var i = 0; i < 120; i++) {
            ts2 = ts2 + 86400000;
            var innerArr = [ts2, dataSeries[1][i].value];
            dates.push(innerArr)
        }

        var options = {
            chart: {
                type: 'area',
                stacked: false,
                height: 350,
                zoom: {
                    type: 'x',
                    enabled: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'XYZ MOTORS',
                data: dates
            }],
            markers: {
                size: 0,
            },
            title: {
                text: 'Stock Price Movement',
                align: 'left'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0,
                    stops: [0, 90, 100]
                },
            },
            yaxis: {
                min: 20000000,
                max: 250000000,
                labels: {
                    formatter: function (val) {
                        return (val / 1000000).toFixed(0);
                    },
                },
                title: {
                    text: 'Price'
                },
            },
            xaxis: {
                type: 'datetime',
            },

            tooltip: {
                shared: false,
                y: {
                    formatter: function (val) {
                        return (val / 1000000).toFixed(0)
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_two"),
            options
        );

        chart.render();
    }

    function apex_chart_three() {
        var options = {
            chart: {
                height: 350,
                type: 'area',
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            series: [{
                name: 'series1',
                data: [31, 40, 28, 51, 42, 109, 100]
            }, {
                name: 'series2',
                data: [11, 32, 45, 32, 34, 52, 41]
            }],

            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_three"),
            options
        );

        chart.render();
    }

    function apex_chart_four() {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
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
                name: 'Net Profit',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Revenue',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }, {
                name: 'Free Cash Flow',
                data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
            }],
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_four"),
            options
        );

        chart.render();
    }

    function apex_chart_five() {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                stacked: true,
                stackType: '100%'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            series: [{
                name: 'PRODUCT A',
                data: [44, 55, 41, 67, 22, 43, 21, 49]
            },{
                name: 'PRODUCT B',
                data: [13, 23, 20, 8, 13, 27, 33, 12]
            },{
                name: 'PRODUCT C',
                data: [11, 17, 15, 15, 21, 14, 15, 13]
            }],
            xaxis: {
                categories: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4'],
            },
            fill: {
                opacity: 1
            },

            legend: {
                position: 'right',
                offsetX: 0,
                offsetY: 50
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_five"),
            options
        );

        chart.render();
    }

    function apex_chart_six() {
        var options = {
            chart: {
                height: 380,
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function(val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0,
                dropShadow: {
                    enabled: true
                }
            },
            series: [{
                data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
            }],
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'India'],
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Custom DataLabels',
                align: 'center',
                floating: true
            },
            subtitle: {
                text: 'Category Names as DataLabels inside bars',
                align: 'center',
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function() {
                            return ''
                        }
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_six"),
            options
        );

        chart.render();
    }

    function apex_chart_seven() {
        var options = {
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            series: [44, 55, 13, 43, 22],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_seven"),
            options
        );

        chart.render();
    }

    function apex_chart_eight() {
        function generateData(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

                series.push([x, y, z]);
                baseval += 86400000;
                i++;
            }
            return series;
        }


        var options = {
            chart: {
                height: 350,
                type: 'bubble',
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Bubble1',
                data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                    min: 10,
                    max: 60
                })
            },
                {
                    name: 'Bubble2',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                },
                {
                    name: 'Bubble3',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                },
                {
                    name: 'Bubble4',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                }
            ],
            fill: {
                opacity: 0.8
            },
            title: {
                text: 'Simple Bubble Chart'
            },
            xaxis: {
                tickAmount: 12,
                type: 'category',
            },
            yaxis: {
                max: 70
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_eight"),
            options
        );

        chart.render();
    }

    function apex_chart_nine() {
        var options = {
            chart: {
                height: 350,
                type: 'radar',
                dropShadow: {
                    enabled: true,
                    blur: 1,
                    left: 1,
                    top: 1
                }
            },
            series: [{
                name: 'Series 1',
                data: [80, 50, 30, 40, 100, 20],
            }, {
                name: 'Series 2',
                data: [20, 30, 40, 80, 20, 80],
            }, {
                name: 'Series 3',
                data: [44, 76, 78, 13, 43, 10],
            }],
            title: {
                text: 'Radar Chart - Multi Series'
            },
            stroke: {
                width: 0
            },
            fill: {
                opacity: 0.4
            },
            markers: {
                size: 0
            },
            labels: ['2011', '2012', '2013', '2014', '2015', '2016']
        }

        var chart = new ApexCharts(
            document.querySelector("#apex_chart_nine"),
            options
        );

        chart.render();

        function update() {

            function randomSeries() {
                var arr = []
                for(var i = 0; i < 6; i++) {
                    arr.push(Math.floor(Math.random() * 100))
                }

                return arr
            }


            chart.updateSeries([{
                name: 'Series 1',
                data: randomSeries(),
            }, {
                name: 'Series 2',
                data: randomSeries(),
            }, {
                name: 'Series 3',
                data: randomSeries(),
            }])
        }
    }

});