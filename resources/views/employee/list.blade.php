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
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/employee')}}"> Employee</a></li>
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
                        <form method="get" role="form" id="form_search_employee">
                            <!-- Modal content-->
                            <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                   value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
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
                                                {{--<input type="text" name="name" id="nameEmployee" class="form-control">--}}
                                                {{ Form::text('name', old('name'),
                                                    ['class' => 'form-control',
                                                    'id' => 'nameEmployee',
                                                    'autofocus' => true,
                                                    ])
                                                }}
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Team</button>
                                                </div>
                                                <select name="team" id="team_employee" class="form-control">
                                                    {{--@if(!empty($_GET['team']))
                                                        <option selected="selected" {{'hidden'}}  value="">
                                                            {{$_GET['team']}}
                                                        </option>
                                                    @else
                                                        <option selected="selected" value="">
                                                        {{  trans('employee.drop_box.placeholder-default') }}
                                                    @endif--}}
                                                        <option {{ !empty(request('team'))?'':'selected="selected"' }} value="">
                                                            {{  trans('vendor.drop_box.placeholder-default') }}
                                                        </option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->name}}" {{ (string)$team->name===request('team')?'selected="selected"':'' }}>
                                                            {{ $team->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Email</button>
                                                </div>
                                                {{--<input type="text" name="email" id="emailEmployee" class="form-control">--}}
                                                {{ Form::text('email', old('email'),
                                                    ['class' => 'form-control',
                                                    'id' => 'emailEmployee',
                                                    'autofocus' => true,
                                                    ])
                                                }}
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Role</button>
                                                </div>
                                                <select name="role" id="role_employee" class="form-control">
                                                    {{--@if(!empty($_GET['role']))
                                                        <option selected="selected" {{'hidden'}}  value="">
                                                            {{$_GET['role']}}
                                                        </option>
                                                    @else
                                                        <option selected="selected"
                                                                value="">
                                                            {{  trans('employee.drop_box.placeholder-default') }}
                                                            @endif
                                                        </option>--}}
                                                    <option {{ !empty(request('role'))?'':'selected="selected"' }} value="">
                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                    </option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->name}}"{{ (string)$role->name===request('role')?'selected="selected"':'' }}>
                                                                {{ $role ->name}}
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                            class="btn width-100">{{trans('employee.profile_info.status')}}</button>
                                                </div>
                                                <select name="status" id="status" class="form-control">
                                                    <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">
                                                        {{  trans('employee.drop_box.placeholder-default') }}
                                                    </option>
                                                    @foreach($status as $key=>$value)
                                                        <option value="{{ $key }}" {{ (string)$key===request('status')?'selected="selected"':'' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer center">
                                    <button id="btn_reset_employee"  type="button" class="btn btn-default"><span class="fa fa-refresh"></span>
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
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#import">
                    <a><i class="fa fa-users"></i> IMPORT</a>
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
                                                <button type="button" class="btn width-100">Select file csv</button>
                                            </div>
                                            <input type="file" id="myfile" name="myFile" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer center">
                                    <button type="submit" id="searchListEmployee" id="i_submit" class="btn btn-primary"><span
                                                class="glyphicon glyphicon-upload"></span>
                                        IMPORT
                                    </button>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $('#myfile').bind('change', function() {
                                if(this.files[0].size > 5242880){
                                    alert("The selected file is too large. Maximum size is 5MB.");
                                    document.getElementById('myfile').value = "";
                                }    
                            });
                        </script>
                    </div>
                </div>

                <button type="button" class="btn btn-default" onclick="return confirmAction('{{trans('employee.msg_content.msg_download_employee_template')}}')">
                    <a href="/download-template"><i class="fa fa-cloud-download"></i> TEMPLATE</a>
                </button>
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
                <SCRIPT LANGUAGE="JavaScript">
                    function confirmExport(msg) {
                        $check = confirm(msg);
                        if($check == true){
                            $(document).ready(function (){
                                var ctx = document.getElementById('my_canvas').getContext('2d');
                                var al = 0;
                                var start = 4.72;
                                var cw = ctx.canvas.width;
                                var ch = ctx.canvas.height;
                                var diff;
                                function runTime() {
                                    diff = ((al / 100) * Math.PI*0.2*10).toFixed(2);
                                    ctx.clearRect(0, 0, cw, ch);
                                    ctx.lineWidth = 3;
                                    ctx.fillStyle = '#09F';
                                    ctx.strokeStyle = "#09F";
                                    ctx.textAlign = 'center';
                                    ctx.beginPath();
                                    ctx.arc(10, 10, 5, start, diff/1+start, false);
                                    ctx.stroke();
                                    if (al >= 100) {
                                        clearTimeout(sim);
                                        sim = null;
                                        al=0;
                                        $("#contain-canvas").css("visibility","hidden")
                                        // Add scripting here that will run when progress completes
                                    }
                                    al++;
                                }
                                var sim = null;
                                    $("i.fa fa-vcard").css("visibility","hidden")
                                    $("#contain-canvas").css("visibility","visible")
                                    sim = setInterval(runTime, 15 );

                            });
                        }
                        return $check;
                    }
                </SCRIPT>
                <button  type="button" class="btn btn-default export-employee" id="click-here" onclick="return confirmExport('{{trans('employee.msg_content.msg_download_employee_list')}}')">
                    <a id="export"
                       href="{{asset('export').'?'.'id='.$id.'&name='.$name.'&team='.$team.'&email='.$email.'&role='.$role.'&email='.$email.'&status='.$status}}">
                        <i class="fa fa-vcard"></i>
                        <span id="contain-canvas" style="">
                            <canvas id="my_canvas" width="16" height="16" style=""></canvas>
                        </span>
                        EXPORT</a>
                </button>
            </ol>
        </section>

            <div id="msg">
            </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <div class="dataTables_length" id="project-list_length" style="float:right">
                                    <label>{{trans('pagination.show.number_record_per_page')}}
                                        {!! Form::select(
                                            'select_length',
                                            getArraySelectOption() ,
                                            null ,
                                            [
                                            'id'=>'select_length',
                                            'class' => 'form-control input-sm',
                                            'aria-controls'=>"project-list"
                                            ]
                                            )
                                         !!}
                                    </label>
                                </div>
                            </div>

                            <script>
                                (function () {
                                    $('#select_length').change(function () {
                                        $("#number_record_per_page").val($(this).val());
                                        $('#form_search_employee').submit()
                                    });
                                })();

                            </script>
                            <table id="employee-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="small-row-id text-center">Employee ID</th>
                                    <th>Name</th>
                                    <th>Team</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>CV</th>
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($employees as $employee)
                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td  class="text-center"><p class="fix-center-employee">{{ isset($employee->id )? $employee->id : "-"}}</p></td>
                                        <td><p class="fix-center-employee">{{ isset($employee->name)? $employee->name: "-" }}</p></td>
                                        <td><p class="fix-center-employee">{{ isset($employee->team)? $employee->team->name: "-"}}</p></td>
                                        <td><p class="fix-center-employee">
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
                                            </p></td>
                                        <td><p class="fix-center-employee">{{ isset($employee->email)? $employee->email: "-" }}</p></td>
                                        <td><p class="fix-center-employee">
                                                @if(strtotime($employee->endwork_date) >= strtotime(date('Y-m-d')))
                                                    <span class="label label-primary">{{trans('employee.profile_info.policy_status.unexpired')}}</span>
                                                @else
                                                    <span class="label label-danger">{{trans('employee.profile_info.policy_status.expired')}}</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td style="text-align: center;width: 50px;">
                                            <button type="button" class="btn btn-default cv-button">
                                                <a href="javascript:void(0)"><i class="fa fa-cloud-download"></i> CV</a>
                                            </button>
                                        </td>

                                        <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>

                                            <li><a href="employee/{{$employee->id}}"><i
                                                            class="fa fa-id-card"></i> View</a></li>
                                            <li><a href="employee/{{$employee->id}}/edit"><i class="fa fa-edit"></i>
                                                    Edit</a></li>
                                            <li><a class="btn-employee-remove" data-employee-id="{{$employee->id}}" data-employee-name="{{$employee->name}}"><i
                                                            class="fa fa-remove"></i> Remove</a></li>
                                        </ul>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if(isset($param))
                                {{  $employees->appends($param)->render('vendor.pagination.custom') }}
                            @endif
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
        $(function () {
            $('.btn-employee-remove').click(function () {
                var elementRemove = $(this).data('employee-id');
                var nameRemove = $(this).data('employee-name');
                console.log(elementRemove);
                if (confirm('Do you want to delete employee "'+ nameRemove +'"?')) {
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
                            $('ul.contextMenu[data-employee-id="' + msg.id + '"').hide()
                            var fadeElement = $('#' + fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
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
                'borderCollapse':'collapse'
            });
//            $('#employee-list').css(borderCollapse, collapse);
        });
    </script>
    {{--<script type="text/javascript">
        document.getElementById("employee-list").style.borderCollapse = "collapse";
    </script>--}}
    <script type="text/javascript">
        $(function () {
            $("#btn_reset_employee").on("click", function () {
                $("#nameEmployee").val('');
                $("#employeeId").val('');
                $("#emailEmployee").val('');
                $("#role_employee").val('').change();
                $("#team_employee").val('').change();
                $("#status").val('').change();
            });
        });
    </script>
    {{--<script type="text/javascript">
        $(document).ready(function (){
            var ctx = document.getElementById('my_canvas').getContext('2d');
            var al = 0;
            var start = 4.72;
            var cw = ctx.canvas.width;
            var ch = ctx.canvas.height;
            var diff;
            function runTime() {
                diff = ((al / 100) * Math.PI*0.2*10).toFixed(2);
                ctx.clearRect(0, 0, cw, ch);
                ctx.lineWidth = 3;
                ctx.fillStyle = '#09F';
                ctx.strokeStyle = "#09F";
                ctx.textAlign = 'center';
//                ctx.fillText(al+'%', cw*.5, ch*.5+2, cw);
                ctx.beginPath();
                ctx.arc(10, 10, 5, start, diff/1+start, false);
                ctx.stroke();
                if (al >= 100) {
                    clearTimeout(sim);
                    sim = null;
                    al=0;
                    $("#contain-canvas").css("visibility","hidden")
                    // Add scripting here that will run when progress completes
                }
                al++;
            }
            var sim = null;
            $("#click-here").click(function () {
                $("i.fa fa-vcard").css("visibility","hidden")
                $("#contain-canvas").css("visibility","visible")
                sim = setInterval(runTime, 15 );
            });
        });

    </script>--}}
    <style>
        #contain-canvas{
            visibility:hidden;
        }
        span#contain-canvas{
            position: relative;
            left: 27px;
            margin-left: -20px;
        }
    </style>
@endsection