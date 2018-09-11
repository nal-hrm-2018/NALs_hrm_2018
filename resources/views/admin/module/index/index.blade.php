@extends('admin.template')
@section('content')

    {{--start code by Dung--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <style>
        .style-box {
            margin: 10px;
            padding: 10px;
            border: 3px solid #d2d6de;
            border-radius: 5px;
            min-width: 250px;
            color: black;
            background: white;
        }
        .padding-20 {
            padding: 0px 20px;
        }
        .absence_head p{
            font-weight: bold;
            font-size: 15px;
        }
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
            margin: 0 auto;
            width: 250px;
            height: 250px;
        }

        .text-legend {
            display: inline-block;
            line-height: 2.0;
        }
        .width-100{
            width: 100px;
        }
        .width-150{
            margin: 0 auto;
            width: 150px;
        }
        .width-310{
            margin: 0 auto;
            width: 310px;
        }
        .height-350{
           height: 350px;
        }
        .none-margin-bottom{
            margin-bottom: 0 !important;
        }
        .highcharts-exporting-group {
            display: none;
        }

        .highcharts-credits {
            display:none;
        }

        .box-notification-red {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: red;
            color: #777;
        }

        .box-notification-yellow {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: #f39c12;
            color: #777;
        }

        .box-notification-green {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: green;
            color: #777;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <section>
                <div class="box box-info" >
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('common.notifications')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none; padding: 0px 40px;">
                                @foreach($notifications as $note)
                                    <li class="treeview" style="margin-bottom: 10px;">
                                        @foreach($notification_type as $type)
                                            @if($note->notification_type_id == $type->id)
                                                @if($type->name == 'HD')
                                                    <label class="label bg-red" style="width: 40px; display: inline-block;">HD</label>
                                                @endif
                                                @if($type->name == 'HR')
                                                    <label class="label bg-yellow" style="width: 40px; display: inline-block;">HR</label>
                                                @endif
                                                @if($type->name == 'DORAEMON')
                                                    <label class="label bg-green" style="width: 40px; display: inline-block;">DRM</label>
                                                @endif
                                            @endif
                                        @endforeach
                                        <a href="#">
                                            <span style="vertical-align: middle; color: black;">{{$note->title}}</span>
                                        </a>
                                        @foreach($notification_type as $type)
                                            @if($note->notification_type_id == $type->id)
                                                @if($type->name == 'HD')
                                                    <ul class="treeview-menu box-notification-red">
                                                        <div style="padding: 0px 20px;">
                                                            <?php
                                                            echo nl2br($note->content);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                @endif
                                                @if($type->name == 'HR')
                                                    <ul class="treeview-menu box-notification-yellow">
                                                        <div style="padding: 0px 20px;">
                                                            <?php
                                                            echo nl2br($note->content);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                @endif
                                                @if($type->name == 'DORAEMON')
                                                    <ul class="treeview-menu box-notification-green">
                                                        <div style="padding: 0px 20px;">
                                                            <?php
                                                            echo nl2br($note->content);
                                                            ?>
                                                        </div>
                                                    </ul>
                                                @endif
                                            @endif
                                        @endforeach
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('common.absences')}}</h3>
                    </div>
                    <div class="box-body">
                        <div>
                            <button type="button" class="btn btn-default">
                                <a href="{{route('absences.create')}}"><i class="glyphicon glyphicon-plus"></i>&nbsp;{{trans('absence.add')}}</a>
                            </button>
                        </div>
                        <div style="margin: 30px 0 0;">
                            <div class=" absence_head" style="display: flex; justify-content: space-evenly; flex-wrap: wrap; padding: 20px 0px;">
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày được nghỉ phép:
                                            <span id="soNgayDuocNghiPhep">{{$absences['soNgayDuocNghiPhep']}}</span>
                                        </p>
                                        <span class="padding-20">
                                            + Số ngày phép năm nay:
                                            <span id="soNgayNghiPhepCoDinh">{{$absences['soNgayNghiPhepCoDinh']}}</span>
                                        </span><br>
                                        <span class="padding-20">
                                            + Số ngày phép năm trước:
                                            <span id="soNgayPhepDu">{{$absences['soNgayPhepDu']}}</span>
                                        </span>
                                    </div><br />
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ không lương:
                                            <span id="soNgayNghiKhongLuong">{{$absences['soNgayNghiKhongLuong']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày đã nghỉ:
                                            <span id="soNgayDaNghi">{{$absences['soNgayDaNghi']}}</span>
                                        </p>
                                        <span class="padding-20">
                                            + Trừ vào phép năm nay:
                                            <span id="truVaoPhepCoDinh">{{$absences['truVaoPhepCoDinh']}}</span>
                                        </span><br>
                                        <span class="padding-20">
                                            + Trừ vào phép năm trước:
                                            <span id="truVaoPhepDu">{{$absences['truVaoPhepDu']}}</span>
                                        </span>

                                    </div><br/>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ trừ lương:
                                            <span id="soNgayNghiTruLuong">{{$absences['soNgayNghiTruLuong']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày còn lại:
                                            <span id="soNgayConLai">{{$absences['soNgayConLai']}}</span>
                                        </p>
                                        <span class="padding-20">
                                            + Số ngày phép năm nay:
                                            <span id="phepCoDinh">{{$absences['phepCoDinh']}}</span>
                                        </span>
                                        <span class="padding-20"><br>
                                            + Số ngày phép năm trước:
                                            <span id="phepDu">{{$absences['phepDu']}}</span>
                                        </span>
                                        <span id='hanphep'>
                                            @if($absences['checkMonth'] == 1 && $absences['phepDu'] > 0)
                                                Đã hết hạn
                                            @endif
                                        </span>
                                        @if($absences['checkMonth'] == 1 && $absences['phepDu'] > 0)
                                            <script type="text/javascript">
                                                $("#hanphep").addClass("label");
                                                $("#hanphep").addClass("label-danger");
                                            </script>
                                        @endif
                                    </div><br>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ chế độ bảo hiểm:
                                            <span id="soNgayNghiBaoHiem">{{$absences['soNgayNghiBaoHiem']}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{--<section>--}}
                {{--<div class="box box-info">--}}
                    {{--<div class="box-header with-border">--}}
                        {{--<h3 class="box-title">Overtime</h3>--}}
                    {{--</div>--}}
                    {{--<div class="box-body">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</section>--}}
        </div>

        <div class="content">
            @if(Auth::user()->hasRole('HR'))
                <section>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{trans('common.donut_chart')}}</h3>
                            {{--<div class="box-tools pull-right">--}}
                                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                        <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{trans('employee.type.type')}}</h3>
                                    <div class="box-tools pull-right">
                                        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button> -->
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    </div>
                                </div>
                                <div class="box-body height-350">
                                    <div class="child">
                                        <div id="donut-chart1" class="donut-chart"></div>
                                        <div class="width-310">
                                <span class="text-legend width-150">
                                    <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                    {{trans('employee.type.official')}}
                                </span>
                                            <span class="text-legend width-150">
                                    <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.type.probationary')}}
                                </span><br>
                                            <span class="text-legend width-150">
                                    <i class="fas fa-circle" style="color: #faa951;"></i>
                                                {{trans('employee.type.internship')}}
                                </span>
                                            <span class="text-legend width-150">
                                    <i class="fas fa-circle" style="color: #00a65a;"></i>
                                                {{trans('employee.type.part-time')}}
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-danger height-400">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{trans('employee.status.status')}}</h3>
                                    <div class="box-tools pull-right">
                                        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button> -->
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    </div>
                                </div>
                                <div class="box-body height-350">
                                    <div class="child">
                                        <div id="donut-chart2" class="donut-chart"></div>
                                        <div class="width-150">
                                    <span class="text-legend">
                                        <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                        {{trans('employee.status.active')}}
                                    </span><br>
                                            <span class="text-legend">
                                        <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.status.leaved')}}
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-danger height-400">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{trans('employee.new')}}{{trans('employee.this_month')}}</h3>
                                    <div class="box-tools pull-right">
                                        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button> -->
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    </div>
                                </div>
                                <div class="box-body height-350">
                                    <div class="child">
                                        <div id="donut-chart3" class="donut-chart"></div>
                                        <div  class="width-310">
                                            @if($new_PHP >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                        PHP
                                    </span>
                                            @endif
                                            @if($new_DOTNET >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #abe02a;"></i>
                                       DOTNET
                                    </span>
                                            @endif
                                            @if($new_iOS >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #00a65a;"></i>
                                        IOS
                                    </span>
                                            @endif
                                            @if($new_Android >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #faa951;"></i>
                                        Android
                                    </span>
                                            @endif
                                            @if($new_Tester >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #e91d24;"></i>
                                        Tester
                                    </span>
                                            @endif
                                            @if($new_others >0)
                                                <span class="text-legend width-100">
                                        <i class="fas fa-circle" style="color: #999;"></i>
                                       Others
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                        </div>
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
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
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
                                name: '{{trans('employee.type.official')}}',
                                y: {{$sumFullTime}},
                                color:'#53cbf2'
                            }, {
                                name: '{{trans('employee.type.probationary')}}',
                                y: {{$sumProbationary}},
                                color:'#abe02a'
                            }, {
                                name: '{{trans('employee.type.internship')}}',
                                y: {{$sumInternship}},
                                color:'#faa951'
                            }, {
                                name: ' {{trans('employee.type.part-time')}}',
                                y: {{$sumPartTime}},
                                color:'#00a65a',
                            }  ]
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
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
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
                                name: '{{trans('employee.status.active')}}',
                                y: {{$sum}}-{{$sum_leaved}},
                                color:'#53cbf2'
                            }, {
                                name: '{{trans('employee.status.leaved')}}',
                                y: {{$sum_leaved}},
                                color:'#abe02a'
                            }
                            ]
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
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum_new}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
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
                                name: 'PHP',
                                y: {{$new_PHP}},
                                color:'#53cbf2'
                            }, {
                                name: 'DOTNET',
                                y: {{$new_DOTNET}},
                                color:'#abe02a'
                            }, {
                                name: 'IOS',
                                y: {{$new_iOS}},
                                color:'#00a65a'
                            }, {
                                name: 'Android',
                                y: {{$new_Android}},
                                color:'#faa951',
                            }
                                , {
                                    name: 'Tester',
                                    y: {{$new_Tester}},
                                    color:'#e91d24',
                                }
                                , {
                                    name: 'Others',
                                    y: {{$new_others}},
                                    color:'#999'
                                }
                            ]
                        }]
                    });
                </script>
            @endif
            {{--end code by Dung--}}

            @if(Auth::user()->hasRole('PO'))
                    <section>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{trans('dashboard.project')}}</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{trans('dashboard.project_id')}}</th>
                                            <th>{{trans('dashboard.name.project')}}</th>
                                            <th>{{trans('dashboard.start_date')}}</th>
                                            <th>{{trans('dashboard.estimate_end_date')}}</th>
                                            <th>{{trans('dashboard.status')}}</th>
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
                                <h3 class="box-title">{{trans('dashboard.project_dev')}}</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="dtBasic" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{trans('dashboard.project_id')}}</th>
                                            <th>{{trans('dashboard.name.project')}}</th>
                                            <th>{{trans('dashboard.role')}}</th>
                                            <th>{{trans('dashboard.start_date')}}</th>
                                            <th>{{trans('dashboard.estimate_end_date')}}</th>
                                            <th>{{trans('dashboard.status')}}</th>
                                            <th>{{trans('dashboard.member')}}
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
                                                    <td>-</td>
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
                    <script>
                        $(document).ready(function () {
                            $('#dtBasicExample').DataTable();
                            $('.dataTables_length').addClass('bs-select');
                        });
                        $(document).ready(function () {
                            $('#dtBasic').DataTable();
                            $('.dataTables_length').addClass('bs-select');
                        });
                    </script>
                @endif
            {{--<!-- code from trinhhunganh -->--}}
                @if(Auth::user()->hasRole('Dev'))
                    <section>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{trans('dashboard.project_dev')}}</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="dtBasicPD" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="th-sm">{{trans('dashboard.stt')}}</th>
                                        <th class="th-sm">{{trans('dashboard.name.project')}}</th>
                                        <th class="th-sm">{{trans('dashboard.position')}}</th>
                                        <th class="th-sm">{{trans('dashboard.start_date')}}</th>
                                        <th class="th-sm">{{trans('dashboard.end_date')}}</th>
                                        <th class="th-sm">{{trans('dashboard.po_name')}}</th>
                                        <th class="th-sm">{{trans('dashboard.status')}}</th>
                                    </tr>
                                    </thead>
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
                                <script>
                                    $(document).ready(function () {
                                        $('#dtBasicPD').DataTable();
                                        $('.dataTables_length').addClass('bs-select');
                                    });
                                </script>
                            </div>
                        </div>
                    </section>
            @endif <!-- endcode from trinhhunganh . -->
        </div>
    </div>
@endsection
