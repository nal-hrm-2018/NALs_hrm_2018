
Highcharts.chart('donut-chart1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: null
    },
    subtitle: {
        text: '<span style="font-size: 45px; font-weight: bold;">{{$sum}}</span><br><span style="font-size: 20px;">people</span>',
        align: 'center',
        verticalAlign: 'middle'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            innerSize: 150,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    },
    series: [{
        name: 'Values',
        colorByPoint: true,
        data: [{
            name: 'Full-time',
            y: {{$sumFullTime}},
            color:'#53cbf2',
            }, {
                name: 'Probationary',
                    y: {{$sumProbationary}},
                color:'#abe02a'
            }, {
                name: 'Internship',
                    y: {{$sumInternship}},
                color:'#faa951'
            }, {
                name: 'Part-time',
                    y: {{$sumPartTime}},
                color:'#e91d24',
            }]
    }]
}

// Highcharts.chart('donut-chart2', {
//     chart: {
//         plotBackgroundColor: null,
//         plotBorderWidth: null,
//         plotShadow: false,
//         type: 'pie'
//     },
//     title: {
//         text: null
//     },
//     subtitle: {
//         text: '<span style="font-size: 45px; font-weight: bold;">30</span><br><span style="font-size: 20px;">people</span>',
//         align: 'center',
//         verticalAlign: 'middle'
//     },
//     tooltip: {
//         pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//     },
//     plotOptions: {
//         pie: {
//             innerSize: 150,
//             allowPointSelect: true,
//             cursor: 'pointer',
//             dataLabels: {
//                 enabled: false
//             },
//             showInLegend: false
//         }
//     },
//     series: [{
//         name: 'Values',
//         colorByPoint: true,
//         data: [{
//             name: 'php',
//             y: 5,
//             color:'#53cbf2'
//         }, {
//             name: 'Java',
//             y: 8,
//             color:'#abe02a'
//         }, {
//             name: '. NET',
//             y: 3,
//             color:'#faa951'
//         }, {
//             name: 'Python',
//             y: 4,
//             color:'#e91d24',
//         }
//             , {
//                 name: 'Khac',
//                 y: 10,
//                 color:'#333'
//             }
//         ]
//     }]
// });
