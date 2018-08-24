<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:00 AM
 */ ?>
@extends('admin.template')
@section('content')
<style>
    .file-upload {
        width: 100%;
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        margin:0;
    }
    .file-upload:hover {
        background: white;
    }
</style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('common.path.list_employee')}}
                <small>Nal Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>--}}
                {{--<li><a href="{{asset('/employee')}}"> {{trans('common.path.employee')}}</a></li>--}}
                {{--<li><a href="#">{{trans('common.path.list')}}</a></li>--}}
            {{--</ol>--}}
        </section>
        <section class="content-header" style="display: flex;  flex-direction: row-reverse;">
            <div style="float:right; background-color: #ECF0F5; height: 50px;">
                <ol class="breadcrumb" style="background-color: #ECF0F5">
                    @if(Auth::user()->hasPermission('add_new_employee'))
                    <button type="button" class="btn btn-default">
                        <a href="{{ asset('employee/create')}}" style="color: darkviolet;"><i class="fa fa-user-plus"></i> {{trans('common.button.add')}}</a>
                    </button>
                    @endif
                    @if(Auth::user()->hasRoleHR())
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#import" id="btn-import">
                        <a style="color: darkviolet;"><i class="glyphicon glyphicon-import"></i> {{trans('common.button.import')}}</a>
                    </button>
                     @endif
                    <div id="import" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width: 50%">
                            <form method="post" action="{{ asset('employee/postFile')}}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">{{trans('employee.import_employee')}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-info width-100">{{trans('employee.select_csv_file')}}</button>
                                                </div>
                                                <label class="file-upload">
                                                    <input type="file" id="myfile" name="myFile" class="form-control" style="display: none;">
                                                    <i class="fa fa-cloud-upload"></i> Choose file
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer center">
                                        <button type="submit" id="i_submit" class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-upload"></span>
                                            {{trans('common.button.import')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <script type="text/javascript">
                                $('#myfile').bind('change', function(e) {
                                    if(this.files[0].size > 5242880){
                                        alert("{{trans('employee.valid5mb')}}");
                                        document.getElementById('myfile').value = "";
                                    }
                                    var value = $('#myfile')[0].files[0];
                                    if(value != null){
                                        $('#i_submit').removeClass('disabled');
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    @if(Auth::user()->hasRoleHR())
                    <button type="button" class="btn btn-default" onclick="return confirmAction('{{trans('employee.msg_content.msg_download_employee_template')}}')">
                        <a href="/download-template" style="color: darkviolet;"><i class="fa fa-cloud-download"></i> {{trans('common.button.template')}}</a>
                    </button>
                    @endif
                    <?php
                    $id = null; $name = null; $team = null; $role = null; $email = null; $statusExport = null; $page=1;
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
                            $statusExport = $value['status'];
                        }
                        if (!empty($value['page'])) {
                            $page = $value['page'];
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
                           style="color: darkviolet;"
                           href="{{asset('export').'?'.'id='.$id.'&name='.$name.'&team='.$team.'&email='.$email.'&role='.$role.'&email='.$email.'&status='.$statusExport.'&page='.$page}}">
                            <i class="glyphicon glyphicon-export"></i>
                            <span id="contain-canvas" style="">
                                <canvas id="my_canvas" width="16" height="16" style=""></canvas>
                            </span>
                            {{trans('common.button.export')}}</a>
                    </button>
                </ol>
            </div>
        </section>

            <div id="msg">
            </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                        <div class="box-body">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                                </button>
                                <div id="demo" class="collapse margin-form-search">
                                    <form method="get" role="form" id="form_search_employee">
                                        <!-- Modal content-->
                                        <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                               value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.id')}}</button>
                                                            </div>
                                                            {{ Form::text('id', old('id'),
                                                                ['class' => 'form-control',
                                                                'id' => 'employeeId',
                                                                'autofocus' => false,
                                                                ])
                                                            }}
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.name')}}</button>
                                                            </div>
                                                            {{--<input type="text" name="name" id="nameEmployee" class="form-control">--}}
                                                            {{ Form::text('name', old('name'),
                                                                ['class' => 'form-control',
                                                                'id' => 'nameEmployee',
                                                                'autofocus' => false,
                                                                ])
                                                            }}
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.team')}}</button>
                                                            </div>
                                                            <select name="team" id="team_employee" class="form-control">
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
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.email')}}</button>
                                                            </div>
                                                            <input type="text" name="email" id="emailEmployee" class="form-control">
                                                            {{--{{ Form::text('email', old('email'),--}}
                                                                {{--['class' => 'form-control',--}}
                                                                {{--'id' => 'emailEmployee',--}}
                                                                {{--'autofocus' => false,--}}
                                                                {{--])--}}
                                                            {{--}}--}}
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.role')}}</button>
                                                            </div>
                                                            <select name="role" id="role_employee" class="form-control">
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

                                                                @foreach($status as $key => $value)
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
                                                <button id="btn_reset_employee" type="button" class="btn btn-default"><span class="fa fa-refresh"></span>
                                                    {{trans('common.button.reset')}}
                                                </button>
                                                <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                                            class="fa fa-search"></span>
                                                    {{trans('common.button.search')}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="dataTables_length" id="project-list_length" style="float:right">
                                    <select id="mySelect" onchange="myFunction()">
                                        <option selected>Entries</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <script>
                                        function myFunction() {
                                            var x = document.getElementById("mySelect").value;
                                            console.log(x);
                                            $('#number_record_per_page').val(x);
                                            $('#form_search_employee').submit()
                                        }
                                    </script>
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
                                    <th class="small-row-id text-center">{{trans('employee.profile_info.id')}}</th>
                                    <th>{{trans('employee.profile_info.name')}}</th>
                                    <th>{{trans('employee.profile_info.team')}}</th>
                                    <th>{{trans('employee.profile_info.role')}}</th>
                                    <th>{{trans('employee.profile_info.email')}}</th>
                                    <th>{{trans('employee.profile_info.status')}}</th>
                                    {{--<th>CV</th>--}}
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($employees as $employee)
                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td  class="text-center"><p class="fix-center-employee">{{ isset($employee->id )? $employee->id : "-"}}</p></td>
                                        <td><p class="fix-center-employee">{{ isset($employee->name)? $employee->name: "-" }}</p></td>
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
                                        <td><p class="fix-center-employee">{{ isset($string_team)? $string_team: "-"}}</p></td>

                                        <td><p class="fix-center-employee">
                                            <?php
                                                if(isset($employee->role)){
                                                    if($employee->role->name == "PO"){
                                                        echo "<span class='label label-warning'>". $employee->role->name ."</span>";
                                                    } else if($employee->role->name == "Dev"){
                                                        echo "<span class='label label-success'>". $employee->role->name ."</span>";
                                                    } else if($employee->role->name == "BA"){
                                                        echo "<span class='label label-info'>". $employee->role->name ."</span>";
                                                    } else if($employee->role->name == "ScrumMaster"){
                                                        echo "<span class='label label-warning'>". $employee->role->name ."</span>";
                                                    } else if($employee->role->name == "HR"){
                                                        echo "<span class='label label-danger'>". $employee->role->name ."</span>";
                                                    } else if($employee->role->name == "ACCOUNTANT"){
                                                        echo "<span class='label label-default'>". $employee->role->name ."</span>";
                                                    }
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </p></td>
                                        <td><p class="fix-center-employee">{{ isset($employee->email)? $employee->email: "-" }}</p></td>
                                        <td><p class="fix-center-employee">
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
                                        </td>
                                        {{--<td style="text-align: center;width: 50px;">--}}
                                            {{--<!-- 1/8/hiddent_cmt-->--}}
                                            {{--<button type="button" class="btn btn-default cv-button">--}}
                                                {{--<a href="javascript:void(0)"><i class="fa fa-cloud-download"></i> CV</a>--}}
                                            {{--</button>--}}
                                        {{--</td>--}}
                                        <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>
                                            @if(Auth::user()->hasPermission('view_employee_basic'))
                                                <li><a href="employee/{{$employee->id}}"><i
                                                            class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a></li>
                                            @endif
                                            @if(Auth::user()->hasPermission('edit_employee_basic'))
                                                <li><a href="employee/{{$employee->id}}/edit"><i class="fa fa-edit width-icon-contextmenu"></i>
                                                        {{trans('common.action.edit')}}</a></li>
                                            @endif
                                            @if(Auth::user()->hasPermission('delete_employee'))
                                                <li><a class="btn-employee-remove" data-employee-id="{{$employee->id}}" data-employee-name="{{$employee->name}}"><i class="fa fa-remove width-icon-contextmenu"></i> {{trans('common.action.remove')}}</a></li>
                                            @endif
                                        </ul>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                @if($employees->hasPages())
                                    <div class="col-sm-5">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                            {{getInformationDataTable($employees)}}
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        {{  $employees->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
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
                $('ul.contextMenu[data-employee-id="' + eId + '"]')
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
                if (confirm(message_confirm('{{trans("common.action_confirm.delete")}}', '{{trans("common.name_confirm.employee")}}', elementRemove, nameRemove))) {
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
                            alert(msg.status);
                            var fade = "employee-id-" + msg.id;
                            $('ul.contextMenu[data-employee-id="' + msg.id + '"').hide();
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
    <script>
        $('#btn-search').click(function (e) {
            $('#form_search_employee').trigger("reset");
        });
    </script>
    <script>
        $('#btn-import').click(function (e) {
            var value = $('#myfile')[0].files[0];
            if(value == null){
                $('#i_submit').addClass('disabled');
            }
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
        .margin-form-search {
            margin: 10px 0px;
        }
    </style>
@endsection