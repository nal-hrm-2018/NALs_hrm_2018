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

$(document).ready(function(){
            $(".btn-edit-password").click(function() {
                var form = $(this).closest('.form-edit-password');
                $('#myModal')
                    .modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    .one('click', '.btn-edit-password-confirm', function() {
                        form.submit();
                    })
            }); 
        });
