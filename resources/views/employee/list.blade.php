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
                Employee List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Employee</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>

        <section class="content-header">
            <div>
                <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal">
                    SEARCH
                </button>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <form method="get" role="form">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Search form</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Employee ID</button>
                                                </div>
                                                <input type="text" name="id" id="employeeId" class="form-control">
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Name</button>
                                                </div>
                                                <input type="text" name="name" id="nameEmployee" class="form-control">
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Team</button>
                                                </div>
                                                <input type="text" name="team" id="teamEmployee" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Email</button>
                                                </div>
                                                <input type="text" name="email" id="emailEmployee" class="form-control">
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Role</button>
                                                </div>
                                                <input type="text" name="role" id="roleEmployee" class="form-control">
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Status</button>
                                                </div>
                                                <input type="text" name="status" id="statusEmployee"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer center">
                                    <button type="reset" class="btn btn-default"><span class="fa fa-refresh"></span>
                                        RESET
                                    </button>
                                    <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                                class="fa fa-search"></span>
                                        SEARCH
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <ol class="breadcrumb">
                <button type="button" class="btn btn-default">
                    <a href="{{ asset('employee/create')}}"><i class="fa fa-user-plus"></i> ADD</a>
                </button>
                <!-- <button type="button" class="btn btn-default">
                    <a href="{{ asset('employee/importEmployee')}}" ><i class="fa fa-users"></i> IMPORT</a>          
                </button> -->
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#import">
                    <a href="#" ><i class="fa fa-users"></i> IMPORT</a>
                </button>
                <div id="import" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <form method="post" action="{{ asset('employee/postFile')}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">IMPORT EMPLOYEE</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="input-group margin">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn width-100">Chon file csv</button>
                                            </div>
                                            <input type="file" name="myFile" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer center">
                                    <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                                class="fa fa-search"></span>
                                        IMPORT
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                $id = null; $name = null; $team = null; $role = null; $email = null; $status = null;
                $arrays[] = $_GET;
                foreach ($arrays as $key => $value) {
                    if (!empty($value['id'])) {
                        $id = $value['id'];
                    }
                    if (!empty($value['name'])) {
                        $name = $value['name'];
                    }
                    if (!empty($value['team'])) {
                        $team = $value['team'];
                    }
                    if (!empty($value['role'])) {
                        $role = $value['role'];
                    }
                    if (!empty($value['email'])) {
                        $email = $value['email'];
                    }
                    if (!empty($value['status'])) {
                        $status = $value['status'];
                    }
                }
                ?>
                <button type="button" class="btn btn-default export-employee">
                    <a href="{{asset('export').'?'.'id='.$id.'&team='.$team.'&email='.$email.'&role='.$role.'&email='.$email.'&status='.$status}}">
                        <i class="fa fa-vcard"></i> EXPORT</a>
                </button>
            </ol>
        </section>

        <!-- Main content -->
        <?php
        if (Session::has('msg_fail')) {
            echo '<div>
                <ul class=\'error_msg\'>
                    <li>' . Session::get("msg_fail") . '</li>
                </ul>
            </div>';
        }
        ?>
        <?php
        if (Session::has('msg_success')) {
            echo '<div>
                <ul class=\'result_msg\'>
                    <li>' . Session::get("msg_success") . '</li>
                </ul>
            </div>';
        }
        ?>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="employee-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Team</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($employees as $employee)
                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ isset($employee->team)? $employee->team->name: ""}}</td>
                                        <td>{{ isset($employee->team)? $employee->role->name: "" }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            @if($employee->work_status == 0) Action
                                            @elseif($employee->work_status == 1) Out
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>
                                                <li><a href="employee/view/{{$employee->id}}"><i
                                                                class="fa fa-id-card"></i> View</a></li>
                                                <li><a href="employee/{{$employee->id}}/edit"><i class="fa fa-edit"></i>
                                                        Edit</a></li>
                                                <li><a class="btn-employee-remove" data-employee-id="{{$employee->id}}"><i
                                                                class="fa fa-remove"></i> Remove</a></li>
                                            </ul>
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
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>

    <script type="text/javascript">
        $(function () {

            $('tr.employee-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                var eId = $(this).data('employee-id');
                $('ul.contextMenu[data-employee-id="' + eId + '"')
                    .show()
                    .css({top: event.pageY - 150, left: event.pageX - 250, 'z-index': 300});

            });
            $(document).click(function () {
                if ($('ul.contextMenu:hover').length === 0) {
                    $('ul.contextMenu').fadeOut("fast");
                }
            });
        });

    </script>
    <script type="text/javascript">
        $(function () {
            $('.btn-employee-remove').click(function () {
                var elementRemove = $(this).data('employee-id');
                console.log(elementRemove);
                if (confirm('Really delete?')) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/employee') }}' + '/' + elementRemove,
                        data: {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            "id": elementRemove,
                            '_method': 'DELETE',
                            _token: '{{csrf_token()}}',
                        },
                        success: function (msg) {
                            alert("Remove " + msg.status);
                            var fade = "employee-id-" + msg.id;
                            var fadeElement = $('#' + fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
                }
            });
        });
    </script>


    {{--<script type="text/javascript">
        $(function () {
            $('.btn.btn-default.export-employee').click(function () {
                var url = $(this).data('employee-id');
                if (confirm('Are you want to export file csv?')) {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('/export') }}',
                        dataType: 'JSON',
                        data: {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            'url': url,
                            '_method': 'GET',
                            _token: '{{csrf_token()}}',
                        },
                        success: function (msg) {
                            alert("OK "+msg.url);
                            console.log(msg.status);
                        },
                        error: function (error) {
                            alert(error);
                        }
                    });
                }
            });
        });
    </script>--}}
    {{--<script>
        $(document).ready(function () {
            $('#employee-list').DataTable({
                "scrollY" : 800,
                "scrollX" : true,
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                "columns": [
                    {"orderDataType": "dom-text-numeric"},
                    {"orderDataType": "dom-text-numeric"},
                    {"orderDataType": "dom-text-numeric"},
                    {"orderDataType": "dom-text-numeric"},
                    {"orderDataType": "dom-text-numeric"},
                    {"orderDataType": "dom-text-numeric"}
                ]
            });
        });
    </script>--}}
@endsection