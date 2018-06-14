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

        <div id="msg">
        </div>
        <SCRIPT LANGUAGE="JavaScript">
            function confirmEmployee() {
                var name = $('#name').val();
                 var id = $('#id_employee').val();
                return confirm(message_confirm('edit', 'employee', id, name));
            }
        </SCRIPT>
        <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
          <div class="row">
            {{ Form::model($objEmployee, ['url' => ['/employee', $objEmployee["id"]],'class' => 'form-horizontal','method'=>isset($objEmployee["id"])?'PUT':'POST','onSubmit' => 'return confirmEmployee()'])}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>
            <div class="col-md-3"></div>
            <!-- /.col -->
            <div class="col-md-5">
              <!-- /.form-group -->
              <div class="form-group">
                <label>Địa chỉ email<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="Email Address" name="email" id="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}" @if(\Illuminate\Support\Facades\Auth::user()->email != $objEmployee["email"])
                  readonly="readonly"
                @endif
                >
                <label id="lb_error_email" style="color: red;">{{$errors->first('email')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Họ Tên<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="Name"  name="name" id="name" readonly="readonly" value="{!! old('name', isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}">
                <label id="lb_error_name" style="color: red;">{{$errors->first('name')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Team<strong style="color: red">(*)</strong></label>
                <input type="text" readonly="readonly" class="form-control" placeholder="Team Name"  name="team" id="team" value="{!! old('team', isset($objEmployee["name"]) ? $objEmployee["name"] : null) !!}">
                <label id="lb_error_name" style="color: red;" readonly="readonly">{{$errors->first('name')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>PO Project<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;"  name="team_id" id="team_id">
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
              </div>

              <div class="form-group">
                <label>Nghỉ từ ngày<strong style="color: red">(*)</strong></label><br />
                  <span style="color: darkgray">Ngày</span>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="dd/MM/yyyy">
                    </div>
                  <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>

                <span style="color: darkgray">Giờ</span>
                <div class="input-group date">
                  <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="dd/MM/yyyy">
                </div>
                <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Đến ngày<strong style="color: red">(*)</strong></label><br />
                <span style="color: darkgray">Ngày</span>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="dd/MM/yyyy">
                </div>
                <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>

                <span style="color: darkgray">Giờ</span>
                <div class="input-group date">
                  <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="dd/MM/yyyy">
                </div>
                <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>
                <!-- /.input group -->
              </div>


              <div class="form-group">
                <label>Mobile<strong style="color: red">(*)</strong></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input type="number" class="form-control" placeholder="Phone"  name="mobile" id="mobile" value="{!! old('mobile', isset($objEmployee["mobile"]) ? $objEmployee["mobile"] : null) !!}">
                </div>
                <label id="lb_error_mobile" style="color: red;">{{$errors->first('mobile')}}</label>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Gender<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="gender" id="gender">
                  <option value="1" id="gender_1" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 1) echo'selected'; ?>>Female</option>
                  <option value="2" id="gender_2" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 2) echo'selected'; ?>>Male</option>
                  <option value="3" id="gender_3" <?php if( old('gender', isset($objEmployee["gender"]) ? $objEmployee["gender"] : null) == 3) echo'selected'; ?>>N/a</option>
                </select>
                <label id="lb_error_gender" style="color: red;">{{$errors->first('gender')}}</label>
              </div>
              <div class="form-group">
                <label>Married<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;"  name="marital_status" id="marital_status">
                  <option value="1" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 1) echo'selected'; ?>>Single</option>
                  <option value="2" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 2) echo'selected'; ?>>Married</option>
                  <option value="3" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 3) echo'selected'; ?>>Separated</option>
                  <option value="4" <?php if( old('marital_status', isset($objEmployee["marital_status"]) ? $objEmployee["marital_status"] : null) == 4) echo'selected'; ?>>Devorce</option>
                </select>
                <label id="lb_error_marital_status" style="color: red;">{{$errors->first('marital_status')}}</label>
              </div>
              <div class="form-group">
                <label>Birthday<strong style="color: red">(*)</strong></label>
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
                <label>Position<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="employee_type_id" id="employee_type_id">
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
                <label id="lb_error_employee_type_id" style="color: red; ">{{$errors->first('employee_type_id')}}</label>
              </div>
              <div class="form-group">
                <label>Role<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;" name="role_id" id="role_id">
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
                <label id="lb_error_role_id" style="color: red; ">{{$errors->first('role_id')}}</label>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Start work date<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" class="form-control pull-right" id="startwork_date" name="startwork_date" id="startwork_date" value="{!! old('startwork_date', isset($objEmployee["startwork_date"]) ? $objEmployee["startwork_date"] : null) !!}">
                    </div>
                    <label id="lb_error_startwork_date" style="color: red;">{{$errors->first('startwork_date')}}</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <br />
                <div class="col-md-3" style="margin-left: 100px;">
                  <button type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                      RESET
                  </button>
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">
                      SAVE
                  </button>
                </div>
              </div>
            </div>
              <!-- /.form-group -->
            {{ Form::close() }}
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
				if(confirmAction("Do you want to reset?"))
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