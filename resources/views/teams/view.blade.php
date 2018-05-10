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
                Team Detail
                <small>Nal solution</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/teams')}}"> Teams</a></li>
                <li><a href="#">Detail</a></li>
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
                        <form method="get" role="form" id="form_search_process">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
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
                                                    <button type="button" class="btn width-100">Role</button>
                                                </div>
                                                <select name="role" id="role_employee" class="form-control">
                                                    @if(!empty($_GET['role']))
                                                        <option selected="selected" {{'hidden'}}  value="">
                                                            {{$_GET['role']}}
                                                        </option>
                                                    @else
                                                        <option selected="selected"
                                                                value="">
                                                            {{  trans('employee.drop_box.placeholder-default') }}
                                                            @endif
                                                        </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Doing Projects</button>
                                                </div>
                                                <input type="text" name="project" id="projectEmployee" class="form-control">
                                            </div>

                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Email</button>
                                                </div>
                                                <input type="text" name="email" id="emailEmployee" class="form-control">
                                            </div>

                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Phone</button>
                                                </div>
                                                <input type="text" name="phone" id="phoneEmployee"
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
                <?php
                $id = null; $name = null; $role = null; $project_name = null; $email = null; $phone = null;
                $arrays[] = $_GET;
                foreach ($arrays as $key => $value) {
                    if (!empty($value['id'])) {
                        $id = $value['id'];
                    }
                    if (!empty($value['name'])) {
                        $name = $value['name'];
                    }
                    if (!empty($value['project'])) {
                        $project_name = $value['project'];
                    }
                    if (!empty($value['role'])) {
                        $role = $value['role'];
                    }
                    if (!empty($value['email'])) {
                        $email = $value['email'];
                    }
                    if (!empty($value['mobile'])) {
                        $phone = $value['mobile'];
                    }
                }
                ?>
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
                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="employee-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Doing Projects</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>CV</th>
                                </tr>
                                </thead>
                              {{-- {{var_dump($member[3]->projects->toArray())}}--}}
                                <tbody class="context-menu">
                                @foreach($member as $employee)

                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td style="text-align: center" >{{ isset($employee->id)? $employee->id: "--.--" }}</td>
                                        <td>{{ isset($employee->name)? $employee->name: "--.--" }}</td>
                                        <td>{{ isset($employee->role)? $employee->role->name: "--.--" }}</td>

                                        <td>
                                                @if($employee->projects->isEmpty())
                                                    {{"--.--"}}
                                                @else
                                                    @foreach($employee->projects as $project)
                                                        <?php
                                                            if(isset($project->name)){
                                                                if(isset($employee->projects->last()->name)){
                                                                    echo $project->name;
                                                                } else {
                                                                    echo $project->name." , ";
                                                                }
                                                            }
                                                        ?>


                                                @endforeach
                                                @endif
                                        </td>
                                        <td>{{ isset($employee->email)? $employee->email: "--.--" }}</td>
                                        <td>{{ isset($employee->mobile)? $employee->mobile: "--.--" }}</td>
                                        <td style="text-align: center;width: 50px;">
                                            <button type="button" class="btn btn-default">
                                                <a href="#"><i class="fa fa-cloud-download"></i> CV</a>
                                            </button>
                                        </td>

                                        <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>

                                            <li><a href="{!! asset('employee/'.$employee->id)!!}"><i
                                                            class="fa fa-id-card"></i> View</a></li>
                                            <li><a href="{!! asset('employee/'.$employee->id.'/edit')!!}"><i class="fa fa-edit"></i>
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

            $('tr.employee-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                var eId = $(this).data('employee-id');
                $('ul.contextMenu[data-employee-id="' + eId + '"')
                    .show()
                    .css({top: event.pageY - 170, left: event.pageX - 250, 'z-index': 300});

            });
            $(document).click(function () {
                if ($('ul.contextMenu:hover').length === 0) {
                    $('ul.contextMenu').fadeOut("fast");
                }
            });
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
            var options = $("#select_length option");
            var select = $('#select_length');

            for (var i = 0; i < options.length; i++) {
                if (options[i].value === old) {
                    select.val(old).change();
                }
            }
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
                'autoWidth': false,
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#btn_reset").bind("click", function () {
                $("#role_employee").val([]);
                $("#role_employee")[0].selectedIndex = 0;
                $("#team_employee").val([]);
                $("#team_employee")[0].selectedIndex = 0;
            });
        });
    </script>
@endsection