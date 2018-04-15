<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NALs</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" type="text/css" href="{!! asset('admin/templates/css/contain/common-dashboard.css') !!}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	@include('admin.module.templates.header')
	@include('admin.module.templates.left_bar')
	@yield('content')
	@include('admin.module.templates.footer')
  <div class="control-sidebar-bg"></div>
</div>

<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{!! asset('admin/templates/js/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<!-- ChartJS -->
<script src="{!! asset('admin/templates/js/bower_components/chart.js/Chart.js') !!}"></script>
<!-- FastClick -->
<script src="{!! asset('admin/templates/js/bower_components/fastclick/lib/fastclick.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('admin/templates/js/dist/js/adminlte.min.js') !!}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! asset('admin/templates/js/dist/js/demo.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/Flot/jquery.flot.js') !!}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{!! asset('admin/templates/js/bower_components/Flot/jquery.flot.resize.js') !!}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{!! asset('admin/templates/js/bower_components/Flot/jquery.flot.pie.js') !!}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{!! asset('admin/templates/js/bower_components/Flot/jquery.flot.categories.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/jquery-knob/js/jquery.knob.js') !!}"></script>
<!-- Sparkline -->
<script src="{!! asset('admin/templates/js/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') !!}"></script>
<!-- Morris.js charts -->
<script src="{!! asset('admin/templates/js/bower_components/raphael/raphael.min.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/morris.js/morris.min.js') !!}"></script>

<script src="{!! asset('admin/templates/js/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>