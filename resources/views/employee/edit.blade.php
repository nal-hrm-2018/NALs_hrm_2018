@extends('admin.template')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{trans('common.path.edit_employee')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>
      <li><a href="/employee">{{trans('common.path.employee')}}</a></li>
      <li class="active">{{trans('common.path.edit')}}</li>
    </ol>
  </section>
  <style type="text/css">
    .form-horizontal .form-group {
      margin-right: 0px;
    }
  </style>
  <!-- Main content -->
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-body">

        <div id="msg">
        </div>
        <SCRIPT LANGUAGE="JavaScript">
            function confirmEmployee() {
                var name = $('#name').val();
                 var id = $('#id_employee').val();
                return confirm(message_confirm('{{trans("common.action_confirm.edit")}}', '{{trans("common.name_confirm.employee")}}', id, name));
            }
        </SCRIPT>
        <div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
          <div class="row">
            {{ Form::model($objEmployee, ['url' => ['/employee', $objEmployee["id"]],'class' => 'form-horizontal','method'=>isset($objEmployee["id"])?'PUT':'POST','onSubmit' => 'return confirmEmployee()'])}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>
            <div class="col-md-3">
              <CENTER>
                <div>
                  <img src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}" />
                </div>
              </CENTER>
              <div class="row" style="margin-top: 20px;">
                <CENTER><label>{{trans('employee.profile_info.avatar')}}</label></CENTER>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-5">
              <!-- /.form-group -->
              <div class="form-group">
                <label>{{trans('employee.profile_info.email')}}<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.email')}}" name="email" id="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}" @if(\Illuminate\Support\Facades\Auth::user()->email != $objEmployee["email"])
                  readonly="readonly"
                @endif
                >
                <label id="lb_error_email" style="color: red;">{{$errors->first('email')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>{{trans('employee.profile_info.name')}}<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.name')}}"  name="name" id="name" value="{!! old('name', isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}">
                <label id="lb_error_name" style="color: red;">{{$errors->first('name')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.address')}}<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.address')}}"  name="address" id="adress" value="{!! old('address', isset($objEmployee["address"]) ? $objEmployee["address"] : null) !!}">
                <label id="lb_error_address" style="color: red;">{{$errors->first('address')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.phone')}}<strong style="color: red">(*)</strong></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input type="number" class="form-control" placeholder="{{trans('employee.profile_info.phone')}}"  name="mobile" id="mobile" value="{!! old('mobile', isset($objEmployee["mobile"]) ? $objEmployee["mobile"] : null) !!}">
                </div>
                <label id="lb_error_mobile" style="color: red;">{{$errors->first('mobile')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.gender.title')}}<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="gender" id="gender">
                  <option value="1" id="gender_1" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 1) echo'selected'; ?>>{{trans('employee.profile_info.gender.female')}}</option>
                  <option value="2" id="gender_2" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 2) echo'selected'; ?>>{{trans('employee.profile_info.gender.male')}}</option>
                  <option value="3" id="gender_3" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 3) echo'selected'; ?>>{{trans('employee.profile_info.gender.na')}}</option>
                </select>
                <label id="lb_error_gender" style="color: red;">{{$errors->first('gender')}}</label>
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.marital_status.title')}}<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;"  name="marital_status" id="marital_status">
                  <option value="1" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 1) echo'selected'; ?>>{{trans('employee.profile_info.marital_status.single')}}</option>
                  <option value="2" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 2) echo'selected'; ?>>{{trans('employee.profile_info.marital_status.married')}}</option>
                  <option value="3" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 3) echo'selected'; ?>>{{trans('employee.profile_info.marital_status.separated')}}</option>
                  <option value="4" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 4) echo'selected'; ?>>{{trans('employee.profile_info.marital_status.divorced')}}</option>
                </select>
                <label id="lb_error_marital_status" style="color: red;">{{$errors->first('marital_status')}}</label>
              </div>
              <div class="form-group">
                {{--<label>{{trans('employee.profile_info.team')}}<strong style="color: red">(*)</strong></label>--}}
                {{--<select class="form-control select2" style="width: 100%;"  name="team_id" id="team_id">--}}
                  {{--<option value="" >---{{trans('employee.drop_box.placeholder-default')}}---</option>--}}
                  {{--<?php--}}
                    {{--foreach($dataTeam as $val){--}}
                      {{--$selected = "";--}}
                      {{--if($val["id"] == old('team_id', isset($objEmployee["team_id"]) ? $objEmployee["team_id"] : null)){--}}
                        {{--$selected = "selected";--}}
                      {{--}--}}
                      {{--echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';--}}
                    {{--}--}}
                  {{--?>--}}
                {{--</select>--}}
                {{--<label id="lb_error_team_id" style="color: red; ">{{$errors->first('team_id')}}</label>--}}
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.birthday')}}<strong style="color: red">(*)</strong></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="birthday" name="birthday" id="birthday" value="{!! old('birthday', isset($objEmployee["birthday"]) ? $objEmployee["birthday"] : null) !!}">
                </div>
                <label id="lb_error_birthday" style="color: red;">{{$errors->first('birthday')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.position')}}<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="employee_type_id" id="employee_type_id">
                  <option value="" >---{{trans('employee.drop_box.placeholder-default')}}---</option>
                  <?php
                    foreach($dataEmployeeTypes as $val){
                      $selected = "";
                      if($val["id"] == old('employee_type_id', isset($objEmployee["employee_type_id"]) ? $objEmployee["employee_type_id"] : null)){
                        $selected = "selected";
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
                <label id="lb_error_employee_type_id" style="color: red; ">{{$errors->first('employee_type_id')}}</label>
              </div>
              <div class="form-group">
                <label>{{trans('employee.profile_info.role')}}<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="role_id" id="role_id">
                  <option value="" >---{{trans('employee.drop_box.placeholder-default')}}---</option>
                  <?php
                    foreach($dataRoles as $val){
                      $selected = "";
                      if($val["id"] == old('role_id', isset($objEmployee["role_id"]) ? $objEmployee["role_id"] : null)){
                        $selected = "selected";
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
                <label id="lb_error_role_id" style="color: red; ">{{$errors->first('role_id')}}</label>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{trans('employee.profile_info.start_work')}}<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="{!! old('startwork_date', isset($objEmployee["startwork_date"]) ? $objEmployee["startwork_date"] : null) !!}">
                    </div>
                    <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{trans('employee.profile_info.end_work')}}<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="endwork_date" name="endwork_date" id="endwork_date" value="{!! old('endwork_date', isset($objEmployee["endwork_date"]) ? $objEmployee["endwork_date"] : null) !!}">
                    </div>
                    <label id="lb_error_endwork_date" style="color: red;">{{$errors->first('endwork_date')}}</label>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>
              <div class="row">
                <br />
                <div class="col-md-3" style="margin-left: 100px;">
                  <button type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                    {{trans('common.button.reset')}}
                  </button>
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{trans('common.button.save')}}
                  </button>
                </div>
              </div>
            </div>
            {{ Form::close() }}
            @if(isset($objEmployee))
                @if(\Illuminate\Support\Facades\Auth::user()->email == $objEmployee["email"])
                <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal" style="margin-top:1.75em;">
                    {{trans('common.button.edit_password')}}
                  </button>
                  <br />
                  <label style="color: red;">
                    <?php
                      if (Session::has('error')){
                        echo''.Session::get("error");
                      }
                    ?>
                  </label>
                  <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <form method="post" action="{{asset('employee/edit-password')}}" class="edit_pass" onsubmit="return validate();">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{trans('common.button.edit_password')}}</h4>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                  <div class="input-group margin">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn width-130">{{trans('employee.profile_info.old_password')}}<strong style="color: red">(*)</strong>&ensp;&ensp;&ensp;&ensp;</button>
                                    </div>
                                    <input type="password" name="old_pass" id="old_pass" class="form-control" onchange="oldPass()">
                                  </div>
                                  <label style="color: red; margin-left: 130px;" id="errorOldPass" style="display: inline;"></label>
                                  <div class="input-group margin">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn width-130">{{trans('employee.profile_info.new_password')}}<strong style="color: red">(*)</strong>&ensp;&ensp;&ensp;</button>
                                    </div>
                                    <input type="password" name="new_pass" id="new_pass" class="form-control"  onchange="newPass()">
                                  </div>
                                  <label style="color: red; margin-left: 130px;" id="errorNewPass"></label>
                                  <div class="input-group margin">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn width-130">{{trans('employee.profile_info.password_confirm')}}<strong style="color: red">(*)</strong></button>
                                    </div>
                                    <input type="password" name="cf_pass" id="cf_pass" class="form-control" onchange="cfPass()">
                                  </div>
                                  <label style="color: red; margin-left: 130px;" id="errorCfPass"></label>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer center">
                              <button id="btn_reset_edit_password" type="reset" class="btn btn-default"><span class="fa fa-refresh"></span>
                                {{trans('common.button.reset')}}
                              </button>
                              <button type="submit" id="searchListEmployee" class="btn btn-primary">
                                {{trans('common.button.update')}}
                              </button>
                            </div>
                        </div>
                      </form>
                      <script type="text/javascript">
                          $(function () {
                              $('#btn_reset_edit_password').click(function () {
                                  $('#errorCfPass').empty();
                                  $('#errorOldPass').empty();
                                  $('#errorNewPass').empty();
                              });
                          })
                        function validate(){
                          var old_pass = document.getElementById("old_pass").value;
                          var new_pass = document.getElementById("new_pass").value;
                          var cf_pass = document.getElementById("cf_pass").value;
                          var check = true;
                          if(old_pass == ""){
                            document.getElementById("errorOldPass").innerHTML = "{{trans('employee.valid_reset_password.required_old_pass')}}";
                            check =false;
                          }else if(old_pass.length < 6){
                            document.getElementById("errorOldPass").innerHTML = "{{trans('employee.valid_reset_password.min_old_pass')}}";
                            check = false;
                          }else if(old_pass.length > 32){
                            document.getElementById("errorOldPass").innerHTML = "{{trans('employee.valid_reset_password.max_old_pass')}}";
                            check = false;
                          }

                          if(new_pass == ""){
                            document.getElementById("errorNewPass").innerHTML = "{{trans('employee.valid_reset_password.required_new_pass')}}";
                            check =false;
                          }else if(new_pass.length < 6){
                            document.getElementById("errorNewPass").innerHTML = "{{trans('employee.valid_reset_password.min_new_pass')}}";
                            check = false;
                          }else if(new_pass.length > 32){
                            document.getElementById("errorNewPass").innerHTML = "{{trans('employee.valid_reset_password.max_new_pass')}}";
                            check = false;
                          }
                          if(cf_pass == ""){
                            document.getElementById("errorCfPass").innerHTML = "{{trans('employee.valid_reset_password.required_confirm_pass')}}";
                            check =false;
                          }else if(new_pass != cf_pass){
                            document.getElementById("errorCfPass").innerHTML = "{{trans('employee.valid_reset_password.match_confirm_pass')}}";
                            check = false;
                          }
                          return check;
                        }
                      </script>
                      <script>
                        function oldPass() {
                          var x = document.getElementById("old_pass").value;
                          if(x == ""){
                            document.getElementById("errorOldPass").innerHTML = "{{trans('employee.valid_reset_password.required_old_pass')}}";
                          } else if(x.length < 6){
                            document.getElementById("errorOldPass").innerHTML = "{{trans('employee.valid_reset_password.min_old_pass')}}";
                          }else{
                            document.getElementById("errorOldPass").innerHTML = "";
                          }
                        }
                      </script>
                      <script>
                        function newPass() {
                          var x = document.getElementById("new_pass").value;
                          if(x == ""){
                            document.getElementById("errorNewPass").innerHTML = "{{trans('employee.valid_reset_password.required_new_pass')}}";
                          } else
                          if(x.length < 6){
                            document.getElementById("errorNewPass").innerHTML = "{{trans('employee.valid_reset_password.min_new_pass')}}";
                          }else{
                            document.getElementById("errorNewPass").innerHTML = "";
                          }
                          var y = document.getElementById("cf_pass").value;
                          if(x!=y){
                            document.getElementById("errorCfPass").innerHTML = "{{trans('employee.valid_reset_password.match_confirm_pass')}}";
                          }else{
                            document.getElementById("errorCfPass").innerHTML = "";
                          }
                        }
                      </script>
                      <script>
                        function cfPass() {
                          var x = document.getElementById("new_pass").value;
                          var y = document.getElementById("cf_pass").value;
                          if(x != y){
                            document.getElementById("errorCfPass").innerHTML = "{{trans('employee.valid_reset_password.match_confirm_pass')}}";
                          }else{
                            document.getElementById("errorCfPass").innerHTML = "";
                          }
                        }
                      </script>
                    </div>
                </div>
              @endif
            @endif
          </div>
        <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
      </div>
      <!-- /.box-body -->
    </div>
    <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function () {
            $("#btn_reset_form_employee").bind("click", function () {
				if(confirmAction("{{trans('common.confirm_reset')}}"))
                location.reload();
                {{--$("#lb_error_email").empty();--}}
                {{--$("#lb_error_password").empty();--}}
                {{--$("#lb_error_address").empty();--}}
                {{--$("#lb_error_birthday").empty();--}}
                {{--$("#lb_error_employee_type_id").empty();--}}
                {{--$("#lb_error_endwork_date").empty();--}}
                {{--$("#lb_error_startwork_date").empty();--}}
                {{--$("#lb_error_gender").empty();--}}
                {{--$("#lb_error_marital_status").empty();--}}
                {{--$("#lb_error_mobile").empty();--}}
                {{--$("#lb_error_name").empty();--}}
                {{--$("#lb_error_role_id").empty();--}}
                {{--$("#lb_error_team_id").empty();--}}
                {{--$("#email").val('{!! old(isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}');--}}
                {{--$("#name").val('{!! old(isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}');--}}
                {{--$("#address").val('{!! old(isset($objEmployee["address"]) ? $objEmployee["address"] : null) !!}');--}}
                {{--$("#mobile").val('{!! old(isset($objEmployee["mobile"]) ? $objEmployee["mobile"] : null) !!}');--}}
                {{--$("#endwork_date").val('value', '{!! old(isset($objEmployee["birthday"]) ? $objEmployee["birthday"] : null) !!}');--}}
                {{--$("#startwork_date").val('value', '{!! old(isset($objEmployee["startwork_date"]) ? $objEmployee["startwork_date"] : null) !!}');--}}
                {{--$("#endwork_date").val('value', '{!! old(isset($objEmployee["endwork_date"]) ? $objEmployee["endwork_date"] : null) !!}');--}}

                {{--$("#gender").val('{!! isset($objEmployee["gender"]) ? $objEmployee["gender"] : null !!}').change();--}}
                {{--$("#marital_status").val('{!! isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null !!}').change();--}}
                {{--$("#team_id").val('{!! isset($objEmployee["team_id"]) ? $objEmployee["team_id"] : null !!}').change();--}}
                {{--$("#employee_type_id").val('{!! isset($objEmployee["employee_type_id"]) ? $objEmployee["employee_type_id"] : null !!}').change();--}}
                {{--$("#role_id").val('{!! isset($objEmployee["role_id"]) ? $objEmployee["role_id"] : null !!}').change();--}}
            });
        });
    </script>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>


@endsection