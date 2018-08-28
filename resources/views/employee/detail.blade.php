@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{  trans('common.title_header.employee_detail') }}
                <small>NAL Solutions</small>
            </h1>

            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a>--}}
                {{--</li>--}}
                {{--<li><a href="{{asset('/employee')}}">{{trans('common.path.employee')}}</a></li>--}}
                {{--<li class="active">{{trans('common.path.detail')}}</li>--}}
            {{--</ol>--}}

        </section>
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li style="margin:0 30px;" >
                        <a id="tab-basic" href="#basic" data-toggle="tab">{{trans('employee.basic')}}</a>
                    </li>
                    <li>
                        <a id="tab-project" href="#project" data-toggle="tab">{{trans('project.title')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="basic">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img style="width: 130px;height: 130px;" class="profile-user-img img-responsive img-circle"
                                             src="@if(isset($employee->avatar))
                                             {{asset('/avatar/'.$employee->avatar)}}
                                             @else
                                             {{asset('/avatar/default_avatar.png')}}
                                             @endif"
                                             alt="User profile picture" style="width: 150px; height: 150px;">

                                        <h3 class="profile-username text-center">{{$employee->name}}</h3>

                                        <p class="text-muted text-center">{{isset($employee->employeeType)?$employee->employeeType->name:'-'}}</p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-1"></div>
                            <div class="col-md-7">
                                <div class="box box-primary">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-left: 20px;">
                                            <h2 class="profile-username">{{trans('employee.profile_info.title')}}</h2>
                                            <p>{{trans('employee.profile_info.name')}}:
                                                <strong>{{$employee->name}}</strong></p>
                                            <p>{{trans('employee.profile_info.gender.title')}}:
                                                @if($employee->gender == 1)
                                                    <span class="label label-info">{{trans('employee.profile_info.gender.female')}}</span>
                                                @elseif($employee->gender == 2)
                                                    <span class="label label-success">{{trans('employee.profile_info.gender.male')}}</span>
                                                @elseif($employee->gender == 3)
                                                    <span class="label label-warning">{{trans('employee.profile_info.gender.na')}}</span>
                                                @endif
                                            </p>
                                            <p>{{trans('employee.profile_info.birthday')}}:
                                                <strong>{{isset($employee->birthday)?date('d/m/Y', strtotime($employee->birthday)):'-'}}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.email')}}:
                                                <strong>{{$employee->email}}</strong></p>


                                            <p>{{trans('employee.profile_info.phone')}}:
                                                <strong>{{isset($employee->mobile)?$employee->mobile:'-'}}</strong></p>
                                            <p>{{trans('employee.profile_info.address')}}:
                                                <strong>{{isset($employee->address)?$employee->address:'-'}}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.marital_status.title')}}:
                                                @if($employee->marital_status == 1)
                                                    <span class="label label-default">{{trans('employee.profile_info.marital_status.single')}}</span>
                                                @elseif($employee->marital_status == 2)
                                                    <span class="label label-primary">{{trans('employee.profile_info.marital_status.married')}}</span>
                                                @elseif($employee->marital_status == 3)
                                                    <span class="label label-warning">{{trans('employee.profile_info.marital_status.separated')}}</span>
                                                @elseif($employee->marital_status == 4)
                                                    <span class="label label-danger">{{trans('employee.profile_info.marital_status.divorced')}}</span>
                                                @endif
                                            </p>
                                            @php
                                                $arr_team = $employee->teams()->get();
                                                $string_team ="";
                                                foreach ($arr_team as $team){
                                                  $addteam=  (string)$team->name;
                                                  if ($string_team){
                                                  $string_team = $string_team.", ".$addteam;
                                                  } else{
                                                  $string_team = $string_team."".$addteam;
                                                  }
                                                }
                                            @endphp
                                            <p>{{trans('employee.profile_info.team')}}:
                                                <strong>{{ isset($string_team)?$string_team:'-' }}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.role')}}:
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
                                            </p>

                                            <p>{{trans('employee.profile_info.policy_date')}}:
                                                <strong>{{date('d/m/Y', strtotime($employee->startwork_date))}}
                                                    - {{date('d/m/Y', strtotime($employee->endwork_date))}}</strong></p>
                                            <p>{{trans('employee.profile_info.policy_status.title')}}:
                                                @if($employee->work_status == 0)
                                                    @if(strtotime($employee->endwork_date) >= strtotime(date('Y-m-d')))
                                                        <span class="label label-primary">{{trans('employee.profile_info.status_active')}}</span>
                                                    @else
                                                        <span class="label label-danger">{{trans('employee.profile_info.status_expired')}}</span>
                                                    @endif
                                                @else
                                                    <span class="label label-default">{{trans('employee.profile_info.status_quited')}}</span>
                                                @endif
                                            </p>

                                            <p>{{trans('employee.profile_info.the_rest_absence')}}:
                                                <strong> {{$rest_absence}}</strong></p>

                                        </div>
                                        {{--<div class="col-md-6">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                                {{--<h2 class="profile-username text-center">{{trans('chart.resource_chart.title')}}</h2>--}}
                                                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                                                    {{--<div class="row">--}}
                                                        {{--<div class="col-md-3"></div>--}}
                                                        {{--<div class="form-group col-md-6">--}}
                                                            {{--<select class="form-control" id="sel1" name="year">--}}
                                                                {{--@foreach($listYears as $year)--}}
                                                                    {{--<option @if($year == $listValue[0]) selected--}}
                                                                            {{--@endif value="{{$year}}">{{trans('employee.profile_info.year')}}: {{$year}}</option>--}}
                                                                {{--@endforeach--}}
                                                            {{--</select>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--<div class="box box-primary">--}}
                                                        {{--<div class="box-header with-border">--}}
                                                            {{--<i class="fa fa-bar-chart-o"></i>--}}

                                                            {{--<h3 class="box-title">{{trans('chart.resource_chart.title')}}--}}
                                                                {{--- <span--}}
                                                                        {{--id="current-year">{{$listValue[0]}}</span></h3>--}}

                                                            {{--<div class="box-tools pull-right">--}}
                                                                {{--<button type="button" class="btn btn-box-tool"--}}
                                                                        {{--data-widget="collapse"><i--}}
                                                                            {{--class="fa fa-minus"></i>--}}
                                                                {{--</button>--}}
                                                                {{--<button type="button" class="btn btn-box-tool"--}}
                                                                        {{--data-widget="remove"><i class="fa fa-times"></i>--}}
                                                                {{--</button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="box-body">--}}
                                                            {{--<div id="bar-chart" style="height: 235px;">--}}
                                                                {{--<img width="100%" src="{!! asset('admin/templates/images/temporary/chart.png') !!}">--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<!-- /.box-body-->--}}
                                                    {{--</div>--}}
                                                    {{--<!-- /.box -->--}}

                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <!-- /.col -->
                        </div>
                            <div class="col-md-1"></div>
                        <!-- /.post -->
                    </div>
                    <div class="tab-pane" id="project">
                        
                        <!-- The project -->

                        @include('employee._list_project_employee')

                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- Main content -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery 3 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script>
        $(document).ready(function () {
            function sendRequestAjax(id, year) {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/employee') }}' + '/' + id,
                    data: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'id': id,
                        'year': year,
                        '_method': 'POST',
                        _token: '{{csrf_token()}}',
                    },
                    success: function (msg) {
                        var bar_data = {
                            data: [["{{trans('chart.resource_chart.jan')}}", msg.listValue[1]], ["{{trans('chart.resource_chart.feb')}}", msg.listValue[2]],
                                ["{{trans('chart.resource_chart.mar')}}", msg.listValue[3]], ["{{trans('chart.resource_chart.apr')}}", msg.listValue[4]],
                                ["{{trans('chart.resource_chart.may')}}", msg.listValue[5]], ["{{trans('chart.resource_chart.jun')}}", msg.listValue[6]],
                                ["{{trans('chart.resource_chart.jul')}}", msg.listValue[7]], ["{{trans('chart.resource_chart.aug')}}", msg.listValue[8]],
                                ["{{trans('chart.resource_chart.sep')}}", msg.listValue[9]], ["{{trans('chart.resource_chart.oct')}}", msg.listValue[10]],
                                ["{{trans('chart.resource_chart.nov')}}", msg.listValue[11]], ["{{trans('chart.resource_chart.dec')}}", msg.listValue[12]]],
                            color: '#3c8dbc'
                        }
                        $('#current-year').html(msg.listValue[0]);
                        showChart(bar_data);
                    }
                });
            }

            $('#sel1').change(function () {
                var year = $('#sel1').val();
                var id = '{{$employee->id}}';
                sendRequestAjax(id, year);
            });


            $(function () {
                $("#tab-basic").bind("click", function () {
                    activaTab('basic');
                    var year = $('#sel1').val();
                    var id = '{{$employee->id}}';
                    sendRequestAjax(id, year);
                });
            });

            if ('project' === "{{$active}}") {
                activaTab('project');
            } else {
                $(function () {
                    activaTab('basic');
                    var bar_data = {
                        data: [["{{trans('chart.resource_chart.jan')}}", {{$listValue[1]}}], ["{{trans('chart.resource_chart.feb')}}", {{$listValue[2]}}],
                            ["{{trans('chart.resource_chart.mar')}}", {{$listValue[3]}}], ["{{trans('chart.resource_chart.apr')}}", {{$listValue[4]}}],
                            ["{{trans('chart.resource_chart.may')}}", {{$listValue[5]}}], ["{{trans('chart.resource_chart.jun')}}", {{$listValue[6]}}],
                            ["{{trans('chart.resource_chart.jul')}}", {{$listValue[7]}}], ["{{trans('chart.resource_chart.aug')}}", {{$listValue[8]}}],
                            ["{{trans('chart.resource_chart.sep')}}", {{$listValue[9]}}], ["{{trans('chart.resource_chart.oct')}}", {{$listValue[10]}}],
                            ["{{trans('chart.resource_chart.nov')}}", {{$listValue[11]}}], ["{{trans('chart.resource_chart.dec')}}", {{$listValue[12]}}]],
                        color: '#3c8dbc'
                    }
                    showChart(bar_data);

                });
            }

            function activaTab(tab) {
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            };
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
                        barWidth: 0.75,
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
        $('#btn-search').click(function () {
            $('#form_search_process').trigger("reset");
        });
    </script>
@endsection