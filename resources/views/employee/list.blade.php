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
                        <form action="{{asset('search')}}" method="get" role="form">
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
                                    <button type="submit" id="searchListEmployee" class="btn btn-primary"><span class="fa fa-search"></span>
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
                    <a href="#"><i class="fa fa-users"></i> IMPORT</a>
                </button> -->
                <div class="nav navbar-nav">
                  <div class="dropdown user user-menu">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <a href="#" ><i class="fa fa-users"></i> IMPORT</a>
                    </button>
                    <div class="dropdown-menu">
                      <!-- User image -->
                      <div class="user-header">
                            <!-- <form action="{{ asset('employee/import_csv')}}" method="post">
                                
                            </form> -->
                            {!! Form::open(array('route'=>'import_csv', 'method'=>'POST', 'files'=>'true')) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="file" name="csv_file">
                                <br/>
                                <input type="submit" value="Import Data">
                            {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-default">
                    <a href="#"><i class="fa fa-vcard"></i> EXPORT</a>
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
                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}" data-employee-id="{{$employee->id}}">
                                        <td>{{$employee->id}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->team->name}}</td>
                                        <td>{{$employee->role->name}}</td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->work_status}}</td>
                                        <td>
                                            <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>
                                                <li><a href="employee/{{$employee->id}}"><i class="fa fa-id-card"></i> View</a></li>
                                                <li><a href="employee/{{$employee->id}}/edit"><i class="fa fa-edit"></i>
                                                        Edit</a></li>
                                                <li class="btn-employee-remove" data-employee-id="{{$employee->id}}"><i class="fa fa-remove"></i> Remove</li>
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
                var eId = $(this).data('employee-id');
                $('ul.contextMenu[data-employee-id="'+eId+'"')
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
    <script>
        $(document).ready(function () {
            $('#employee-list').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
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
                            alert("Remove "+msg.status);
                            var fade = "employee-id-"+msg.id;
                            var fadeElement = $('#'+fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
                }
            });
        });
    </script>
    }
@endsection