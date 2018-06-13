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

        <!-- Main content -->
      <div id="msg"></div>

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
                                    <th>PO Name</th>
                                    <th>Role</th>
                                    <th>Doing Projects</th>
                                    <th>Email</th>
                                    <th class="text-center">Phone</th>
                                </tr>
                                </thead>
                                {{-- {{var_dump($member[3]->projects->toArray())}}--}}
                                <tbody class="context-menu">
                                @foreach($member as $employee)

                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td style="text-align: center">{{ isset($employee->id)? $employee->id: "-" }}</td>
                                        <td>{{ isset($employee->name)? $employee->name: "-" }}</td>
                                        <td>
                                            <?php
                                            if(isset($employee->role)){
                                                if($employee->role->name == "PO"){
                                                    echo "<span class='label label-primary'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "Dev"){
                                                    echo "<span class='label label-success'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "BA"){
                                                    echo "<span class='label label-info'>". $employee->role->name ."</span>";
                                                } else if($employee->role->name == "ScrumMaster"){
                                                    echo "<span class='label label-warning'>". $employee->role->name ."</span>";
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            @if($employee->projects->isEmpty())
                                                {{"-"}}
                                            @else
                                                <?php
                                                $count = 0;
                                                foreach ($employee->projects as $project) {
                                                    if (sizeof($employee->projects) > 0 && sizeof($employee->projects) <= 3) {
                                                        echo $project->name;
                                                        if ($count < sizeof($employee->projects) - 1) echo ', ';
                                                        if($count == sizeof($employee->projects) - 1)
                                                            echo ' <a href="#" class="show-list-employee"
                                                            id="show-list-employee-' . $employee->id . '" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: black">[?]</a>';
                                                        $count++;
                                                    } else if (sizeof($employee->projects) > 3) {
                                                        echo $project->name;
                                                        if ($count < 3) echo ', ';
                                                        if ($count == 2) {
                                                            $data = "";
                                                            /*foreach ($employee->projects as $project) $data .= '<p>' .$project->name .'</p>';
                                                            echo '<a href="javascript:void(0)" class="show-list-project"
                                                        id="show-list-project-'. $employee->id .'" data-content="'. $data .'">[...]</a>';
                                                            break;*/
                                                            echo '<a href="#" class="show-list-employee"
                                                            id="show-list-employee-' . $employee->id . '" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: red">[...]</a>';
                                                            break;
                                                        }
                                                        $count++;
                                                    }
                                                }
                                                ?>
                                            @endif

                                        </td>
                                        <td>{{ isset($employee->email)? $employee->email: "-" }}</td>
                                        <td class="text-center">{{ isset($employee->mobile)? $employee->mobile: "-" }}</td>
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
                            <div id="show-list-members" class="modal fade" role="dialog">
                                <div class="modal-dialog" style="width: 400px">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">
                                                <th>Project Name Of: <span id="employee-name"></span></th>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <table id="member-list" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody class="context-menu"  id="table-list-members">
                                                <tr>

                                                </tr>
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
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
            });

            {{--@foreach($member as $employee)
            $("#show-list-project-{{$employee->id}}").popover({
                title: "<strong>List Project</strong>",
                html: true,
                placement: "right"
            });
            @endforeach--}}
        });
    </script>
    <script>
        $('.show-list-employee').click(function () {
            $('#table-list-members').html("");
            var id = $(this).attr('id');
            var id_team = id.slice(19);
            {{--            $('#table-list-members').append(html_{{$project->name}});--}}
            <?php
            $employeesModal = $member;
            foreach ($employeesModal as $employee) {
                foreach ($employee->projects as $project) {
                    if (isset($project->status)) {
                        if ($project->status->name === 'kick off') {
                            $classBtr = 'label label-primary';
                        } else if ($project->status->name === 'pending') {
                            $classBtr = 'label label-danger';
                        } else if ($project->status->name  === 'in-progress') {
                            $classBtr = 'label label-warning';
                        } else if ($project->status->name  == 'releasing') {
                            $classBtr = 'label label-info';
                        } else if ($project->status->name  == 'complete') {
                            $classBtr = 'label label-success';
                        } else if ($project->status->name  == 'planning') {
                            $classBtr = 'label label-default';
                        }
                        echo
                            ' var html_' . $project->id .
                            '= "<tr><td>'. $project->id .'</td><td>' . $project->name .
                            '</td><td><span class=\"'. $classBtr .'\">'. $project->status->name .'</span></td></tr>";';
                    } else {
                        echo
                            ' var html_' . $project->id .
                            '= "<tr><td>'. $project->id .'</td><td>' . $project->name .
                            '</td><td>-</td></tr>";';
                    }

                }
            }
            ?>
            @foreach($employeesModal as $employee)
            @foreach($employee->projects as $project)
            if(id_team == "{{$employee->id}}") {
                $('#employee-name').html('{{$employee->name}}');
            $('#table-list-members').append(html_{{$project->id}});
            }
            @endforeach
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