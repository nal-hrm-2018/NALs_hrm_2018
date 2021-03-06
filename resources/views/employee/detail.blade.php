@extends('admin.template')
@section('content')
    <style type="text/css">
        .table tbody tr td {
            vertical-align: middle;
        }
        .table thead tr th {
            vertical-align: middle;
        }
        .width-90 {
            width: 90px;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{  trans('common.title_header.employee_detail') }}
                <small>NAL Solutions</small>
            </h1>
        </section>
        <div id="msg">
        </div>
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li style="margin:0 30px;" >
                        <a id="tab-basic" href="#basic" data-toggle="tab">{{trans('employee.basic')}}</a>
                    </li>
                    <li>
                        <a id="tab-project" href="#project" data-toggle="tab">{{trans('project.title')}}</a>
                    </li>
                    @if(Auth::user()->hasRole('BO')||Auth::user()->hasRole('PO'))
                    <li>
                        <a id="tab-overtime" href="#overtime" data-toggle="tab">{{trans('common.title_header.overtime')}}</a>
                    </li>
                    <li>
                        <a id="tab-absence" href="#absence" data-toggle="tab">{{ trans('absence.absence') }}</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="basic">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img style="width: 130px;height: 130px;" class="profile-user-img img-responsive img-circle"
                                             src="@if(isset($employee->avatar))
                                             {{asset('/avatar/'.$employee->avatar)}}
                                             @else
                                             {{asset('/avatar/default_avatar.png')}}
                                             @endif"
                                             alt="User profile picture" style="width: 150px; height: 150px;">

                                        <h3 class="profile-username text-center">{{$employee->name}}</h3>


                                        <p class="text-muted text-center">{{isset($employee->employeeType)?$employee->employeeType->name:'-'}}</p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-1"></div>
                            <div class="col-md-7">
                                <div class="box box-primary">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-left: 20px;">
                                            <h2 class="profile-username">{{trans('employee.profile_info.title')}}</h2>
                                            <p>{{trans('employee.profile_info.name')}}:
                                                <strong>{{$employee->name}}</strong></p>
                                            <p>{{trans('employee.profile_info.gender.title')}}:
                                                @if($employee->gender == 1)
                                                    <span class="label label-info">{{trans('employee.profile_info.gender.female')}}</span>
                                                @elseif($employee->gender == 2)
                                                    <span class="label label-success">{{trans('employee.profile_info.gender.male')}}</span>
                                                @elseif($employee->gender == 3)
                                                    <span class="label label-warning">{{trans('employee.profile_info.gender.na')}}</span>
                                                @endif
                                            </p>
                                            <p>{{trans('employee.profile_info.birthday')}}:
                                                <strong>{{isset($employee->birthday)?date('d/m/Y', strtotime($employee->birthday)):'-'}}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.email')}}:
                                                <strong>{{$employee->email}}</strong></p>


                                            <p>{{trans('employee.profile_info.phone')}}:
                                                <strong>{{isset($employee->mobile)?$employee->mobile:'-'}}</strong></p>
                                            <p>{{trans('employee.profile_info.address')}}:
                                                <strong>{{isset($employee->address)?$employee->address:'-'}}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.marital_status.title')}}:
                                                @if($employee->marital_status == 1)
                                                    <span class="label label-default">{{trans('employee.profile_info.marital_status.single')}}</span>
                                                @elseif($employee->marital_status == 2)
                                                    <span class="label label-primary">{{trans('employee.profile_info.marital_status.married')}}</span>
                                                @elseif($employee->marital_status == 3)
                                                    <span class="label label-warning">{{trans('employee.profile_info.marital_status.separated')}}</span>
                                                @elseif($employee->marital_status == 4)
                                                    <span class="label label-danger">{{trans('employee.profile_info.marital_status.divorced')}}</span>
                                                @endif
                                            </p>
                                            @php
                                                $arr_team = $employee->teams()->get();
                                                $string_team ="";
                                                foreach ($arr_team as $team){
                                                  $addteam=  (string)$team->name;
                                                  if ($string_team){
                                                  $string_team = $string_team.", ".$addteam;
                                                  } else{
                                                  $string_team = $string_team."".$addteam;
                                                  }
                                                }
                                                // dd($string_team);
                                            @endphp

                                            <p>{{trans('employee.profile_info.team')}}:
                                                <strong>{{ ($string_team)?$string_team:'NALs' }}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.role')}}:
                                            
                                            <?php
                                            if(isset($employee->role)){
                                                if($employee->role->name == "PO"){
                                                    echo "<span class='label label-warning'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "Dev"){
                                                    echo "<span class='label label-success'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "BO"){
                                                    echo "<span class='label label-default'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "SM/AL"){
                                                    echo "<span class='label label-danger'>". $employee->role->name ."</span>";
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                            </p>
                                            <p>{{trans('employee.profile_info.contract_type')}}: 
                                            @php
                                                switch ($employee->contractualType->name) {
                                                    case 'Internship':
                                                        echo '<strong>'. trans('employee.contract.internship'). '</strong>';
                                                        break;
                                                    case 'Probationary':
                                                        echo '<strong>' . trans('employee.contract.probatination'). '</strong>';
                                                        break;
                                                    case 'One-year':
                                                        echo '<strong>' . trans('employee.contract.one-year'). '</strong>';
                                                        break;
                                                    case 'Three-year':
                                                        echo '<strong>' . trans('employee.contract.three-year'). '</strong>';
                                                        break;
                                                    case 'Indefinite':
                                                        echo '<strong>' . trans('employee.contract.indefinite'). '</strong>';
                                                        break;
                                                    case 'Part-time':
                                                        echo '<strong>' . trans('employee.contract.part-time'). '</strong>';
                                                        break;                                                    
                                                    default:
                                                        echo '<strong>-</strong>';
                                                        break;
                                                }
                                            @endphp
                                            <p>{{trans('employee.profile_info.start_work')}}:
                                                @if(isset($employee->startwork_date))
                                                        <strong>{{date('d/m/Y', strtotime($employee->startwork_date))}}</strong>
                                                @else 
                                                    -
                                                @endif
                                            </p>
                                            <p>{{trans('employee.profile_info.policy_status.title')}}:
                                                @if($employee->work_status == 0)
                                                    @if($employee->endwork_date)
                                                        @if(strtotime($employee->endwork_date) >= strtotime(date('Y-m-d')))
                                                            <span class="label label-primary">{{trans('employee.profile_info.status_active')}}</span>
                                                        @else
                                                            <span class="label label-danger">{{trans('employee.profile_info.status_expired')}}</span>
                                                        @endif
                                                    @else
                                                        <span class="label label-primary">{{trans('employee.profile_info.status_active')}}</span>
                                                    @endif
                                                @else
                                                    <span class="label label-default">{{trans('employee.profile_info.status_quited')}}</span>
                                                @endif
                                            </p>

                                            <p>{{trans('employee.profile_info.the_rest_absence')}}:
                                                <strong> {{$rest_absence}}</strong></p>

                                        </div>
                                        {{-- <div class="col-md-6">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                                {{--<h2 class="profile-username text-center">{{trans('chart.resource_chart.title')}}</h2>--}}
                                                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                                                    {{--<div class="row">--}}
                                                        {{--<div class="col-md-3"></div>--}}
                                                        {{--<div class="form-group col-md-6">--}}
                                                            {{--<select class="form-control" id="sel1" name="year">--}}
                                                                {{--@foreach($listYears as $year)--}}
                                                                    {{--<option @if($year == $listValue[0]) selected--}}
                                                                            {{--@endif value="{{$year}}">{{trans('employee.profile_info.year')}}: {{$year}}</option>--}}
                                                                {{--@endforeach--}}
                                                            {{--</select>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="box box-primary">--}}
                                                        {{--<div class="box-header with-border">--}}
                                                            {{--<i class="fa fa-bar-chart-o"></i>--}}

                                                            {{--<h3 class="box-title">{{trans('chart.resource_chart.title')}}--}}
                                                                {{--- <span--}}
                                                                        {{--id="current-year">{{$listValue[0]}}</span></h3>--}}

                                                            {{--<div class="box-tools pull-right">--}}
                                                                {{--<button type="button" class="btn btn-box-tool"--}}
                                                                        {{--data-widget="collapse"><i--}}
                                                                            {{--class="fa fa-minus"></i>--}}
                                                                {{--</button>--}}
                                                                {{--<button type="button" class="btn btn-box-tool"--}}
                                                                        {{--data-widget="remove"><i class="fa fa-times"></i>--}}
                                                                {{--</button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="box-body">--}}
                                                            {{--<div id="bar-chart" style="height: 235px;">--}}
                                                                {{--<img width="100%" src="{!! asset('admin/templates/images/temporary/chart.png') !!}">--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<!-- /.box-body-->--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.box -->--}}

                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <!-- /.col -->
                        </div>
                            <div class="col-md-1"></div>
                        <!-- /.post -->
                    </div>
                    <div class="tab-pane" id="project">
                        
                        <!-- The project -->

                        @include('employee._list_project_employee')

                    </div>
                    <div class="tab-pane" id="overtime">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            {{-- <div>
                                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demooo" id="clickCollapse">
                                                    <span class="fa fa-search"></span>&nbsp;Search
                                                </button>
                                                <div id="demooo" class="collapse margin-form-search">
                                                    <form method="get" role="form">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.id')}}</button>
                                                                            </div>
                                                                            <input type="text" name="id" id="employeeId" class="form-control">
                                                                        </div>
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.name')}}</button>
                                                                            </div>
                                                                            <input type="text" name="name" id="nameEmployee" class="form-control">
                                                                        </div>
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.team')}}</button>
                                                                            </div>
                                                                            <select name="team" id="team_employee" class="form-control">
                                                                                <option></option>
                                                                                <option></option>
                                                                                <option></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn width-100">Date</button>
                                                                            </div>
                                                                            <input type="date" name="date" class="form-control">
                                                                        </div>
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button" class="btn width-100">Month</button>
                                                                            </div>
                                                                            <select name="month" class="form-control">
                                                                                <option></option>
                                                                                <option></option>
                                                                                <option></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="input-group margin">
                                                                            <div class="input-group-btn">
                                                                                <button type="button"
                                                                                        class="btn width-100"> Year</button>
                                                                            </div>
                                                                            <select name="year" class="form-control">
                                                                                <option></option>
                                                                                <option></option>
                                                                                <option></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer center">
                                                                <button id="btn_reset_employee" type="button" class="btn btn-default"><span class="fa fa-refresh"></span>
                                                                    {{trans('common.button.reset')}}
                                                                </button>
                                                                <button type="submit" id="searchListEmployee" class="btn btn-info"><span
                                                                            class="fa fa-search"></span>
                                                                    {{trans('common.button.search')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div style="float: right; margin-bottom: 15px;">
                                                    <label class="lable-entries" style="float: right;">{{trans('pagination.show.number_record_per_page')}}</label><br />
                                                    <select class="input-entries" style="float: right;">
                                                        <option>10</option>
                                                        <option>20</option>
                                                        <option>30</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <table id="" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{trans('overtime.number')}}</th>
                                                        <th>{{trans('overtime.project')}}</th>
                                                        <th>{{trans('overtime.date')}}</th>
                                                        <th>{{trans('overtime.reason')}}</th>
                                                        <th class="text-center">{{trans('overtime.start_time')}}</th>
                                                        <th class="text-center">{{trans('overtime.end_time')}}</th>
                                                        <th class="text-center">{{trans('overtime.total_time')}}</th>
                                                        <th class="text-center">{{trans('overtime.type')}}</th>
                                                        <th class="text-center">{{trans('overtime.correct_total_time')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count =0;
                                                    @endphp
                                                    @foreach($overtime as $val)
                                                        @php
                                                            $count++;
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{$count}}</td>
                                                            <td>{{ isset($val->process->project->name)?$val->process->project->name:'-'}}</td>
                                                            <td>{{$val->date->format('d/m/Y')}}</td>
                                                            <td>{{$val->reason}}</td>
                                                            <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->start_time)->format('H:i')}}</td>
                                                            <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->end_time)->format('H:i')}}</td>
                                                            <td class="text-center">
                                                                <span class="label label-primary">{{$val->total_time}}  {{($val->total_time <2)? trans('overtime.hour'): trans('overtime.hours') }}<span>
                                                             </td>
                                                            @if ($val->type->name == 'normal')
                                                                <td class="text-center"><span class="label" style="background: #9072ff;">{{trans('overtime.day_type.normal')}}</span></td>
                                                            @elseif($val->type->name == 'weekend')
                                                                <td class="text-center"><span class="label" style="background: #643aff;">{{trans('overtime.day_type.day_off')}}</span></td>
                                                            @else($val->type->name == 'holiday')
                                                                <td class="text-center"><span class="label" style="background: #3600ff;">{{trans('overtime.day_type.holiday')}}</span></td>
                                                            @endif    
                                                            @if (isset($val->correct_total_time))
                                                                <td class="text-center"><span class="label label-success">{{$val->correct_total_time}} {{($val->correct_total_time <2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                                                </td>
                                                            @else
                                                                <td class="text-center">-</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6" rowspan="3"></td>
                                                        <td rowspan="3">{{trans('overtime.total')}}</td>
                                                        <td><span class="label" style="background: #9072ff;">{{trans('overtime.day_type.normal')}}</span></td>
                                                         @if ($time['normal'])
                                                            <td class="text-center">
                                                                <span class="label label-success">{{$time['normal']}} {{($time['normal'] <2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                                            </td>
                                                        @else
                                                            <td class="text-center">-</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><span class="label" style="background: #643aff;">{{trans('overtime.day_type.day_off')}}</span></td>
                                                        @if ($time['weekend'])
                                                            <td class="text-center">
                                                                <span class="label label-success">{{$time['weekend']}}  {{($time['weekend'] <2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                                            </td>
                                                        @else
                                                            <td class="text-center">-</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><span class="label" style="background: #3600ff;">{{trans('overtime.day_type.holiday')}}</span></td>
                                                        @if ($time['holiday'])
                                                            <td class="text-center">
                                                                <span class="label label-success">{{$time['holiday']}}  {{($time['holiday'] <2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                                            </td>
                                                        @else
                                                            <td class="text-center">-</td>

                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="tab-pane" id="absence">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <table id="" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">{{trans('common.number')}}</th>
                                                        <th class="align-middle">{{trans('absence.start_date')}}</th>
                                                        <th class="align-middle">{{trans('absence.end_date')}}</th>
                                                        <th class="align-middle">{{trans('absence.absence_type')}}</th>
                                                        <th class="align-middle">{{trans('absence.absence_time')}}</th>
                                                        <th class="align-middle">{{trans('absence.reason')}}</th>
                                                        <th class="align-middle">{{trans('absence.valid_day')}}</th>
                                                        <th class="align-middle">{{trans('absence.description')}}</th>
                                                        <th class="align-middle text-center">{{trans('absence.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach($listAbsence as $absence)
                                                    <tr>
                                                        <td class="align-middle">{{$count++ }}</td>
                                                        <td class="align-middle">{{ isset($absence['from_date'])? date_create($absence['from_date'])->format('d/m/Y'):'-' }}</td>
                                                        <td class="align-middle">{{ isset($absence['to_date'])? date_create($absence['to_date'])->format('d/m/Y'):'-' }}</td>
                                                        {{-- <td>
                                                            @if(trans('absence_po.list_po.type.'.$absence->name_type) == trans('absence_po.list_po.type.salary_date'))
                                                                <span class="label label-primary">
                                                            @elseif(trans('absence_po.list_po.type.'.$absence->name_type) == trans('absence_po.list_po.type.non_salary_date'))
                                                                <span class="label label-info">
                                                            @elseif(trans('absence_po.list_po.type.'.$absence->name_type) == trans('absence_po.list_po.type.subtract_salary_date'))
                                                                <span class="label label-danger">
                                                            @elseif(trans('absence_po.list_po.type.'.$absence->name_type) == trans('absence_po.list_po.type.insurance_date'))
                                                                <span class="label label-default">
                                                            @else
                                                                <span>{{trans('absence_po.list_po.type.'.$absence->name_type)}}</span>
                                                            @endif
                                                        </td> --}}
                                                        <td> <span>{{trans('absence.type.'.$absence['name_type'])}}</span></td>
                                                        <td><span>{{trans('absence.'.$absence['name_time'])}}</span></td>
                                                        <td>{{$absence['reason'] ? $absence['reason'] : "-"}}</td>
                                                        <td>{{$absence['valid_date']}}</td>
                                                        <td>{{$absence['description'] ? $absence['description'] : "-"}}</td>
                                                        <td class="align-middle text-center">
                                                            @if(Auth::user()->hasRole('BO'))
                                                            <a href="{{ route('absences.edit',['absence'=>$absence['id']]) }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                                            <form style="display: inline;" >
                                                                <a onclick="return confirm_delete();" href="{{route('absencess.destroy',['id'=>$absence['id']])}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                     @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- Main content -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        function confirm_delete(){
            return confirm(message_confirm('{{trans('common.action.remove')}}','{{trans('absence.absence')}}',''));
        }
    </script>
    <!-- /.content-wrapper -->
    <!-- jQuery 3 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script>
        $(document).ready(function () {
            function sendRequestAjax(id, year) {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/employee') }}' + '/' + id,
                    data: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'id': id,
                        'year': year,
                        '_method': 'POST',
                        _token: '{{csrf_token()}}',
                    },
                    success: function (msg) {
                        var bar_data = {
                            data: [["{{trans('chart.resource_chart.jan')}}", msg.listValue[1]], ["{{trans('chart.resource_chart.feb')}}", msg.listValue[2]],
                                ["{{trans('chart.resource_chart.mar')}}", msg.listValue[3]], ["{{trans('chart.resource_chart.apr')}}", msg.listValue[4]],
                                ["{{trans('chart.resource_chart.may')}}", msg.listValue[5]], ["{{trans('chart.resource_chart.jun')}}", msg.listValue[6]],
                                ["{{trans('chart.resource_chart.jul')}}", msg.listValue[7]], ["{{trans('chart.resource_chart.aug')}}", msg.listValue[8]],
                                ["{{trans('chart.resource_chart.sep')}}", msg.listValue[9]], ["{{trans('chart.resource_chart.oct')}}", msg.listValue[10]],
                                ["{{trans('chart.resource_chart.nov')}}", msg.listValue[11]], ["{{trans('chart.resource_chart.dec')}}", msg.listValue[12]]],
                            color: '#3c8dbc'
                        }
                        $('#current-year').html(msg.listValue[0]);
                        showChart(bar_data);
                    }
                });
            }

            $('#sel1').change(function () {
                var year = $('#sel1').val();
                var id = '{{$employee->id}}';
                sendRequestAjax(id, year);
            });


            $(function () {
                $("#tab-basic").bind("click", function () {
                    activaTab('basic');
                    var year = $('#sel1').val();
                    var id = '{{$employee->id}}';
                    sendRequestAjax(id, year);
                });
            });

            $(function () {
                $("#tab-overtime").bind("click", function () {
                    activaTab('overtime');
                });
            });

            $(function () {
                $("#tab-absence").bind("click", function () {
                    activaTab('absence');
                });
            });

            <?php
                if(isset($_GET['overtime'])){
                $overtime = $_GET['overtime'];
                $basic = $_GET['basic'];
                $absence = $_GET['absence'];
            ?>

            var basic = <?php echo json_encode($basic); ?>;
            var overtime = <?php echo json_encode($overtime); ?>;
            var absence = <?php echo json_encode($absence); ?>;

            if (project == 1) {
                activaTab('project');
            } else if (overtime == 1) {
                activaTab('overtime');
            } else if (absence == 1) {
                activaTab('absence');
            } else if (basic == 1) {
                activaTab('basic')
                // $(function () {
                //     activaTab('basic');
                //     var bar_data = {
                //         data: [["{{trans('chart.resource_chart.jan')}}", {{$listValue[1]}}], ["{{trans('chart.resource_chart.feb')}}", {{$listValue[2]}}],
                //             ["{{trans('chart.resource_chart.mar')}}", {{$listValue[3]}}], ["{{trans('chart.resource_chart.apr')}}", {{$listValue[4]}}],
                //             ["{{trans('chart.resource_chart.may')}}", {{$listValue[5]}}], ["{{trans('chart.resource_chart.jun')}}", {{$listValue[6]}}],
                //             ["{{trans('chart.resource_chart.jul')}}", {{$listValue[7]}}], ["{{trans('chart.resource_chart.aug')}}", {{$listValue[8]}}],
                //             ["{{trans('chart.resource_chart.sep')}}", {{$listValue[9]}}], ["{{trans('chart.resource_chart.oct')}}", {{$listValue[10]}}],
                //             ["{{trans('chart.resource_chart.nov')}}", {{$listValue[11]}}], ["{{trans('chart.resource_chart.dec')}}", {{$listValue[12]}}]],
                //         color: '#3c8dbc'
                //     }
                //     showChart(bar_data);
                // });
            }

            <?php
                }else{
            ?>
            activaTab('basic')
            // $(function () {
            //     activaTab('basic');
            //     var bar_data = {
            //         data: [["{{trans('chart.resource_chart.jan')}}", {{$listValue[1]}}], ["{{trans('chart.resource_chart.feb')}}", {{$listValue[2]}}],
            //             ["{{trans('chart.resource_chart.mar')}}", {{$listValue[3]}}], ["{{trans('chart.resource_chart.apr')}}", {{$listValue[4]}}],
            //             ["{{trans('chart.resource_chart.may')}}", {{$listValue[5]}}], ["{{trans('chart.resource_chart.jun')}}", {{$listValue[6]}}],
            //             ["{{trans('chart.resource_chart.jul')}}", {{$listValue[7]}}], ["{{trans('chart.resource_chart.aug')}}", {{$listValue[8]}}],
            //             ["{{trans('chart.resource_chart.sep')}}", {{$listValue[9]}}], ["{{trans('chart.resource_chart.oct')}}", {{$listValue[10]}}],
            //             ["{{trans('chart.resource_chart.nov')}}", {{$listValue[11]}}], ["{{trans('chart.resource_chart.dec')}}", {{$listValue[12]}}]],
            //         color: '#3c8dbc'
            //     }
            //     showChart(bar_data);
            // });
            <?php
                }
            ?>
            function activaTab(tab) {
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            };
        });

    </script>
    <script>
        function showChart(bar_data) {
            $.plot('#bar-chart', [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor: '#f3f3f3',
                    hoverable: true
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.75,
                        align: 'center'
                    }
                },
                xaxis: {
                    mode: 'categories',
                    tickLength: 0
                },
                yaxis: {
                    tickFormatter: function (val, axis) {
                        return '$' + val.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
                    },
                },
                tooltip: {
                    show: true,
                    content: "<span style='font-size: 12px;line-height: 17px;max-width: 90px;background-color: #00b4ab;" +
                    "color: #fff;text-align: center;border-radius: 6px;padding: 10px;'>%x : %y</span>",
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            })
        }
    </script>
    <script>
        $('#btn-search').click(function () {
            $('#form_search_process').trigger("reset");
        });
    </script>
@endsection