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
    text: '<span style="font-size: 45px; font-weight: bold;">150</span><br><span style="font-size: 20px;">people</span>',
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
      name: 'Woman',
      y: 75,
      color:'#e91d24'
    }, {
      name: 'Man',
      y: 75,
      color:'#53cbf2',
    }]
  }]
});

Highcharts.chart('donut-chart2', {
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
    text: '<span style="font-size: 45px; font-weight: bold;">150</span><br><span style="font-size: 20px;">people</span>',
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
      name: '26 - 35',
      y: 61.41,
      color:'#e91d24'
    }, {
      name: '46 - More',
      y: 41.84,
      color:'#faa951'
    }, {
      name: '36 - 45',
      y: 50.85,
      color:'#abe02a'
    }, {
      name: '18 - 25',
      y: 24.67,
      color:'#53cbf2',
    }]
  }]
});

Highcharts.chart('donut-chart3', {
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
    text: '<span style="font-size: 45px; font-weight: bold;">100</span><br><span style="font-size: 20px;">PRO</span>',
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
      name: 'Dev',
      y: 25,
      color:'#e91d24'
    }, {
      name: 'Inter',
      y: 25,
      color:'#faa951'
    }, {
      name: 'Test',
      y: 25,
      color:'#abe02a'
    }, {
      name: 'PO',
      y: 25,
      color:'#53cbf2',
    }]
  }]
});

Highcharts.chart('donut-chart4', {
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
    text: '<span style="font-size: 45px; font-weight: bold;">150</span><br><span style="font-size: 20px;">people</span>',
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
      name: 'Dev',
      y: 40,
      color:'#e91d24'
    }, {
      name: 'Inter',
      y: 20,
      color:'#faa951'
    }, {
      name: 'Test',
      y: 30,
      color:'#abe02a'
    }, {
      name: 'PO',
      y: 10,
      color:'#53cbf2',
    }]
  }]
});

Highcharts.chart('donut-chart5', {
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
    text: '<span style="font-size: 45px; font-weight: bold;">150</span><br><span style="font-size: 20px;">people</span>',
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
      name: 'Dev',
      y: 40,
      color:'#e91d24'
    }, {
      name: 'Inter',
      y: 20,
      color:'#faa951'
    }, {
      name: 'Test',
      y: 30,
      color:'#abe02a'
    }, {
      name: 'PO',
      y: 10,
      color:'#53cbf2',
    }]
  }]
});

Highcharts.chart('container', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'New/Off member'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: ''
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' + '<b>' +
        this.point.name + '</b><br/>' + ' ' + this.point.y;
    }
  }
});

Highcharts.chart('container1', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Project member'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: ''
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' + '<b>' +
        this.point.name + '</b><br/>' + ' ' + this.point.y;
    }
  }
});

Highcharts.chart('container2', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Project on month'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: ''
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' + '<b>' +
        this.point.name + '</b><br/>' + ' ' + this.point.y;
    }
  }
});

Highcharts.chart('container3', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Pay'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: ''
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' + '<b>' +
        this.point.name + '</b><br/>' + ' ' + this.point.y;
    }
  }
});

Highcharts.chart('container4', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Requirement'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: ''
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' + '<b>' +
        this.point.name + '</b><br/>' + ' ' + this.point.y;
    }
  }
});
