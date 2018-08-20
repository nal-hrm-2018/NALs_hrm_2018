<?php
    /**
     * Created by PhpStorm.
     * User: Ngoc Quy
     * Date: 4/16/2018
     * Time: 11:00 AM
     */ ?>
@extends('admin.template')
@section('content')

        <div class="content">
            {{--<div class="title-content d-flex">--}}
                {{--<span class="title-emp">--}}
                    {{--<a href=""></a>--}}
                {{--</span>--}}
                {{--<span class="title-prof">--}}
                    {{--<a href="#">MY PROFILE</a>--}}
                {{--</span>--}}
            {{--</div>--}}
            <div class="d-flex button-content">
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
                <button  type="button" class="button-content-item export-employee" id="click-here" onclick="return confirmExport('{{trans('employee.msg_content.msg_download_employee_list')}}')">
                    <a id="export"
                       href="{{asset('export').'?'.'id='.$id.'&name='.$name.'&team='.$team.'&email='.$email.'&role='.$role.'&email='.$email.'&status='.$statusExport.'&page='.$page}}">
                        <img src="{!! asset('admin/templates/images/employees/export.png') !!}" class="mg-img-button">
                        <span id="contain-canvas" style="">
                                <canvas id="my_canvas" width="16" height="16" style=""></canvas>
                            </span>
                        {{trans('common.button.export')}}</a>
                </button>
                @if(Auth::user()->hasRoleHR())
                    <button type="button" class="button-content-item" onclick="return confirmAction('{{trans('employee.msg_content.msg_download_employee_template')}}')">
                        <a href="/download-template"><img src="{!! asset('admin/templates/images/employees/template.png') !!}" class="mg-img-button"> {{trans('common.button.template')}}</a>
                    </button>
                @endif

                @if(Auth::user()->hasRoleHR())
                <button type="button" class="button-content-item" data-toggle="modal" data-target="#import" id="btn-import">
                    <a><img src="{!! asset('admin/templates/images/employees/import.png') !!}" class="mg-img-button"> {{trans('common.button.import')}}</a>
                </button>
                @endif
                <div id="import" class="modal fade" role="dialog">
                    <div class="modal-dialog">
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
                                                <button type="button" class="btn width-100">{{trans('employee.select_csv_file')}}</button>
                                            </div>
                                            <input type="file" id="myfile" name="myFile" class="form-control">
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
                @if(Auth::user()->hasPermission('add_new_employee'))
                <a href="{{ asset('employee/create')}}" class="button-content-item"><img src="{!! asset('admin/templates/images/employees/add.png') !!}" class="mg-img-button">&nbsp;{{trans('common.button.add')}}</a>
                @endif
            </div>
            <div class=" title-table">
                <div>
                    <button type="button" class="btn btn-outline-info btn-search">
                        Search&nbsp;<i class="fas fa-search"></i>
                    </button>
                    <form class="form-search" method="get" role="form" id="form_search_employee">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text width-label-input" id="basic-addon1">{{trans('employee.profile_info.id')}}</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Employees ID" aria-label="Username" name="id" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text width-label-input" id="basic-addon2">{{trans('employee.profile_info.name')}}</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Name" aria-label="Username" name="name" aria-describedby="basic-addon2">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text width-label-input" id="basic-addon3">{{trans('employee.profile_info.email')}}</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Email" aria-label="Username" name="email" aria-describedby="basic-addon3">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text width-label-input" for="inputGroupSelect01">{{trans('employee.profile_info.team')}}</label>
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text width-label-input" for="inputGroupSelect01">{{trans('employee.profile_info.role')}}</label>
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text width-label-input" for="inputGroupSelect01">{{trans('employee.profile_info.status')}}</label>
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
                        <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                               value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">
                                {{trans('common.button.reset')}}
                            </button>
                            <button type="submit" id="searchListEmployee" class="btn btn-primary btn-search-confirm">
                                {{trans('common.button.search')}}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="d-flex is-space-between title-list">
                    <h4>List Employees</h4>
                    <select id="mySelect" onchange="myFunction()">
                        <option selected>Entries</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <script>
                    function myFunction() {
                        var x = document.getElementById("mySelect").value;
                        console.log(x);
                        $('#number_record_per_page').val(x);
                        $('#form_search_employee').submit()
                    }
                </script>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 100px;" class="small-row-id text-center">{{trans('employee.profile_info.id')}}</th>
                        <th>{{trans('employee.profile_info.name')}}</th>
                        <th>{{trans('employee.profile_info.team')}}</th>
                        <th>{{trans('employee.profile_info.role')}}</th>
                        <th>{{trans('employee.profile_info.email')}}</th>
                        <th>{{trans('employee.profile_info.status')}}</th>
                        {{--<th>CV</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($employees as $employee)

                        <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                            data-employee-id="{{$employee->id}}">
                            <td  class="text-center"><p class="fix-center-employee" >{{ isset($employee->id )? $employee->id : "-"}}</p></td>
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
                            {{--<td style="text-align: center;width: 50px;">---}}
                                {{--<!-- 1/8/hiddent_cmt-->--}}
                                {{--<button type="button" class="btn btn-default cv-button">--}}
                                {{--<a href="javascript:void(0)"><i class="fa fa-cloud-download"></i> CV</a>--}}
                                {{--</button>--}}
                            {{--</td>--}}
                            <ul class='custom-menu' data-employee-id="{{$employee->id}}">
                                @if(Auth::user()->hasPermission('view_employee_basic'))
                                    <li><a id="view" href="employee/{{$employee->id}}"><i class="fas fa-eye"></i>&nbsp;{{trans('common.action.view')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission('edit_employee_basic'))
                                    <li><a href="employee/{{$employee->id}}/edit"><i class="far fa-edit"></i>{{trans('common.action.edit')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission('delete_employee'))
                                    <li><a href="{{ route('employee.destroy',['id' => $employee->id]) }}" class="btn-employee-remove" data-employee-id="{{$employee->id}}" data-employee-name="{{$employee->name}}"><i
                                                    class="fa fa-remove"></i> {{trans('common.action.remove')}}</a></li>
                                @endif
                            </ul>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="container-pagination pagina">

                @if ($employees->onFirstPage())
                    <li style="display: inline-block; float: left;" class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li style="display: inline-block; float: left;" class="page-item"><a class="page-link" href="{{ $employees->url(1) }}" rel="first">&laquo;</a></li>
                @endif
                <div class="paginat" style="float: left;">
                    {{ $employees->links() }}
                </div>
                    {{-- Last Page Link --}}
                @if ($employees->hasMorePages())
                    <li style="display: inline-block; float: left;" class="page-item"><a class="page-link" href="{{ $employees->url($employees->lastPage()) }}" rel="last">&raquo;</a></li>
                @else
                    <li style="display: inline-block; float: left;" class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </div>

        </div>
<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
@endsection