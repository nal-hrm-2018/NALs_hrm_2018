<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NALs</title>
    <meta content="{!! asset('admin/templates/js/multi-language/')!!}" name="link_origin_multi_language">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" type="text/css" href="{!! asset('admin/templates/css/contain/common-dashboard.css') !!}">

    <!-- add frontend -->
    <link rel="stylesheet" type="text/css" href="{!! asset('admin/templates/css/contain/dashboard.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('admin/templates/css/contain/reset.css') !!}">
    <!-- end add fontend -->

    <!-- Google Font -->
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">--}}
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.module.templates.newheader')
    @include('admin.module.templates.newleft_bar')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ibackbutton = document.getElementById("backbuttonstate");
            var html = "";
            if (ibackbutton.value == "0") {
                // Page has been loaded for the first time - Set marker
                <?php
                if (Session::has('msg_success')) {
                    echo 'html =' . '"<div > <ul class=\"result_msg\"> <li>' . Session::get("msg_success") . '</li></ul> </div>";';
                }
                ?>
                <?php
                if (Session::has('msg_fail')) {
                    echo 'html =' . '"<div > <ul class=\"error_msg\"> <li>' . Session::get("msg_fail") . '</li></ul> </div>";';
                }
                ?>
                $('#msg').html(html);
                ibackbutton.value = "1";

            } else {
                // Back button has been fired.. Do Something different..
            }
        }, false);
    </script>
    <input style="display:none;" type="text" id="backbuttonstate" value="0"/>
   @yield('content')
    @include('admin.module.templates.newfooter')
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
<script src="{!! asset('admin/templates/js/bower_components/Flot/jquery.flot.tooltip.min.js') !!}"></script>
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

<script src="{!! asset('admin/templates/js/bower_components/select2/dist/js/select2.full.min.js') !!}"></script>
<!-- InputMask -->
<script src="{!! asset('admin/templates/js/plugins/input-mask/jquery.inputmask.js') !!}"></script>
<script src="{!! asset('admin/templates/js/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}"></script>
<script src="{!! asset('admin/templates/js/plugins/input-mask/jquery.inputmask.extensions.js') !!}"></script>
<!-- date-range-picker -->
<script src="{!! asset('admin/templates/js/bower_components/moment/min/moment.min.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/bootstrap-daterangepicker/daterangepicker.js') !!}"></script>
<!-- bootstrap datepicker -->
<script src="{!! asset('admin/templates/js/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}"></script>
<!-- bootstrap color picker -->
<script src="{!! asset('admin/templates/js/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') !!}"></script>
<!-- bootstrap time picker -->
<script src="{!! asset('admin/templates/js/plugins/timepicker/bootstrap-timepicker.min.js') !!}"></script>
<!-- bootstrap datetimepicker -->
<script src="{!! asset('admin/templates/js/bower_components/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.min.js') !!}"></script>
<script src="{!! asset('admin/templates/js/bower_components/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.js') !!}"></script>
<!-- SlimScroll -->
<script src="{!! asset('admin/templates/js/plugins/iCheck/icheck.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin/templates/js/my_script/myscript.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin/templates/js/my_script/project.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin/templates/js/my_script/absence.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin/templates/js/common/commonJs.js') !!}"></script>
<script src="{!! asset('admin/templates/js/go_to_top/go_to_top.js') !!}"></script>
<script src="{!! asset('admin/templates/js/back_button/back_button.js') !!}"></script>
<script src="{!! asset('admin/templates/js/my_script/message_confirm.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin/templates/js/multi-language/lang.js') !!}"> </script>
<script type="text/javascript" src="{!! asset('admin/templates/js/multi-language/en/project.js') !!}"> </script>
<script type="text/javascript" src="{!! asset('admin/templates/js/multi-language/vn/project.js') !!}"> </script>
<script type="text/javascript" src="{!! asset('admin/templates/js/multi-language/en/absence.js') !!}"> </script>
 <!-- add fontend -->
    <script type="text/javascript" src="{!! asset('admin/templates/js/my_script/dashboard.js') !!}"> </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <!--  -->
<script>
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false
        })
    })
</script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'})
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>
<script src="./dashboard.js"></script>
</body>
</html>