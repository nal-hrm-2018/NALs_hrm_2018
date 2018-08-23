@extends('admin.template')
@section('content')

    {{--start code by Dung--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <style>
        .container-donut-chart {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            margin: 20px;
            padding: 20px 0px;
            background: white;
            box-shadow: 0 0 10px #cacaca;
            border-radius: 5px;
        }

        .child {
            padding-bottom: 40px;
        }

        .font-size-28 {
            font-size: 28px;
        }

        .font-size-20 {
            font-size: 20px;
        }

        .donut-chart {
            width: 250px;
            height: 250px;
        }

        .text-legend {
            display: inline-block;
            width: 150px;
            line-height: 2.0;
        }

        .highcharts-exporting-group {
            display: none;
        }

        .highcharts-credits {
            display:none;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if(Auth::user()->hasRole('HR'))
            <section class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Total employees</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="child">
                                        <div id="donut-chart1" class="donut-chart"></div>
                                    <div>
                                        <span class="text-legend">
                                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                            Official employee
                                        </span>
                                        <span class="text-legend">
                                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                                           Probationary
                                        </span><br>
                                        <span class="text-legend">
                                            <i class="fas fa-circle" style="color: #faa951;"></i>
                                            Training employee
                                        </span>
                                        <span class="text-legend">
                                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                                            Part-time employee
                                        </span>
                                    </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        {{--<div class="col-md-6">--}}
                            {{--<div class="box box-danger">--}}
                                {{--<div class="box-header with-border">--}}
                                    {{--<h3 class="box-title">Donut Chart</h3>--}}

                                    {{--<div class="box-tools pull-right">--}}
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>--}}
                                        {{--</button>--}}
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="box-body">--}}
                                    {{--<canvas id="pieChart" style="height: 267px; width: 534px;" width="534" height="267"></canvas>--}}
                                    {{--<div class="child">--}}
                                        {{--<span class="font-size-20"> New employee</span>--}}
                                        {{--<div id="donut-chart2" class="donut-chart"></div>--}}
                                        {{--<div>--}}
                                {{--<span class="text-legend">--}}
                                    {{--<i class="fas fa-circle" style="color: #53cbf2;"></i>--}}
                                    {{--5 PHP--}}
                                {{--</span>--}}
                                            {{--<span class="text-legend">--}}
                                    {{--<i class="fas fa-circle" style="color: #abe02a;"></i>--}}
                                   {{--8 Java--}}
                                {{--</span><br>--}}
                                            {{--<span class="text-legend">--}}
                                    {{--<i class="fas fa-circle" style="color: #e91d24;"></i>--}}
                                    {{--3 .NET--}}
                                {{--</span>--}}
                                            {{--<span class="text-legend">--}}
                                    {{--<i class="fas fa-circle" style="color: #faa951;"></i>--}}
                                    {{--4 Python--}}
                                {{--</span>--}}
                                            {{--<span class="text-legend">--}}
                                    {{--<i class="fas fa-circle" style="color: #333;"></i>--}}
                                   {{--10 Khac--}}
                                    {{--</span>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.box-body -->--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                </section>

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/data.js"></script>
            <script>
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
                            color:'#53cbf2'
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
                        }  ]
                    }]
                });
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
            </script>
        @endif
        {{--end code by Dung--}}

        @if(Auth::user()->hasRole('PO'))
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Project</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>PROJECT ID</th>
                                    <th>NAME</th>
                                    <th>START DATE</th>
                                    <th>ESTIMATE END DATE</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{$project->id}}</td>
                                        <td>{{$project['name']}}</td>
                                        <td>{{$project['start_date']->format('d-m-Y')}}</td>
                                        @if($project['estimate_end_date']!=null)
                                            <td>{{$project['estimate_end_date']->format('d-m-Y')}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if($project['status']['name']=='kick off')
                                            <td><span class="label label-primary">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='pending')
                                            <td><span class="label label-success">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='in-progress')
                                            <td><span class="label label-info">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='releasing')
                                            <td><span class="label label-warning">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='planning')
                                            <td><span class="label label-danger">{{$project['status']['name']}}</span></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                {{--<div class="box-footer clearfix">--}}
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Project</a>--}}
                {{--</div>--}}
                <!-- /.box-footer -->
                </div>
            </section>
            <section class="">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Processes</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>PROJECT ID</th>
                                    <th>NAME</th>
                                    <th>ROLE</th>
                                    <th>START DATE</th>
                                    <th>ESTIMATE END DATE</th>
                                    <th>STATUS</th>
                                    <th>MEMBER<br>
                                        <span class="label label-primary">PO</span>
                                        <span class="label label-success">Dev</span>
                                        <span class="label label-info">SM</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                ?>
                                @foreach($processes as $process)
                                    <tr>
                                        <td>{{$process['project_id']}}</td>
                                        <td>{{$process['project']['name']}}</td>
                                        @if($process['role']['name']=='Dev')
                                            <td><span class="label label-success">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='ACCOUNTANT')
                                            <td><span class="label label-danger">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='SM')
                                            <td><span class="label label-info">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='PO')
                                            <td><span class="label label-primary">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='HR')
                                            <td><span class="label label-warnings">{{$process['role']['name']}}</span></td>
                                        @endif
                                        <td>{{$process['project']['start_date']->format('d-m-Y')}}</td>
                                        @if($process['project']['estimate_end_date']!=null)
                                            <td>{{$process['project']['estimate_end_date']->format('d-m-Y')}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if($process['project']['status']['name']=='kick off')
                                            <td><span class="label label-primary">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='pending')
                                            <td><span class="label label-success">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='in-progress')
                                            <td><span class="label label-info">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='releasing')
                                            <td><span class="label label-warning">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='planning')
                                            <td><span class="label label-danger">{{$process['project']['status']['name']}}</span></td>
                                        @endif
                                        <td>
                                            @foreach($projects_emp[$i] as $member)
                                                @if($member->role->name =='Dev')
                                                    <span class="label label-success">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='ACCOUNTANT')
                                                    <span class="label label-danger">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='SM')
                                                    <span class="label label-info">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='PO')
                                                    <span class="label label-primary">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='HR')
                                                    <span class="label label-warning">{{$member->employee->name}}</span>
                                                @else
                                                    <span class="label label-default">{{$member->employee->name}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                {{--<div class="box-footer clearfix">--}}
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Processes</a>--}}
                {{--</div>--}}
                <!-- /.box-footer -->
                </div>
            </section>
        @endif
        {{--<!-- code from trinhhunganh -->--}}
        @if(Auth::user()->hasRole('Dev'))
            <section>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Project Developer</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
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
                                if(isset($idEmpPo->employee_id)){
                                    $name_po=\App\Models\Employee::find($idEmpPo->employee_id);
                                }
                            @endphp
                            <tr>
                                <td align="center">{{$key+1}}</td>
                                <td>{{$project->name}}</td>
                                <td>{{$objmEmployee->role->name}}</td>
                                <td><span class="">{{(isset($process->start_date))?$process->start_date->format('d-m-Y'):'-'}}</span></td>
                                <td><span class="">{{(isset($process->end_date))?$process->end_date->format('d-m-Y'):'-'}}</span></td>
                                <td><span class="">{{isset($name_po)?$name_po->name:'-'}}</span></td>
                                <td>
                                @if($status->name=='kick off')
                                    <span class="label label-primary">{{$status->name}}</span>
                                @elseif($status->name=='pending')
                                    <span class="label label-success">{{$status->name}}</span>
                                @elseif($status->name=='in-progress')
                                    <span class="label label-info">{{$status->name}}</span>
                                @elseif($status->name=='releasing')
                                    <span class="label label-warning">{{$status->name}}</span>
                                @elseif($status->name=='planning')
                                    <span class="label label-danger">{{$status->name}}</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </section>
        @endif <!-- endcode from trinhhunganh . -->
    </div>

@endsection
