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

            <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="col-xs-12">
                            <h2>Project ID: <strong>{{$project->id}}</strong></h2>
                            <p>Project Name:
                                <strong>{{$project->name}}</strong>
                            </p>
                            <p>Income:
                                <strong>{{$project->income}}</strong>
                            </p>

                            <p>Estimate Cost:
                                <strong>1000000</strong></p>
                            </p>

                            <p>Real Cost:
                                <strong>{{$project->real_cost}}</strong>
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
                                <strong>{{date('d/m/Y', strtotime($project->start_date))}}
                                    - {{date('d/m/Y', strtotime($project->end_date))}}</strong>
                            </p>

                            <p>Real Date:
                                <strong>{{date('d/m/Y', strtotime($project->start_date))}}
                                    - {{date('d/m/Y', strtotime($project->end_date))}}</strong>
                            </p>

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

                                    <tr class="project-menu" id="project-id-{{$project->id}}"
                                        data-project-id="{{$project->id}}">
                                        <td>{{ isset($employee->name)? $employee->name: "-" }}</td>
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
                                        <td>{{ isset($employee->email)? $employee->email: "-" }}</td>
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
                                                <a href="javascript:void(0)"><i class="fas fa-plus"></i> Input</a>
                                            </button>

                                            <button type="button" class="btn btn-default view-button">
                                                <a href="javascript:void(0)"><i class="fa fa-search-plus"></i> View</a>
                                            </button>
                                        </td>

                                        <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>

                                            <li><a href="{!! asset('employee/'.$employee->id)!!}"><i
                                                            class="fa fa-id-card"></i> View</a></li>
                                            <li><a href="{!! asset('employee/'.$employee->id.'/edit')!!}"><i
                                                            class="fa fa-edit"></i>
                                                    Edit</a></li>
                                        </ul>
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
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>

    <script>
        (function () {
            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_process').submit()
            });
        })();
    </script>

    <script type="text/javascript">
        $(function () {

            $('tr.project-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                $('ul.contextMenu[data-employee-id="' + <?php foreach ($member as $employee){
                    echo $employee->employee_id;}?> + '"')
                    .show()
                    .css({top: event.pageY - 120, left: event.pageX - 250, 'z-index': 300});

            });
            $(document).click(function () {
                if ($('ul.contextMenu:hover').length === 0) {
                    $('ul.contextMenu').fadeOut("fast");
                }
            });
        });

    </script>


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