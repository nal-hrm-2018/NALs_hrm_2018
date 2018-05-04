@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <h4 class="modal-title">{{  trans('common.title_header.employee_detail') }}</h4>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>
                <li><a href="{{asset('/employee')}}">{{trans('common.path.employee')}}</a></li>
                <li class="active">{{trans('common.path.detail')}}</li>
            </ol>


        </section>
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ 'basic'===$active?'active':'' }}">
                        <a href="#basic" data-toggle="tab">{{trans('employee.basic')}}</a>
                    </li>
                    <li class="{{ 'project'===$active?'active':'' }}">
                        <a href="#project" data-toggle="tab">{{trans('project.title')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="{{ 'basic'===$active?'active':'' }} tab-pane" id="basic">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img-circle"
                                             src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}"
                                             alt="User profile picture">

                                        <h3 class="profile-username text-center">{{$employee->name}}</h3>

                                        <p class="text-muted text-center">{{isset($employee->employeeType)?$employee->employeeType->name:'-'}}</p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="box box-primary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2 class="profile-username text-center">{{trans('employee.profile_info.title')}}</h2>
                                            <p>{{trans('employee.profile_info.name')}}: <strong>{{$employee->name}}</strong></p>
                                            <p>{{trans('employee.profile_info.email')}}: <strong>{{$employee->email}}</strong></p>
                                            <p>{{trans('employee.profile_info.gender.title')}}:
                                                @if($employee->gender == 1) <strong>{{trans('employee.profile_info.gender.male')}}</strong>
                                                @elseif($employee->gender == 2) <strong>{{trans('employee.profile_info.gender.female')}}</strong>
                                                @elseif($employee->gender == 3) <strong>{{trans('employee.profile_info.gender.na')}}</strong>
                                                @endif
                                            </p>
                                            <p>{{trans('employee.profile_info.birthday')}}: <strong>{{isset($employee->birthday)?date('d/m/Y', strtotime($employee->birthday)):'-'}}</strong></p>
                                            <p>{{trans('employee.profile_info.phone')}}: <strong>{{isset($employee->mobile)?$employee->mobile:'-'}}</strong></p>
                                            <p>{{trans('employee.profile_info.address')}}: <strong>{{isset($employee->address)?$employee->address:'-'}}</strong></p>
                                            <p>{{trans('employee.profile_info.marital_status.title')}}:
                                                @if($employee->marital_status == 1) <strong>{{trans('employee.profile_info.marital_status.single')}}</strong>
                                                @elseif($employee->marital_status == 2) <strong>{{trans('employee.profile_info.marital_status.married')}}</strong>
                                                @elseif($employee->marital_status == 3) <strong>{{trans('employee.profile_info.marital_status.separated')}}</strong>
                                                @elseif($employee->marital_status == 4) <strong>{{trans('employee.profile_info.marital_status.divorced')}}</strong>
                                                @endif
                                            </p>
                                            <p>{{trans('employee.profile_info.team')}}:
                                                <strong>{{ isset($employee->team)?$employee->team->name:'-' }}</strong>
                                            </p>
                                            <p>{{trans('employee.profile_info.role')}}:
                                                <strong>{{ isset($employee->employeeType)?$employee->employeeType->name:'-' }}</strong>
                                            </p>

                                            <p>{{trans('employee.profile_info.policy_date')}}:
                                                <strong>{{date('d/m/Y', strtotime($employee->startwork_date))}}
                                                    - {{date('d/m/Y', strtotime($employee->endwork_date))}}</strong></p>
                                            <p>{{trans('employee.profile_info.policy_status.title')}}:
                                                @if(strtotime($employee->endwork_date) >= strtotime(date('Y-m-d')))
                                                    <strong>{{trans('employee.profile_info.policy_status.unexpired')}}</strong>
                                                @else
                                                    <strong>{{trans('employee.profile_info.policy_status.expired')}}</strong>
                                                @endif
                                            </p>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                                <h2 class="profile-username text-center">{{trans('chart.resource_chart.title')}}</h2>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <select class="form-control" id="sel1" name="year">
                                                            @foreach($listYears as $year)
                                                                <option @if($year == $listValue[0]) selected
                                                                        @endif value="{{$year}}">{{trans('chart.resource_chart.title')}}
                                                                    - {{$year}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="box box-primary">
                                                        <div class="box-header with-border">
                                                            <i class="fa fa-bar-chart-o"></i>

                                                            <h3 class="box-title">{{trans('chart.resource_chart.title')}} - <span
                                                                        id="current-year">{{$listValue[0]}}</span></h3>

                                                            <div class="box-tools pull-right">
                                                                <button type="button" class="btn btn-box-tool"
                                                                        data-widget="collapse"><i
                                                                            class="fa fa-minus"></i>
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
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.post -->
                    </div>
                    <div class="{{ 'project'===$active?'active':'' }} tab-pane" id="project">
                        <div>
                            <button type="button" class="btn btn-info btn-default" data-toggle="modal"
                                    data-target="#myModal">
                                {{ trans('common.button.search')  }}
                            </button>

                            <!-- Modal -->
                            @include('employee._model_search_process')
                        </div>
                        <!-- The project -->

                        @include('employee._list_project_employee')
                        @if(isset($param))
                            {{  $processes->appends($param)->render() }}
                        @endif
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
            $('#project-list').DataTable({
                'paging': false,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
            $('#sel1').change(function () {
                var year = $('#sel1').val();
                var id = '{{$employee->id}}';
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
            });
            $(function () {
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
                yaxis:{
                    tickFormatter: function(val, axis) {
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
@endsection