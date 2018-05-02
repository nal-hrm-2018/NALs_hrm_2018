@extends('admin.template') 
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add employee
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/employee">Employee</a></li>
      <li class="active">Add employee</li>
    </ol>
  </section>

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
        <?php
          if(Session::get('employee') != ""){
            $employee = Session::get("employee");
          }
        ?>
        <SCRIPT LANGUAGE="JavaScript">
            function confirmAction($msg) {
                return confirm($msg);
            }
        </SCRIPT>
        <form action="{{asset('employee')}}" method="post" class="form-horizontal" onSubmit="return confirmAction('Would you like to add it?')" onreset="return confirmAction('Do you want to reset?')">
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
            <div class="col-md-6">
              <!-- /.form-group -->
              <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" placeholder="Email Address" name="email" 
                  value="{!! old('email') !!} {{ isset($employee) ? $employee->email : null}}">
                <label style="color: red;">{{$errors->first('email')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Password"  name="password" value="{!! old('password') !!}">
                <label style="color: red; ">{{$errors->first('password')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Confirm password</label>
                <input type="password" class="form-control" placeholder="Confirm password"  name="confirm_confirmation" value="{!! old('password') !!}">
                <label style="color: red; ">{{$errors->first('confirm_confirmation')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name"  name="name" value="{!! old('name') !!}@if(isset($employee)){{ $employee->name }}@endif">
                <label style="color: red; ">{{$errors->first('name')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address"  name="address" value="{!! old('address') !!}@if(isset($employee)){{ $employee->address }}@endif">
                <label style="color: red; ">{{$errors->first('address')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Mobile</label> 
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input type="number" class="form-control" placeholder="Phone"  name="mobile" value="{!! old('mobile') !!}@if(isset($employee)){{ $employee->mobile }}@endif">
                </div>
                <label style="color: red; ">{{$errors->first('mobile')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Gender</label>
                <select class="form-control select2" style="width: 100%;" name="gender">
                  <option value="1" 
                  <?php 
                    if( old('gender') == 1) echo'selected';
                    if(isset($employee)){ 
                      if($employee->gender == 1) 
                        echo'selected'; 
                    }
                  ?>
                  >Female</option>
                  <option value="2" 
                  <?php 
                    if( old('gender') == 2) echo'selected';
                    if(isset($employee)){ 
                      if($employee->gender == 2) 
                        echo'selected'; 
                    }
                  ?>
                  >Male</option>
                  <option value="3" 
                  <?php 
                    if( old('gender') == 3) echo'selected';
                    if(isset($employee)){ 
                      if($employee->gender == 3) 
                        echo'selected'; 
                    }
                  ?>
                  >N/a</option>
                </select>
              </div>
              <div class="form-group">
                <label>Married</label>
                <select class="form-control select2" style="width: 100%;"  name="marital_status">
                  <option value="1" 
                  <?php 
                    if( old('marital_status') == 1) echo'selected';
                    if(isset($employee)){ 
                      if($employee->marital_status == 1) 
                        echo'selected'; 
                    }
                  ?>
                  >Single</option>
                  <option value="2" 
                  <?php 
                    if( old('marital_status') == 2) echo'selected';
                    if(isset($employee)){ 
                      if($employee->marital_status == 2) 
                        echo'selected'; 
                    }
                  ?>
                  >Married</option>
                  <option value="3" 
                  <?php 
                    if( old('marital_status') == 3) echo'selected';
                    if(isset($employee)){ 
                      if($employee->marital_status == 3) 
                        echo'selected'; 
                    }
                  ?>
                  >Separated</option>
                  <option value="4" 
                  <?php 
                    if( old('marital_status') == 4) echo'selected';
                    if(isset($employee)){ 
                      if($employee->marital_status == 4) 
                        echo'selected'; 
                    }
                  ?>
                  >Devorce</option>
                </select>
              </div>
              <div class="form-group">
                <label>Team</label>
                <select class="form-control select2" style="width: 100%;"  name="team_id">
                  <?php
                    foreach($dataTeam as $val){
                      $selected = "";
                      if($val["id"] == old('team_id')){
                        $selected = "selected";
                      }
                      if(isset($employee)){
                        if($employee->team_id == $val["id"]){
                          $selected = "selected";
                        }
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Birthday</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="birthday" name="birthday" value="{{ old('birthday') }} {{ isset($employee) ? $employee->birthday : null}}">
                </div>
                <label style="color: red; ">{{$errors->first('birthday')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" placeholder="Company"  name="company" value="{!! old('company') !!}@if(isset($employee)){{ $employee->mobile }}@endif">
                <label style="color: red; ">{{$errors->first('company')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Position</label>
                <select class="form-control select2" style="width: 100%;" name="employee_type_id">
                  <?php
                    foreach($dataEmployeeTypes as $val){
                      $selected = "";
                      if($val["id"] == old('employee_type_id')){
                        $selected = "selected";
                      }
                      if(isset($employee)){
                        if($employee->employee_type_id == $val["id"]){
                          $selected = "selected";
                        }
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Role of team</label>
                <select class="form-control select2" style="width: 100%;" name="role_id">
                  <?php
                    foreach($dataRoles as $val){
                      $selected = "";
                      if($val["id"] == old('role_id')){
                        $selected = "selected";
                      }
                      if(isset($employee)){
                        if($employee->role_id == $val["id"]){
                          $selected = "selected";
                        }
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Start work date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" value="{!! old('startwork_date') !!} {{ isset($employee) ? $employee->startwork_date : null}}">
                    </div>
                    <label style="color: red; ">{{$errors->first('startwork_date')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>End work date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="endwork_date" name="endwork_date" value="{!! old('endwork_date') !!} {{ isset($employee) ? $employee->endwork_date : null}}">
                    </div>
                    <label style="color: red; ">{{$errors->first('endwork_date')}}</label>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>
            </div>
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
                  <button type="submit" class="btn btn-info pull-left">Add Employee</button>
              </div>
            </div>
          </div>
        </form>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
@endsection