@extends('admin.template')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
         <section>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-bar-chart-o"></i>

                    <h3 class="box-title">Donut Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <div id="donut-chart-1" style="height: 150px;"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <div id="donut-chart-2" style="height: 150px;"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <div id="donut-chart-3" style="height: 150px;"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <div id="donut-chart-4" style="height: 150px;"></div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <div id="donut-chart-5" style="height: 150px;"></div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->

        <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <!-- code from trinhhunganh -->
        @if(Auth::user()->hasRole('Dev'))
            <section>
            <div class="row">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Project Developer</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 10px">{{trans('dashboard.stt')}}</th>
                                    <th>{{trans('dashboard.name.project')}}</th>
                                    <th>{{trans('dashboard.position')}}</th>
                                    <th>{{trans('dashboard.start_date')}}</th>
                                    <th>{{trans('dashboard.end_date')}}</th>
                                    <th>{{trans('dashboard.po_name')}}</th>
                                    <th>{{trans('dashboard.status')}}</th>
                                </tr>
                                @foreach($objmEmployee->processes as $key => $process)
                                    @php
                                        $idPO=\App\Models\Role::where('name','PO')->first();
                                        $project=\App\Models\Project::find($process->project_id);
                                        $status=\App\Models\Status::find($project->status)->first();
                                        $idEmpPo=\App\Models\Process::select('employee_id')
                                                                    ->where('project_id',$process->project_id)
                                                                    ->where('role_id',$idPO->id)
                                                                    ->first();
                                        $name_po=\App\Models\Employee::find($idEmpPo->employee_id);
                                    @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$project->name}}</td>
                                        <td>{{$objmEmployee->role->name}}</td>
                                        <td><span class="badge bg-red">{{$process->start_date}}</span></td>
                                        <td><span class="badge bg-yellow">{{$process->end_date}}</span></td>
                                        <td><span class="badge bg-light-blue">{{$name_po->name}}</span></td>
                                        <td><span class="badge bg-green">{{$status->name}}</span></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
            </div>
        </section>
        @endif <!-- endcode from trinhhunganh . -->
       <section>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                   
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gender Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Resource Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="bar-chart" style="height: 235px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
         <section>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Project Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart-project" style="height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Cost Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart-cost" style="height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      <section>
            <div class="row"  style="text-align: center;">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Recruitment Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="bar-chart-recruitment" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script type="text/javascript">
        $(function () {
            var donutData = [
                { label: 'Series2', data: 30, color: '#3c8dbc' },
                { label: 'Series3', data: 20, color: '#0073b7' },
                { label: 'Series4', data: 50, color: '#00c0ef' }
            ]
            $.plot('#donut-chart-1', donutData, {
                series: {
                    pie: {
                        show       : true,
                        radius     : 1,
                        innerRadius: 0,
                        label      : {
                            show     : true,
                            radius   : 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            })
            $.plot('#donut-chart-2', donutData, {
                series: {
                    pie: {
                        show       : true,
                        radius     : 1,
                        innerRadius: 0,
                        label      : {
                            show     : true,
                            radius   : 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            })
            $.plot('#donut-chart-3', donutData, {
                series: {
                    pie: {
                        show       : true,
                        radius     : 1,
                        innerRadius: 0,
                        label      : {
                            show     : true,
                            radius   : 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            })
            $.plot('#donut-chart-4', donutData, {
                series: {
                    pie: {
                        show       : true,
                        radius     : 1,
                        innerRadius: 0,
                        label      : {
                            show     : true,
                            radius   : 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            })
            $.plot('#donut-chart-5', donutData, {
                series: {
                    pie: {
                        show       : true,
                        radius     : 1,
                        innerRadius: 0,
                        label      : {
                            show     : true,
                            radius   : 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            })
            /*
               * project CHART
               * ---------
               */
            var bar_data = {
                data : [['Jan', 10], ['Feb', 8], ['Mar', 4], ['Apr', 13], ['May', 17], ['Jun', 9], ['Aug', 9], ['Sept', 2], ['Oct', 4], ['Nov', 5], ['Dec', 9]],
                color: '#3c8dbc'
            }
            $.plot('#bar-chart', [bar_data], {
                grid  : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor  : '#f3f3f3'
                },
                series: {
                    bars: {
                        show    : true,
                        barWidth: 0.5,
                        align   : 'center'
                    }
                },
                xaxis : {
                    mode      : 'categories',
                    tickLength: 0
                }
            })
            /* END project CHART */
            /*
            * recruitment CHART
            * ---------
            */
            var bar_data = {
                data : [['Jan', 10], ['Feb', 8], ['Mar', 4], ['Apr', 13], ['May', 17], ['Jun', 9], ['Aug', 9], ['Sept', 2], ['Oct', 4], ['Nov', 5], ['Dec', 9]],
                color: '#3c8dbc'
            }
            $.plot('#bar-chart-recruitment', [bar_data], {
                grid  : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor  : '#f3f3f3'
                },
                series: {
                    bars: {
                        show    : true,
                        barWidth: 0.5,
                        align   : 'center'
                    }
                },
                xaxis : {
                    mode      : 'categories',
                    tickLength: 0
                }
            })
            /* END project CHART */
        })

        function labelFormatter(label, series) {
            return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + '<br>'
                + Math.round(series.percent) + '%</div>'
        }
        /*chart bar*/
        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */


            var areaChartData = {
                labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sept','Oct','Nov','Dec'],
                datasets: [
                    {
                        label               : 'Electronics',
                        fillColor           : 'rgba(210, 214, 222, 1)',
                        strokeColor         : 'rgba(210, 214, 222, 1)',
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [65, 59, 80, 81, 56, 55, 40,10,50,70,20,40]
                    },
                    {
                        label               : 'Digital Goods',
                        fillColor           : 'rgba(60,141,188,0.9)',
                        strokeColor         : 'rgba(60,141,188,0.8)',
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [28, 48, 40, 19, 86, 27, 90,80, 81, 56, 55, 20]
                    }
                ]
            }

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale               : true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines      : false,
                //String - Colour of the grid lines
                scaleGridLineColor      : 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth      : 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines  : true,
                //Boolean - Whether the line is curved between points
                bezierCurve             : true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension      : 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot                : false,
                //Number - Radius of each point dot in pixels
                pointDotRadius          : 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth     : 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius : 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke           : true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth      : 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill             : true,
                //String - A legend template
                legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }
    //-------------
    //- SEX CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)

    //-------------
    //- project CHART -
    //-------------


    var barChartCanvas                   = $('#barChart-project').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
    //-------------
    //- cost CHART -
    //-------------


    var barChartCanvas                   = $('#barChart-cost').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })

</script>
<!-- Bootstrap 3.3.7 -->
@endsection
