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
                {{trans('team.title')}}
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a>
                </li>
                <li><a href="{{asset('/teams')}}"> {{trans('common.path.team')}}</a></li>
                <li><a href="#">{{trans('common.path.list')}}</a></li>
            </ol>
        </section>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-info btn-default">
                    <a href="{{ asset('teams/create')}}"><i class="fa fa-user-plus"></i>{{trans('common.button.add')}}
                    </a>
                </button>
            </div>
        </section>
        <!-- Main content -->
        <div id="msg"></div>
    <!-- Main content -->

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="team-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">{{trans('team.id')}}</th>
                                    <th>{{trans('team.name')}}</th>
                                    <th>{{trans('team.po')}}</th>
                                    <th>{{trans('team.members')}}</th>
                                    <th class="text-center">{{trans('team.number_of_member')}}</th>
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($teams as $team)
                                    <?php
                                        $po = $team->employees->where('is_manager', '1')->first();
                                        $employees = $team->employees->where('is_manager', '<>',  '1');
                                    ?>
                                    <tr class="team-menu" id="team-id-{{$team->id}}"
                                        data-team-id="{{$team->id}}">
                                        <td class="text-center" >{{$team->id}}</td>
                                        <td>{{$team->name}}</td>
                                        <td>
                                            @if(isset($po))
                                                <a href="employee/{{$po->id}}">{{$po->name}} </a>
                                                @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                                $count = 0;
                                                if(count($employees) > 0){
                                                    foreach ($employees as $employee){
                                                        if(sizeof($employees)>0 && sizeof($employees)<=3){
                                                            echo '<a href="employee/'. $employee->id .'">'. $employee->name .'</a>';
                                                            if($count < sizeof($employees)-1) echo ', ';
                                                            if($count == sizeof($employees)-1)
                                                                echo ' <a href="#" class="show-list-employee"
                                                            id="show-list-employee-'. $team->id .'" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: black">[?]</a>';
                                                            $count++;
                                                        } else if(sizeof($employees)>3){
                                                            echo '<a href="employee/'. $employee->id .'">'. $employee->name .'</a>';
                                                            if($count <= 3) echo ', ';
                                                            if($count == 2){
                                                                echo '<a href="#" class="show-list-employee"
                                                            id="show-list-employee-'. $team->id .'" data-toggle="modal"
                                                            data-target="#show-list-members" style="color: red">[...]</a>';
                                                                break;
                                                            }
                                                            $count++;
                                                        } else {
                                                            echo '-';
                                                        }
                                                    }
                                                } else{
                                                    echo "-";
                                                }

                                            ?>
                                        </td>
                                        <td class="text-center"><span class="badge">{{isset($po)?(sizeof($employees) + 1):sizeof($employees)}}</span></td>

                                        <ul class="contextMenu" data-team-id="{{$team->id}}" hidden>
                                            <li><a href="teams/{{$team->id}}"><i
                                                            class="fa fa-id-card"></i> {{trans('common.action.view')}}
                                                </a></li>
                                            <li><a href="teams/{{$team->id}}/edit"><i class="fa fa-edit"></i>
                                                    {{trans('common.action.edit')}}</a></li>
                                            <li><a class="btn-team-remove" data-team-id="{{$team->id}}" data-team-name="{{$team->name}}"><i
                                                            class="fa fa-remove"></i> {{trans('common.action.remove')}}
                                                </a></li>
                                        </ul>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div id="show-list-members" class="modal fade" role="dialog">
                                <div class="modal-dialog" style="width: 400px">
                                    <!-- Modal content-->
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><th>{{trans('team.members')}} - Team: <span id="team_name_modal"></span></th></h4>
                                        </div>
                                        <div class="modal-body">
                                            <table id="member-list" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>{{trans('employee.profile_info.id')}}</th>
                                                    <th>{{trans('employee.profile_info.long_name')}}</th>
                                                    <th>{{trans('employee.profile_info.role')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody class="context-menu" id="table-list-members">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="box-body">
                                    <div class="row">
                                        {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                        <h2 class="profile-username text-center">{{trans('chart.resource_chart.title')}}</h2>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select class="form-control" id="choose-month" name="month">
                                                            @foreach($listMonth as $month)
                                                                <option value="{{$month}}">{{date('m/Y',strtotime($month))}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-bar-chart-o"></i>

                                                    <h3 class="box-title">{{trans('chart.resource_chart.title')}}
                                                        -
                                                        <span id="current-month">{{date('m/Y',strtotime($listMonth[0]))}}</span>
                                                    </h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool"
                                                                data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-box-tool"
                                                                data-widget="remove"><i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="bar-chart" style="height: 235px;"></div>
                                                </div>
                                                <!-- /.box-body-->
                                            </div>
                                            <!-- /.box -->
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
        </section>
        <!-- /.content -->
    </div>


    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>


    <script type="text/javascript">
        $(function () {
            $('tr.team-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                var eId = $(this).data('team-id');
                $('ul.contextMenu[data-team-id="' + eId + '"')
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
        $(function () {
            $('.btn-team-remove').click(function () {
                var elementRemove = $(this).data('team-id');
                var nameRemove = $(this).data('team-name');
                console.log("element: " + elementRemove);
                if (confirm(message_confirm('delete', 'team', elementRemove, nameRemove))) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/teams') }}' + '/' + elementRemove,
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
                            var fade = "team-id-" + msg.id;
                            $('ul.contextMenu[data-team-id="' + msg.id + '"').hide();
                            var fadeElement = $('#' + fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
                }
            });
        });

        $('#choose-month').change(function () {
            var month = $('#choose-month').val();
            // var monthFormat = new Date(month);
            var arr = month.split("-", 2);
            $.ajax({
                type: "POST",
                url: '{{ url('/teams/chart') }}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "month": month,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    var data = [];
                    var i = 0;
                    var jsonValue = msg.listValueOfMonth;
                    Object.keys(jsonValue).forEach(function (key) {
                        data[i] = [];
                        data[i][0] = key;
                        data[i][1] = jsonValue[key];
                        i++;
                    });
                    var bar_data = {
                        data: data,
                        color: '#3c8dbc'
                    };
                    showChart(bar_data);
                }
            });
            $('#current-month').html(arr[1] + "/" + arr[0]);

        });

    </script>


    <script>
        $(document).ready(function () {
            $('#team-list').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
            });
            $(function () {
                var data = [];
                var i = 0;
                var jsonValue = <?php echo json_encode($teamsValue)?>;
                Object.keys(jsonValue).forEach(function (key) {
                    data[i] = [];
                    data[i][0] = key;
                    data[i][1] = jsonValue[key];
                    i++;
                });
                var bar_data = {
                    data: data,
                    color: '#3c8dbc'
                };
                showChart(bar_data);
            });
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
                        barWidth: 0.65,
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
        $('.show-list-employee').click(function () {
            $('#table-list-members').html("");
            var id = $(this).attr('id');
            var id_team = id.slice(19);
            <?php
                foreach($teams as $team){
                    $employeesModal = $team->employees->where('is_manager', '<>',  '1');
                    foreach($employeesModal as $employee){
                        if(isset($employee->role)){
                            $classBtr = '';
                            if($employee->role->name == 'PO'){
                                $classBtr = 'label label-primary';
                            } else if($employee->role->name == 'Dev'){
                                $classBtr = 'label label-success';
                            } else if($employee->role->name == 'BA'){
                                $classBtr = 'label label-info';
                            } else if($employee->role->name == 'ScrumMaster'){
                                $classBtr = 'label label-warning';
                            }
                            echo ' var html_'. $team->id . '_' . $employee->id .' = "<tr><td>'. $employee->id .'</td><td><a href=\"employee/'. $employee->id .'\">'. $employee->name .'</a></td><td><span class=\"'. $classBtr .'\">'. $employee->role->name .'</span></td></tr>";';
                        } else {
                            echo ' var html_'. $team->id . '_' . $employee->id .' = "<tr><td>'. $employee->id .'</td><td><a href=\"employee/'. $employee->id .'\">'. $employee->name .'</a></td><td>-</td></tr>";';
                        }
                    }
                }
                ?>
            @foreach($teams as $team)
                if(id_team == "{{$team->id}}"){
                    $('#team_name_modal').html('{{$team->name}}');
                    <?php
                        $employeesAppend = $team->employees->where('is_manager', '<>',  '1');
                    ?>
                    @foreach($employeesAppend as $employee)
                        $('#table-list-members').append(html_{{$team->id}}_{{$employee->id}});
                    @endforeach
                }
            @endforeach

        });
    </script>



@endsection
