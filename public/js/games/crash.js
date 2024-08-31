$(document).ready(function() {
    // initial data
    let countY = [0, 2];
    let countX = [0, 2];

    // updated data
    let updatedCountY = [0];
    let updatedCountX = [0];

    myChart = runGraph(countY, countX);
    function runGraph(labels, datasets) {
        let ctx = document.getElementById("crashChart").getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    borderColor: '#3b7ae6',
                    borderWidth: 3,
                    pointRadius: 0,
                    fill: true,
                    backgroundColor: "rgba(15,197,177,0.65)",
                    data: datasets,
                }],
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                interaction: {
                    intersect: true
                },
                scales: {
                    y: {
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.5)',
                            font: {
                                size: 12,
                                family: 'Gotham Pro',
                                weight: 600
                            },
                            beginAtZero: true,
                            padding: 15,
                            maxTicksLimit: 5,
                            callback: function (value) {
                                return value.toFixed(2) + 'x'
                            }
                        },
                        grid: {
                            drawTicks: false,
                            display: true,
                            zeroLineColor: 'transparent',
                            borderDash: [3, 6],
                            color: 'rgba(255,255,255,0.15)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            zeroLineColor: 'transparent',
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: 'transparent',
                            fontFamily: 'Gilroy',
                            fontStyle: 'bold',
                            fontSize: 0,
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false
                    },
                },
                elements: {
                    line: {
                        tension: 0
                    }
                },
                animation: {
                    duration: 0,
                },
            }
        });
        return myChart;
    }

    //startGame();

    function startGame() {
        var x = 1;
        setInterval(() => {
            x++
            updatedCountX.splice(-1, 1);
            updatedCountY.splice(-1, 1);
            updatedCountX.push(x)
            updatedCountY.push(x)
            console.log(updatedCountX)
            myChart.data.datasets[0].data.push(x);
            myChart.data.labels.push(x);
            myChart.update()
        }, 1000);
        $('.crash__canvas').addClass('crash__canvas--started');
    }

});