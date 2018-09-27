@extends('admin.template')
@section('content')

    {{--start code by Dung--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <style>
        .style-box {
            margin: 10px;
            padding: 10px;
            border: 3px solid #00c0ef;
            border-radius: 5px;
            min-width: 200px;
            color: black;
            background: white;
        }
        .style-box-2 {
            margin: 10px;
            padding: 10px;
            border: 3px solid #00c0ef;
            border-radius: 5px;
            min-width: 100px;
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
        .height-200{
           height: 200px;
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
                                @if($notifications->count()<=0)
                                {{trans('notification.no_notification')}}
                                @endif
                                @foreach($notifications as $note)
                                    <li class="treeview" style="margin-bottom: 10px;">
                                        {{-- @php
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
                                        @endphp --}}
                                        <label class="label bg-yellow" style="width: 40px; display: inline-block;">NALs</label>
                                        <a href="#">
                                            <span style="color: black; ">[{{date('d/m',strtotime($note->create_at))}}]</span>
                                            <span style="vertical-align: middle; color: black;">{{$note->title}}</span>
                                        </a>
                                        <ul>
                                            <div class="span4 collapse-group">
                                            <input type="text" id="id_note" value="{{$note->id}}" hidden />
                                                  <p>
                                                  <?php echo (substr($note->content,0,strpos($note->content,'-',2)));?>
                                                  <span class="collapse" id="viewdetails-{{$note->id}}"><?php echo nl2br(substr($note->content,strpos($note->content,'-',2)));?>
                                                       </span>
                                                    <a data-toggle="collapse" class="more-{{$note->id}}" data-target="#viewdetails-{{$note->id}}">... &raquo;</a>
                                                    <a data-toggle="collapse" class="back-{{$note->id}}" data-target="#viewdetails-{{$note->id}}" hidden>&lsaquo;&lsaquo;</a>
                                                       </p>
                                              </div>
                                        </ul>
                                        {{-- @php
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
                                        @endphp --}}
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
                            <div class=" absence_head" style="padding: 20px 0px;">
                                <div style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">
                                    <div class="style-box">
                                        <p style="font-size: 22px; font-weight: bold;">{{trans('absence.type.this_year')}}</p>
                                        <p style="font-size: 44px; font-weight: bold;">{{$absences['pemission_annual_leave']}}</p>
                                    </div>
                                    <div class="style-box">
                                        <p style="font-size: 22px; font-weight: bold;">{{trans('absence.type.last_year')}}</p>
                                        <p style="font-size: 44px; font-weight: bold;">{{$absences['remaining_last_year']}}</p>
                                    </div>
                                    <div class="style-box">
                                        <p style="font-size: 22px; font-weight: bold;">{{trans('absence.type.total_remaining')}}</p>
                                        <p style="font-size: 44px; font-weight: bold;">{{$absences['remaining_this_year']}}</p>
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
                                        <div class="box-body height-200">
                                        {{-- @dd($common); --}}
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                {{trans('employee.type.sum')}}: {{$common['sum_employee']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                {{trans('employee.type.official')}}: {{$common['full-time']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.type.probationary')}}: {{$common['probationary']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #faa951;"></i>
                                                {{trans('employee.type.internship')}}: {{$common['internship']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #00a65a;"></i>
                                                {{trans('employee.type.part-time')}}: {{$common['part-time']}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger height-400">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.contract')}}{{trans('employee.this_month')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        {{-- @dd($end_contract); --}}
                                        <div class="box-body height-200">
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                {{trans('employee.contract.internship')}}: {{$end_contract['end_internship']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                {{trans('employee.contract.probatination')}}: {{$end_contract['end_probatination']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.contract.one-year')}}: {{$end_contract['end_one_year']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #faa951;"></i>
                                                {{trans('employee.contract.three-year')}}: {{$end_contract['end_three_year']}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger height-200">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.event')}}{{trans('employee.this_month')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        {{-- @dd($this_month); --}}
                                        <div class="box-body height-350">
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #f74e1e;"></i>
                                                {{trans('employee.event.new')}}: {{$this_month['new']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                {{trans('employee.event.birthday')}}: {{$this_month['birthday']}}
                                            </p>
                                            <p class="text-legend width-350">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                {{trans('employee.event.quit')}}: {{$this_month['leaved']}}
                                            </p>
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
