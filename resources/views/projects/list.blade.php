<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:00 AM
 */ ?>

@extends('admin.template')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('common.title_header.project_list')}}
                <small>NAL Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>--}}
                {{--<li><a href="{{asset('/projects')}}"> {{trans('common.path.projects')}}</a></li>--}}
                {{--<li><a href="#">{{trans('common.title_header.project_list')}}</a></li>--}}
            {{--</ol>--}}
        </section>
        <section class="content-header">
            @if(Auth::user()->hasRole('PO'))
                <div>
                    <button type="button" class="btn btn-default">
                        <a href="{{ asset('projects/create')}}"><i class="fa fa-user-plus"></i> {{trans('common.button.add')}}</a>
                    </button>
                </div>
            @endif
        </section>
        {{--table data project--}}
        <div id="msg"></div>
        @if(Auth::user()->hasRole('PO') || Auth::user()->hasRole('HR'))
           <section class="content">
                <div class="row">
                    <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                           value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                    <div class="col-xs-12">
                        <div class="box">
                            <!-- /.box-header -->
                            <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                            <div class="box-body">
                                <div>
                                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                                        <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                                    </button>
                                    @include("projects._form_search_project_list")
                                    <div class="dataTables_length" id="project-list_length" style="float:right">
                                        <label>{{trans('pagination.show.number_record_per_page')}}
                                            {!! Form::select(
                                                'select_length',
                                                getArraySelectOption() ,
                                                null ,
                                                [
                                                'id'=>'select_length',
                                                'class' => 'form-control input-sm',
                                                'aria-controls'=>"project-list"
                                                ]
                                                )
                                             !!}
                                        </label>
                                    </div>
                                </div>
                                <script>
                                    (function () {
                                        $('#select_length').change(function () {
                                            $("#number_record_per_page").val($(this).val());
                                            $('#form_search_employee').submit()
                                        });
                                    })();
                                </script>

                                <table id="project-list" class="table table-bordered table-striped">
                                    <thead>
                                    <style type="text/css">
                                        .list-project tr td {
                                            vertical-align: middle !important;
                                        }
                                    </style>
                                    <tr class="list-project">
                                        <th class="project-center">{{trans('project.short_id')}}</th>
                                        <th class="project-center">{{trans('project.name')}}</th>
                                        <th class="project-td-po-name project-center">{{trans('project.po')}}</th>
                                        <th class="project-th-members project-center">{{trans('project.members')}}</th>
                                        <th class="text-center project-center">{{trans('project.number_of_member')}}</th>
                                        <th class="project-date">{{trans('project.start_date')}}</th>
                                        <th class="project-date">{{trans('project.end_date')}}</th>
                                        <th class="project-date">{{trans('project.start_date_real')}}</th>
                                        <th class="project-date">{{trans('project.end_date_real')}}</th>
                                        <th class="project-center">{{trans('project.status')}}</th>
                                    </tr>
                                    </thead>

                                    <style type="text/css">
                                        .list-project tr td {
                                            vertical-align: middle !important;
                                        }
                                    </style>
                                    <tbody class="context-menu list-project">
                                    @foreach($projects as $project)
                                        <?php
                                        $allMembers = $project->processes->sortByDesc('start_date')->unique('employee_id');
                                        $allMembersNotPO = $project->processes->where('role_id', '<>', $poRole->id)->sortByDesc('start_date')->unique('employee_id');
                                        $allPO = $project->processes->where('role_id', '=', $poRole->id)->sortByDesc('start_date')->unique('employee_id');
                                        ?>
                                        <tr class="employee-menu" id="employee-id-{{$project->id}}"
                                            data-employee-id="{{$project->id}}">
                                            <td>{{$project->id}}</td>
                                            <td>{{$project->name}}</td>
                                            <td>
                                                <?php
                                                $count = 0;
                                                if (count($allPO) > 0) {
                                                    foreach ($allPO as $employeeInProject) {
                                                        if ($employeeInProject->role_id == $poRole->id) {
                                                            if (sizeof($allPO) > 0 && sizeof($allPO) <= 3) {
                                                                if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                    echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                else{
                                                                    echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                if ($count < sizeof($allPO) - 1) echo', ';
                                                                $count++;
                                                            } else if (sizeof($allPO) > 3) {
                                                                if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                    echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                else{
                                                                    echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                if ($count <= 2) echo ', ';
                                                                if ($count == 2) {
                                                                    echo '<a href="#" class="show-list-po"
                                                            id="show-list-po-' . $project->id . '" data-toggle="modal"
                                                            data-target="#show-list-po">[...]</a>';
                                                                    break;
                                                                }
                                                                $count++;
                                                            } else {
                                                                echo '-';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $count = 0;
                                                if (count($allMembersNotPO) > 0) {
                                                    foreach ($allMembersNotPO as $employeeInProject) {
                                                        if ($employeeInProject->role_id <> $poRole->id) {
                                                            if (sizeof($allMembersNotPO) > 0 && sizeof($allMembersNotPO) <= 3) {
                                                                if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                    echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                else{
                                                                    echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                if ($count < sizeof($allMembersNotPO) - 1) echo', ';
                                                                if($count == sizeof($allMembersNotPO) - 1) echo ' <a href="#" class="show-list-employee"
                                                            id="show-list-employee-' . $project->id . '" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: black">[?]</a>';
                                                                $count++;
                                                            } else if (sizeof($allMembersNotPO) > 3) {
                                                                if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                    echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                else{
                                                                    echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                                }
                                                                if ($count <= 2) echo ', ';
                                                                if ($count == 2) {
                                                                    echo '<a href="#" class="show-list-employee"
                                                            id="show-list-employee-' . $project->id . '" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: red">[...]</a>';
                                                                    break;
                                                                }
                                                                $count++;
                                                            } else {
                                                                echo '-';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge">{{isset($project->processes)?(sizeof($project->processes)!=0?sizeof($project->processes->unique('employee_id')):'0'):'0'}}</span>
                                            </td>
                                            <td>
                                                {{isset($project->estimate_start_date)? date('d/m/Y',strtotime($project->estimate_start_date)):"-"}}
                                            </td>
                                            <td>
                                                {{isset($project->estimate_end_date)? date('d/m/Y',strtotime($project->estimate_end_date)) : "-"}}
                                            </td>
                                            <td>
                                                {{isset($project->start_date)? date('d/m/Y',strtotime($project->start_date)):"-"}}
                                            </td>
                                            <td>
                                                {{isset($project->end_date)? date('d/m/Y',strtotime($project->end_date)): "-"}}
                                            </td>
                                            <td>
                                                @if($project->status->name == 'pending')
                                                    <span class='label label-danger'>{{$project->status->name}}</span>
                                                @elseif($project->status->name == 'complete')
                                                    <span class='label label-success'>{{$project->status->name}}</span>
                                                @elseif($project->status->name == 'in-progress')
                                                    <span class='label label-warning'>{{$project->status->name}}</span>
                                                @elseif($project->status->name == 'releasing')
                                                    <span class='label label-info'>{{$project->status->name}}</span>
                                                @elseif($project->status->name == 'kick off')
                                                    <span class='label label-primary'>{{$project->status->name}}</span>
                                                @elseif($project->status->name == 'planning')
                                                    <span class='label label-default'>{{$project->status->name}}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <ul class="contextMenu" data-employee-id="{{$project->id}}" hidden>
                                                <li><a href="projects/{{$project->id}}"><i
                                                                class="fa fa-id-card"></i> {{trans('common.action.view')}}
                                                    </a></li>
                                                <li><a href="projects/{{$project->id}}/edit"><i class="fa fa-edit"></i>
                                                        {{trans('common.action.edit')}}</a></li>
                                                <li><a class="btn-project-remove" data-employee-id="{{$project->id}}"
                                                       data-employee-name="{{$project->name}}"><i
                                                                class="fa fa-remove"></i> {{trans('common.action.remove')}}
                                                    </a></li>
                                            </ul>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($projects->hasPages())
                                    <div class="col-sm-5">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status"
                                             aria-live="polite">
                                            {{getInformationDataTable($projects)}}
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        {{  $projects->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
                                <div id="show-list-members" class="modal fade" role="dialog">
                                    <div class="modal-dialog" style="width: 400px">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                    <th>{{trans('team.members')}} <span id="team_name_modal"></span>
                                                    </th>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <table id="member-list" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>{{trans('employee.profile_info.short_id')}}</th>
                                                        <th>{{trans('employee.profile_info.name')}}</th>
                                                        <th>{{trans('employee.profile_info.role')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="context-menu" id="table-list-members">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="show-list-po" class="modal fade" role="dialog">
                                    <div class="modal-dialog" style="width: 400px">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                    <th>{{trans('project.po')}} <span id="po_name_modal"></span>
                                                    </th>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <table id="po-list" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>{{trans('employee.profile_info.id')}}</th>
                                                        <th>{{trans('employee.profile_info.name')}}</th>
                                                        <th>{{trans('employee.profile_info.role')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="context-menu" id="table-list-po">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
        @else
            <section>
                <div class="box box-info">
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
        @endif
    </div>
    @include("projects._javascript_project_list")
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            bottom: 14px;
            right: 8px;
            display: block;
            font-family: 'Glyphicons Halflings';
            opacity: 0.5;
        }
        thead tr th {
            vertical-align: middle !important;
        }
    </style>
@endsection