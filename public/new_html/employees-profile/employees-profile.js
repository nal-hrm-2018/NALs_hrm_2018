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
