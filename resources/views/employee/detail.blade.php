@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Employee Profile
            </h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">User profile</li>
            </ol>


        </section>
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#basic" data-toggle="tab">Basic</a></li>
                    <li><a href="#project" data-toggle="tab">Project</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="basic">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img-circle"
                                             src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}"
                                             alt="User profile picture">

                                        <h3 class="profile-username text-center">{{$employee->name}}</h3>

                                        <p class="text-muted text-center">{{isset($employee->employeeType)?$employee->employeeType->name:''}}</p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="box box-primary">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="profile-username text-center">Profile Info</h2>
                                    <p>Name: <strong>{{$employee->name}}</strong></p>
                                    <p>Email: <strong>{{$employee->email}}</strong></p>
                                    <p>Address: <strong>{{$employee->address}}</strong></p>
                                    <p>Phone: <strong>{{$employee->mobile}}</strong></p>
                                    <p>Gender:
                                            @if($employee->gender == 1) <strong>Female</strong>
                                            @elseif($employee->gender == 2) <strong>Female</strong>
                                            @elseif($employee->gender == 3) <strong>N/A</strong>
                                            @endif
                                    </p>
                                    <p>Status: <strong>{{$employee->marital_status}}</strong></p>
                                    <p>Team: <strong>{{$employee->team->name}}</strong></p>
                                    <p>Role: <strong>{{$employee->employeeType->name}}</strong></p>
                                    <p>Birthday: <strong>{{date('d/m/Y', strtotime($employee->birthday))}}</strong></p>
                                    <p>Policy Date: <strong>{{date('d/m/Y', strtotime($employee->startwork_date))}} - {{date('d/m/Y', strtotime($employee->endwork_date))}}</strong></p>
                                </div>
                                <div class="col-md-6">
                                <div class="row">
                                    {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                    <h2 class="profile-username text-center">Project Info</h2>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {{--<label for="sel1">Select Chart:</label>--}}
                                            <select class="form-control" id="sel1">
                                                <option>Resource Chart - 2018</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                                                <h2 class="profile-username text-center">Project Info</h2>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        {{--<label for="sel1">Select Chart:</label>--}}
                                                        <select class="form-control" id="sel1">
                                                            <option>Resource Chart - 2018</option>
                                                        </select>
                                                    </div>
                                                    <div class="box box-primary">
                                                        <div class="box-header with-border">
                                                            <i class="fa fa-bar-chart-o"></i>

                                                            <h3 class="box-title">Resource Chart - 2018</h3>

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
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="project">
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

                    <!-- /.tab-pane -->


                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </section>
        <!-- Main content -->
        <section class="content">


            <!-- /.row -->

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
    <script type="text/javascript">
        $(function () {
            var bar_data = {
                data: [['Jan', 10], ['Feb', 8], ['Mar', 4], ['Apr', 13], ['May', 17], ['Jun', 9], ['Aug', 9], ['Sept', 2], ['Oct', 4], ['Nov', 5], ['Dec', 9]],
                color: '#3c8dbc'
            }
            $.plot('#bar-chart', [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor: '#f3f3f3'
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
                }
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            $('#project-list').DataTable({
                "bLengthChange": true,
                'paging': false,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': true
            });
        });
    </script>
@endsection