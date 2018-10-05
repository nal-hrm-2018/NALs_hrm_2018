@extends('admin.template')
@section('content')

    {{--start code by Dung--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <style>
        .style-box {
            margin: 10px 0;
            padding: 10px;
            border: 3px solid #00c0ef;
            border-radius: 5px;
            min-width: 150px;
            color: black;
            background: white;
        }
        .style-box-2 {
            margin: 5px 0;
            padding: 5px;
            border: 3px solid #00c0ef;
            border-radius: 5px;
            /*min-width: 100px;*/
            color: black;
            background: white;
        }
        .padding-20 {
            padding: 0px 20px;
        }
        .style-box p{
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 15px;
        }
        .style-box-2 p{
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 12px;
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
            /*display: inline-block;*/
            font-size: 16px;
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
        .height-part{
           height: 250px;
        }
        .padding-0-20{
           padding: 0 20px;
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

        .read-more-state {
        display: none;
        }

        .read-more-target {
        opacity: 0;
        max-height: 0;
        font-size: 0;
        transition: .25s ease;
        }

        .read-more-wrap{
                        display: inline-block;
                        }

        .read-more-state:checked ~ .read-more-wrap .read-more-target {
        opacity: 1;
        font-size: inherit;
        max-height: 999em;
        }

        .read-more-state ~ .read-more-trigger:before {
        content: '>>>';
        }

        .read-more-state:checked ~ .read-more-trigger:before {
        content: '<<<';
        }

        .read-more-trigger {
        cursor: pointer;
        display: inline-block;
        padding: 0 .5em;
        color: #666;
        font-size: .9em;
        line-height: 2;
        border: 1px solid #ddd;
        border-radius: .25em;
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
                                @if($notifications->count()<=0)
                                {{trans('notification.no_notification')}}
                                @endif
                                @foreach($notifications as $note)
                                    <li class="treeview" style="display: table; width: 100%; margin-bottom: 10px;"><div class="col-xs-12 col-md-11">
                                        <label class="label bg-yellow" style="width: 40px; display: inline-block;">NALs</label>
                                        <label>
                                            <span style="color: black; ">[{{date('d/m',strtotime($note->create_at))}}]</span>
                                            <span style="vertical-align: middle; color: black;">{{$note->title}}</span>
                                        </label>
                                        <div class="span4 collapse-group">
                                                <div class="span4 collapse-group">
                                                    @if (strlen($note->content) > 50)
                                                    <input type="checkbox" class="read-more-state" id="post-{{$note->id}}" />
                                                        @if(strpos($note->content, ' ', 50))
                                                        <p class="read-more-wrap">{{substr($note->content,0,strpos($note->content, ' ', 50))}}<span class="read-more-target">{{substr($note->content,strpos($note->content, ' ', 50))}}</span></p>                                                
                                                        @else
                                                        <p class="read-more-wrap">{{substr($note->content,0,50)}}<span class="read-more-target">{{substr($note->content, 50)}}</span></p>                                                
                                                        @endif
                                                        <label for="post-{{$note->id}}" class="read-more-trigger"></label>
                                                    @else   
                                                    <p>{{$note->content}}</p>
                                                    @endif
                                                </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-md-5">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{trans('leftbar.nav.overtime')}}</h3>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button type="button" class="btn btn-default">
                                        <a href="{{route('ot.create')}}"><i class="glyphicon glyphicon-plus"></i>&nbsp;{{trans('leftbar.nav.add.overtime')}}</a>
                                    </button>
                                </div>
                                <div>
                                    <div class=" absence_head" style="padding: 20px 0px;">
                                        <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">                                           
                                            <div class="style-box">
                                                <p style="font-size: 18; font-weight: bold;">{{trans('overtime.total_hours')}}</p>
                                                <p style="font-size: 30; font-weight: bold;">{{$overtime['total_time']}}</p>
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">
                                            <div class="style-box-2">
                                                <p>{{trans('overtime.day_type.normal')}}</p>
                                                <p>{{$overtime['normal']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('overtime.day_type.day_off')}}</p>
                                                <p>{{$overtime['weekend']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('overtime.day_type.holiday')}}</p>
                                                <p>{{$overtime['holiday']}}</p>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{trans('leftbar.nav.absence')}}</h3>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button type="button" class="btn btn-default">
                                        <a href="{{route('absences.create')}}"><i class="glyphicon glyphicon-plus"></i>&nbsp;{{trans('absence.add')}}</a>
                                    </button>
                                </div>
                                <div>
                                    <div class=" absence_head" style="padding: 20px 0px;">
                                        <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">
                                            <div class="style-box">
                                                <p style="font-size: 18; font-weight: bold;">{{trans('absence.type.this_year')}}</p>
                                                <p style="font-size: 30; font-weight: bold;">{{$absences['pemission_annual_leave']}}</p>
                                            </div>
                                            <div class="style-box">
                                                <p style="font-size: 18; font-weight: bold;">{{trans('absence.type.last_year')}}</p>
                                                <p style="font-size: 30; font-weight: bold;">{{$absences['remaining_last_year']}}</p>
                                            </div>
                                            <div class="style-box">
                                                <p style="font-size: 18; font-weight: bold;">{{trans('absence.type.total_remaining')}}</p>
                                                <p style="font-size: 30; font-weight: bold;">{{$absences['remaining_this_year']}}</p>
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.annual_leave')}}</p>
                                                <p>{{$absences['annual_leave']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.unpaid_leave')}}</p>
                                                <p>{{$absences['unpaid_leave']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.sick_leave')}}</p>
                                                <p>{{$absences['sick_leave']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.maternity_leave')}}</p>
                                                <p>{{$absences['maternity_leave']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.marriage_leave')}}</p>
                                                <p>{{$absences['marriage_leave']}}</p>
                                            </div>
                                            <div class="style-box-2">
                                                <p>{{trans('absence.type.bereavement_leave')}}</p>
                                                <p>{{$absences['bereavement_leave']}}</p>
                                            </div>
                                        </div>
                                        
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
            @if(Auth::user()->hasRole('BO'))
                <section>                    
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{trans('employee.chart.common')}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.information')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-part">
                                        {{-- @dd($common); --}}
                                            <div class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                {{trans('employee.type.sum')}}: {{$common['sum_employee']}}
                                            </div>
                                            <div class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                {{trans('employee.type.official')}}: {{$common['full-time']}}
                                            </div>
                                            <div class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.type.probationary')}}: {{$common['probationary']}}
                                            </div>
                                            <div class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #faa951;"></i>
                                                {{trans('employee.type.internship')}}: {{$common['internship']}}
                                            </div>
                                            <div class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #00a65a;"></i>
                                                {{trans('employee.type.part-time')}}: {{$common['part-time']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.contract')}}{{trans('employee.this_month')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-part">
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                @if(count($end_internship))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.contract.internship')}}: {{count($end_internship)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($end_internship as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.contract.internship')}}: {{count($end_internship)}}
                                                @endif
                                            </div>
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                @if(count($end_probatination))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.contract.probatination')}}: {{count($end_probatination)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($end_probatination as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.contract.probatination')}}: {{count($end_probatination)}}
                                                @endif
                                            </div>
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                @if(count($end_one_year))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.contract.one-year')}}: {{count($end_one_year)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($end_one_year as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.contract.one-year')}}: {{count($end_one_year)}}
                                                @endif
                                            </div>
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #faa951;"></i>
                                                @if(count($end_three_year))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.contract.three-year')}}: {{count($end_three_year)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($end_three_year as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.contract.three-year')}}: {{count($end_three_year)}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.event')}}{{trans('employee.this_month')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-part">
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                @if(count($birthday_employee))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.event.birthday')}}: {{count($birthday_employee)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($birthday_employee as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.event.birthday')}}: {{count($birthday_employee)}}
                                                @endif
                                            </div>
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                @if(count($new_employee))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.event.new')}}: {{count($new_employee)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($new_employee as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.event.new')}}: {{count($new_employee)}}
                                                @endif
                                            </div>
                                            <div class="dropdown text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                @if(count($leaved_month))
                                                    <a href="#" data-toggle="dropdown">
                                                        {{trans('employee.event.quit')}}: {{count($leaved_month)}}
                                                    </a>
                                                    <ul class="dropdown-menu padding-0-20">
                                                        @foreach($leaved_month as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{trans('employee.event.quit')}}: {{count($leaved_month)}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            {{--end code by Dung--}}

            @if(Auth::user()->hasRole('PO'))
                <section class="">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{trans('dashboard.project_dev')}}</h3>

                            <div class="box-tools pull-right">
                                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button> -->
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
                                            <td><a href="">{{$process['project_id']}}</a></td>
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
                                            <td>{{isset($process['project']['start_date'])? $process['project']['start_date']->format('d-m-Y'):"-"}}</td>
                                            @if($process['project']['estimate_end_date']!=null)
                                                <td>{{isset($process['project']['estimate_end_date'])? $process['project']['estimate_end_date']->format('d-m-Y'):"-"}}</td>
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
                <section>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{trans('dashboard.project')}}</h3>

                            <div class="box-tools pull-right">
                                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button> -->
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
                                            <td>{{(isset($project['start_date']))?$project['start_date']->format('d-m-Y'):'-'}}</td>
                                            <td>{{(isset($project['estimate_end_date']))?$project['estimate_end_date']->format('d-m-Y'):'-'}}</td>                                                
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
                        <div class="row">
                            <div class="col-sm-12">
                                @if($projects->hasPages())
                                    <div class="col-sm-12">
                                        {{  $projects->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            {{--<!-- code from trinhhunganh -->--}}
                @if(Auth::user()->hasRole('Dev'))
                    <section>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{trans('dashboard.project_dev')}}</h3>

                                <div class="box-tools pull-right">
                                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button> -->
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
    {{-- <script type="text/javascript"
    src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
            $(document).ready(function(){
                var id_note = document.getElementById("id_note").value;
                $(".more-"+ id_note).click(function(){
                    $(".more-"+ id_note).hide();
                    $(".back-"+ id_note).show();
                });
                $(".back-"+ id_note).click(function(){
                    $(".back-"+ id_note).hide();
                    $(".more-"+ id_note).show();
                });
            });
    </script> --}}
@endsection
