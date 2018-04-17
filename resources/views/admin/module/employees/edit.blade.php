@extends('admin.template') 
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit employee
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Forms</a></li>
      <li class="active">Advanced Elements</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-body">
        @include('admin.block.error')
        <?php

          if(Session::get('msg_fail') != ""){
            echo '<div>
                <ul class=\'error_msg\'>
                    <li>'.Session::get("msg_fail").'</li>
                </ul>
            </div>';
          }
        ?>
        <form action="" method="post" class="form-horizontal">
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
                <input type="text" class="form-control" placeholder="Email Address" name="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}">
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Password"  name="password" value="{!! old('password', isset($objEmployee["password"]) ? $objEmployee["password"] : null) !!}">
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Name"  name="name" value="{!! old('name', isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}">
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address"  name="address" value="{!! old('address', isset($objEmployee["address"]) ? $objEmployee["address"] : null) !!}">
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Phone</label> 
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input type="number" class="form-control" placeholder="Phone"  name="mobile" value="{!! old('mobile', isset($objEmployee["mobile"]) ? $objEmployee["mobile"] : null) !!}">
                </div>
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
                <select class="form-control select2" style="width: 100%;"  name="teams_id">
                  <?php
                    foreach($dataTeam as $val){
                      $selected = "";
                      if($val["id"] == old('teams_id', isset($objEmployee["teams_id"]) ? $objEmployee["teams_id"] : null)){
                        $selected = "selected";
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
                  <input type="date" class="form-control pull-right" id="birthday" name="birthday" value="{!! old('birthday', isset($objEmployee["birthday"]) ? $objEmployee["birthday"] : null) !!}">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" placeholder="Company"  name="company" value="{!! old('company', isset($objEmployee["company"]) ? $objEmployee["company"] : null) !!}">
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Position</label>
                <select class="form-control select2" style="width: 100%;" name="employee_type_id">
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
              </div>
              <div class="form-group">
                <label>Role of team</label>
                <select class="form-control select2" style="width: 100%;" name="roles_id">
                  <?php
                    foreach($dataRoles as $val){
                      $selected = "";
                      if($val["id"] == old('roles_id', isset($objEmployee["roles_id"]) ? $objEmployee["roles_id"] : null)){
                        $selected = "selected";
                      }
                      echo'<option value="'.$val["id"].'" '.$selected.'>'.$val["name"].'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Start_work</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" value="{!! old('startwork_date', isset($objEmployee["startwork_date"]) ? $objEmployee["startwork_date"] : null) !!}">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>End_work</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="endwork_date" name="endwork_date" value="{!! old('endwork_date', isset($objEmployee["endwork_date"]) ? $objEmployee["endwork_date"] : null) !!}">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
            <div class="col-md-7">    
              <div style="float: right;">        
                  <button type="submit" class="btn btn-info pull-left">Edit Employee</button>
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