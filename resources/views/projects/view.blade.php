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
                Project Detail
                <small>Nal solution</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/projects')}}"> Projects</a></li>
                <li><a href="#">Detail</a></li>
            </ol>
        </section>

        <!-- Main content -->
      <div id="msg"></div>
        <section class="content">
           <div class="row">
              <div class="box">
                 <!-- /.box-header -->
                <div class="col-xs-12">
                    <h2>Project ID: <strong>{{$project->id}}</strong></h2>
                    <p>Project Name:
                        <strong>{{$project->name}}</strong>
                    </p>
                    <p>Income:
                        <strong>{{number_format($project->income). ' VNĐ'}}</strong>
                    </p>

                    <p>Estimate Cost:
                        <strong>
                            <?php
                                $estimate_cost=0;
                                foreach ($member as $process){
                                    $salary = 10000000;
                                    $first_date = strtotime($process->start_date);
                                    $second_date = strtotime($process->end_date);
                                    $datediff = abs($first_date - $second_date);
                                    $time = floor($datediff / (60*60*24));
                                    $cs =$process->man_power;
                                    $estimate_cost_mem = $salary*$cs*$time;
                                    $estimate_cost += $estimate_cost_mem;
                                }   echo number_format($estimate_cost). ' VNĐ';
                            ?>

                        </strong>
                    </p>

                    <p>Real Cost:
                        <strong>{{number_format($project->real_cost). ' VNĐ'}}</strong>
                    </p>

                    <p>Status:
                        @if($project->status_id == 1)
                            <span class="label label-primary">Kick Off</span>
                        @elseif($project->status_id == 2)
                            <span class="label label-danger">Pending</span>
                        @elseif($project->status_id == 3)
                            <span class="label label-warning">In-Progress</span>
                        @elseif($project->status_id == 4)
                            <span class="label label-info">Releasing</span>
                        @elseif($project->status_id == 5)
                            <span class="label label-success">Complete</span>
                        @endif
                    </p>

                    <p>Estimate Date:
                        <strong>{{date('d/m/Y', strtotime($project->estimate_start_date))}}
                            - {{date('d/m/Y', strtotime($project->estimate_end_date))}}</strong>
                    </p>

                    <p>Real Date:
                        <strong>{{date('d/m/Y', strtotime($project->start_date))}}
                            - {{date('d/m/Y', strtotime($project->end_date))}}</strong>
                    </p>
                    <br>
                </div>

                    <div class="box-body">
                        <table id="project-list" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">CV</th>
                                <th class="text-center">Performance</th>
                            </tr>
                            </thead>
                            <tbody class="context-menu">
                            {{--{{var_dump($project)}}--}}
                            @foreach($member as $employee)

                                <tr class="project-menu" id="employee-id-{{$employee->employee_id}}"
                                    data-employee-id="{{$employee->employee_id}}">
                                    <td>
                                        @if($employee->is_employee==1)
                                        <a href="{!! asset('employee/'.$employee->employee_id)!!}">
                                            {{ isset($employee->name)? $employee->name: "-" }}
                                        </a>
                                        @else
                                            <a href="{!! asset('vendors/'.$employee->employee_id)!!}">
                                                {{ isset($employee->name)? $employee->name: "-" }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <?php
                                            if($employee->role_id == 1){
                                                echo "<span class='label label-success'>Dev</span>";
                                            } if($employee->role_id == 2){
                                                echo "<span class='label label-info'>BA</span>";
                                            } if($employee->role_id == 3){
                                                echo "<span class='label label-warning'>ScrumMaster</span>";
                                            } if($employee->role_id == 4){
                                                echo "<span class='label label-primary'>PO</span>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        @if($employee->is_employee==1)
                                            <a href="{!! asset('employee/'.$employee->employee_id)!!}">
                                                {{ isset($employee->email)? $employee->email: "-" }}
                                            </a>
                                        @else
                                            <a href="{!! asset('vendors/'.$employee->employee_id)!!}">
                                                {{ isset($employee->email)? $employee->email: "-" }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ isset($employee->mobile)? $employee->mobile: "-" }}</td>

                                    <td class="text-center">
                                        {{isset($employee->start_date)? $employee->start_date: "-"}}
                                    </td>

                                    <td class="text-center">
                                            {{isset($employee->end_date)? $employee->end_date: "-"}}
                                    </td>

                                    <td style="text-align: center;width: 50px;">
                                        <button type="button" class="btn btn-default cv-button">
                                            <a href="javascript:void(0)"><i class="fa fa-cloud-download"></i> CV</a>
                                        </button>
                                    </td>

                                    <td style="text-align: center;width: 160px;">
                                        <button type="button" class="btn btn-default input-button">
                                            <a href="javascript:void(0)"><i class="	fa fa-plus-square"></i> Input</a>
                                        </button>

                                        <button type="button" class="btn btn-default view-button">
                                            <a href="javascript:void(0)"><i class="fa fa-search-plus"></i> View</a>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                        <!-- /.box-body -->
                </div>
                    <!-- /.box -->
            </div>
                <!-- /.col -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>


    <script>
        $(document).ready(function () {
            $('#project-list').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
            });
        });
    </script>
@endsection