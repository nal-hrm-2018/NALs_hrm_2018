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
                                    <th>Name PO</th>
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
                                                    <?php
                                                    $count = 0;
                                                    foreach ($employee->projects as $project){
                                                        if(sizeof($employee->projects)>0 && sizeof($employee->projects)<=3){
                                                            echo $project->name;
                                                            if($count < sizeof($employee->projects)-1) echo ', ';
                                                            $count++;
                                                        } else if(sizeof($employee->projects)>3){
                                                            echo $project->name;
                                                            if($count < 3) echo ', ';
                                                            if($count == 2){
                                                                $data = "";
                                                                foreach ($employee->projects as $project) $data .= '<p>' .$project->name .'</p>';
                                                                echo '<a href="javascript:void(0)" class="show-list-project"
                                                            id="show-list-project-'. $employee->id .'" data-content="'. $data .'">[...]</a>';
                                                                break;
                                                            }
                                                            $count++;
                                                        }
                                                    }
                                                    ?>
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
                    .css({top: event.pageY - 120, left: event.pageX - 250, 'z-index': 300});

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

            @foreach($member as $employee)
            $("#show-list-project-{{$employee->id}}").popover({title: "<strong>List Project</strong>", html: true,placement: "right"});
            @endforeach
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