@extends('admin.template')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit employee
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/employee">Employee</a></li>
      <li class="active">Edit Employee</li>
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
        <?php
          if(Session::get('msg_fail') != ""){
            echo '<div>
                <ul class=\'error_msg\'>
                    <li>'.Session::get("msg_fail").'</li>
                </ul>
            </div>';
          }
        ?>
        <SCRIPT LANGUAGE="JavaScript">
            function confirmAction($msg) {
                return confirm($msg)
            }
        </SCRIPT>
        {{ Form::model($objEmployee, ['url' => ['/employee', $objEmployee["id"]],'class' => 'form-horizontal','method'=>isset($objEmployee["id"])?'PUT':'POST', 'onreset' => 'return confirmAction("Do you want to reset?")', 'onSubmit' => 'return confirmAction("Would you like to edit it?")'])}}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row">
            <div class="col-md-3">
              <CENTER>
                <div>
                  <img src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}" />
                </div>
              </CENTER>
              <div class="row" style="margin-top: 20px;">
                <CENTER><label>Avatar</label></CENTER>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-5">
              <!-- /.form-group -->
              <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" placeholder="Email Address" name="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}" @if(\Illuminate\Support\Facades\Auth::user()->email != $objEmployee["email"])
                  readonly="readonly"
                @endif
                >
                <label style="color: red;">{{$errors->first('email')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name"  name="name" value="{!! old('name', isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}">
                <label style="color: red;">{{$errors->first('name')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address"  name="address" value="{!! old('address', isset($objEmployee["address"]) ? $objEmployee["address"] : null) !!}">
                <label style="color: red;">{{$errors->first('address')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Mobile</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input type="number" class="form-control" placeholder="Phone"  name="mobile" value="{!! old('mobile', isset($objEmployee["mobile"]) ? $objEmployee["mobile"] : null) !!}">
                </div>
                <label style="color: red;">{{$errors->first('mobile')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Gender</label>
                <select class="form-control select2" style="width: 100%;" name="gender">
                  <option value="1" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 1) echo'selected'; ?>>Female</option>
                  <option value="2" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 2) echo'selected'; ?>>Male</option>
                  <option value="3" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 3) echo'selected'; ?>>N/a</option>
                </select>
              </div>
              <div class="form-group">
                <label>Married</label>
                <select class="form-control select2" style="width: 100%;"  name="marital_status">
                  <option value="1" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 1) echo'selected'; ?>>Single</option>
                  <option value="2" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 2) echo'selected'; ?>>Married</option>
                  <option value="3" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 3) echo'selected'; ?>>Separated</option>
                  <option value="4" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 4) echo'selected'; ?>>Devorce</option>
                </select>
              </div>
              <div class="form-group">
                <label>Team</label>
                <select class="form-control select2" style="width: 100%;"  name="team_id">
                  <option value="" >---Team selection---</option>
                  <?php
                    foreach($dataTeam as $val){
                      $selected = "";
                      if($val["id"] == old('team_id', isset($objEmployee["team_id"]) ? $objEmployee["team_id"] : null)){
                        $selected = "selected";
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
                <label style="color: red; ">{{$errors->first('team_id')}}</label>
              </div>
              <div class="form-group">
                <label>Birthday</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="birthday" name="birthday" value="{!! old('birthday', isset($objEmployee["birthday"]) ? $objEmployee["birthday"] : null) !!}">
                </div>
                <label style="color: red;">{{$errors->first('birthday')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Position</label>
                <select class="form-control select2" style="width: 100%;" name="employee_type_id">
                  <option value="" >---Position selection---</option>
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
                <label style="color: red; ">{{$errors->first('employee_type_id')}}</label>
              </div>
              <div class="form-group">
                <label>Role of team</label>
                <select class="form-control select2" style="width: 100%;" name="role_id">
                  <option value="" >---Role selection---</option>
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
                <label style="color: red; ">{{$errors->first('role_id')}}</label>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Start work date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" value="{!! old('startwork_date', isset($objEmployee["startwork_date"]) ? $objEmployee["startwork_date"] : null) !!}">
                    </div>
                    <label style="color: red;">{{$errors->first('startwork_date')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>End work date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="endwork_date" name="endwork_date" value="{!! old('endwork_date', isset($objEmployee["endwork_date"]) ? $objEmployee["endwork_date"] : null) !!}">
                    </div>
                    <label style="color: red;">{{$errors->first('endwork_date')}}</label>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>
            </div>
            @if(isset($objEmployee))
                @if(\Illuminate\Support\Facades\Auth::user()->email == $objEmployee["email"])
                  <div class="col-md-4" id="resetPass">
                    <br />
                    <p onclick="resetPass()" class="btn btn-info pull-left" style="margin-top: 5px;">Reset password</p>
                    <label style="color: red;"><?php
                      if (Session::has('minPass')){
                        echo''.Session::get("minPass");
                      }
                    ?></label>
                  </div>
                  <script>
                    function resetPass() {
                        document.getElementById("resetPass").innerHTML = "<div class=\"form-group\">                     <label>Password</label><input type=\"password\" class=\"form-control\" placeholder=\"Password\" id=\"password\"  name=\"password\" value=\"\" onchange=\"myFunction()\"><label style=\"color: red;\" id=\"minPass\"></label></div>"
                        + "<div class=\"form-group\"><label>Confirm password</label><input type=\"password\" class=\"form-control\" placeholder=\"Confirm password\" name=\"confirm_confirmation\" id=\"confirmPass\" onchange=\"confirmPass1()\"><label style=\"color: red;\" id=\"cf\"></label></div><br /><p onclick=\"closePass()\" class=\"btn btn-info pull-left\" style=\"margin-top: 5px;\">Close Reset password</p>";
                    }
                  </script>
                  <script>
                    function closePass() {
                        document.getElementById("resetPass").innerHTML = "<br /><p onclick=\"resetPass()\" class=\"btn btn-info pull-left\" style=\"margin-top: 5px;\">Reset password</p>";
                    }
                  </script>
                  <script>
                    function myFunction() {
                      var x = document.getElementById("password").value;
                      if(x.length < 6){
                        document.getElementById("minPass").innerHTML = "The Password must be at least 6 characters.";
                      }else{
                        document.getElementById("minPass").innerHTML = "";
                      }
                      var y = document.getElementById("confirmPass").value;
                      if(x!=y){
                        document.getElementById("cf").innerHTML = "The confirm password and password must match.";
                      }else{
                        document.getElementById("cf").innerHTML = "";
                      }
                    }
                  </script>
                  <script>
                    function confirmPass1() {
                      var x = document.getElementById("password").value;
                      var y = document.getElementById("confirmPass").value;
                      if(x != y){
                        document.getElementById("cf").innerHTML = "The confirm password and password must match.";
                      }else{
                        document.getElementById("cf").innerHTML = "";
                      }
                    }
                  </script>
                @endif
              @endif
            <!-- /.col -->
          </div>
          <div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
            <div class="col-md-6" style="display: inline; ">
              <div style="float: right;" >
                <input type="reset" value="Reset" class="btn btn-info pull-left">
              </div>
            </div>
            <div class="col-md-2" style="display: inline;">
              <div style="float: right;">
                  <button type="submit" class="btn btn-info pull-left">Edit Employee</button>
              </div>
            </div>
          </div>
        {{ Form::close() }}
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>


@endsection