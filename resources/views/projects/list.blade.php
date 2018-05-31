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
                Project List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/projects')}}"> Project</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>

        @include("projects._form_search_project_list")
        {{--table data project--}}
        <div id="msg"></div>
        <section class="content">
            <div class="row">
                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
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
                                <tr>
                                    <th>{{trans('project.name')}}</th>
                                    <th class="project-td-po-name">{{trans('project.po')}}</th>
                                    <th class="project-th-members">{{trans('project.members')}}</th>
                                    <th class="text-center">{{trans('project.number_of_member')}}</th>
                                    <th class="project-date">{{trans('project.start_date')}}</th>
                                    <th class="project-date">{{trans('project.end_date')}}</th>
                                    <th class="project-date">{{trans('project.start_date_real')}}</th>
                                    <th class="project-date">{{trans('project.end_date_real')}}</th>
                                    <th>{{trans('project.status')}}</th>
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($projects as $project)
                                    <?php
                                    $allMemberNotPOInProject = $project->processes;
                                    ?>
                                    <tr class="employee-menu" id="employee-id-{{$project->id}}"
                                        data-employee-id="{{$project->id}}">
                                        <td>{{$project->name}}</td>
                                        <td>
                                            <?php
                                            if (count($allMemberNotPOInProject) > 0) {
                                                foreach ($allMemberNotPOInProject as $employeeInProject) {
                                                    $getPO = $allMemberNotPOInProject->where('role_id', $poRole->id)->first();
                                                }

                                                if (!is_null($getPO)) {
                                                    if ($employeeInProject->employee->is_employee == $isEmployee){
                                                        echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                    }
                                                    else if($employeeInProject->employee->is_employee == $isVendor){
                                                        echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                    }
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                            {{--@if(isset($po))
                                                <a href="employee/{{$po->id}}">{{$po->name}}</a>
                                            @else
                                                -
                                            @endif--}}
                                        </td>
                                        <td>
                                            <?php
                                            $count = 0;
                                            if (count($allMemberNotPOInProject) > 0) {
                                                foreach ($allMemberNotPOInProject as $employeeInProject) {
                                                    if ($employeeInProject->role_id <> $poRole->id) {
                                                        if (sizeof($allMemberNotPOInProject) > 0 && sizeof($allMemberNotPOInProject) <= 3) {
                                                            if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                            }
                                                            else{
                                                                echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                            }
                                                            if ($count < sizeof($allMemberNotPOInProject) - 1) echo ', ';
                                                            $count++;
                                                        } else if (sizeof($allMemberNotPOInProject) > 3) {
                                                            if ($employeeInProject->employee->is_employee == $isEmployee){
                                                                echo '<a href="employee/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                            }
                                                            else{
                                                                echo '<a href="vendors/' . $employeeInProject->employee->id . '">' . $employeeInProject->employee->name . '</a>';
                                                            }
                                                            if ($count <= 2) echo ', ';
                                                            if ($count == 1) {
                                                                echo '<a href="#" class="show-list-employee"
                                                            id="show-list-employee-' . $project->id . '" data-toggle="modal"
                                                            data-target="#show-list-members">[...]</a>';
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
                                            <span class="badge">{{isset($project->processes)?(sizeof($project->processes)!=0?sizeof($project->processes):'-'):'-'}}</span>
                                        </td>
                                        <td>
                                            {{isset($project->estimate_start_date)? $project->estimate_start_date:"-"}}
                                        </td>
                                        <td>
                                            {{isset($project->estimate_end_date)? $project->estimate_end_date : "-"}}
                                        </td>
                                        <td>
                                            {{isset($project->start_date)? $project->start_date :"-"}}
                                        </td>
                                        <td>
                                            {{isset($project->end_date)? $project->end_date : "-"}}
                                        </td>
                                        <td>
                                            @if($project->status->name == 'pending')
                                                <span class='label label-primary'>{{$project->status->name}}</span>
                                            @elseif($project->status->name == 'complete')
                                                <span class='label label-success'>{{$project->status->name}}</span>
                                            @elseif($project->status->name == 'in-progress')
                                                <span class='label label-info'>{{$project->status->name}}</span>
                                            @elseif($project->status->name == 'releasing')
                                                <span class='label label-warning'>{{$project->status->name}}</span>
                                            @elseif($project->status->name == 'kick off')
                                                <span class='label label-danger'>{{$project->status->name}}</span>
                                            @elseif($project->status->name == 'planning')
                                                <span class='label label-default'>{{$project->status->name}}</span>
                                            @else
                                                -
                                            @endif
                                            {{--{{isset($project->status_id)?

                                             $project->status->name

                                             : "-"}}--}}
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
                            @if(isset($param))
                                {{  $projects->appends($param)->render('vendor.pagination.custom') }}
                            @endif
                            <div id="show-list-members" class="modal fade" role="dialog">
                                <div class="modal-dialog" style="width: 400px">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">
                                                <th>{{trans('team.members')}} - Team: <span id="team_name_modal"></span>
                                                </th>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <table id="member-list" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>{{trans('employee.profile_info.id')}}</th>
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
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    </div>

    @include("projects._javascript_project_list")

@endsection