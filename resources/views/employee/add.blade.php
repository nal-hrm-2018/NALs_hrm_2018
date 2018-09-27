@extends('admin.template')
@section('content')
    <style>
        * {box-sizing: border-box;}

        .container {
            position: relative;
            width: auto;
        }

        .image {
            display: block;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;

        }

        .overlay {
            position: absolute;
            bottom: 0;
            font-size: 12px;
            background: rgb(0, 0, 0);
            background: rgba(0, 0, 0, 0.5); / Black see-through /
            color: #f1f1f1;
            width: 100%;
            transition: .5s ease;
            opacity:0;
            color: white;
            font-size: 12px;
            text-align: center;
        }

        .form-group {
            width: 90% !important;
        }

        .container:hover .overlay {
            opacity: 1;
        }

        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            width: 170px !important;
            max-width: unset !important;
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('common.path.add_employee')}}
                <small>NAL Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="/"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>--}}
                {{--<li><a href="/employee">{{trans('common.path.employee')}}</a></li>--}}
                {{--<li class="active">{{trans('common.path.add')}}</li>--}}
            {{--</ol>--}}
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div id="msg">
                </div>
                    <SCRIPT LANGUAGE="JavaScript">
                        function confirmAction() {
                             var name = $('#name').val();
                            return confirm(message_confirm_add('{{trans("common.action_confirm.add")}}', '{{trans("common.name_confirm.employee")}}', name));
                        }
                    </SCRIPT>
                    <div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
                    <form action="{{asset('employee')}}" method="post" class="form-horizontal" enctype = 'multipart/form-data'
                          onSubmit="return confirmAction()">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-4">
                                <center>
                                    <div class="container">
                                        <img src="{!! asset('/avatar/default_avatar.png') !!}" id="image" class="image img-circle profile-user-img"/><br>
                                        <label for="chooseimg" class="custom-file-upload">
                                            <i class="fa fa-cloud-upload"></i> {{trans('employee.upload_avatar')}}
                                        </label>
                                        <input type="file" id="chooseimg" name="picture" class="form-control overlay" placeholder="Chọn ảnh" accept="image/*" id="myDIV"/>
                                    </div>
                                </center>
                                <script type="text/javascript">
                                    var file = document.getElementById('chooseimg');
                                    var img = document.getElementById('image');
                                    file.addEventListener("change", function() {
                                        if (this.value) {
                                            var file = this.files[0];
                                            var reader = new FileReader();
                                            reader.onloadend = function () {
                                                img.src = reader.result;
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                </script>
                                <div class="" style="margin-top: 20px;">
                                    <label style="margin-left: 23px;color:red;" id="lb_error_name" style="color: red;">{{$errors->first('picture')}}</label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <!-- /.form-group -->  
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.email')}}<strong style="color: red">(*)</strong></label>
                                    <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.email')}}" name="email"
                                           id="email" value="{!! old('email') !!}{{ isset($employee) ? $employee->email : null}}">
                                    <label id="lb_error_email" style="color: red;">{{$errors->first('email')}}</label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.password')}}<strong style="color: red">(*)</strong></label>
                                    <input type="password" class="form-control" placeholder="{{trans('employee.profile_info.password')}}" name="password"
                                           id="password" value="123456">
                                    <label id="lb_error_password" style="color: red; ">{{$errors->first('password')}}</label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.password_confirm')}}<strong style="color: red">(*)</strong></label>
                                    <input type="password" class="form-control" placeholder="{{trans('employee.profile_info.password_confirm')}}"
                                           name="confirm_confirmation" id="cfPass" value="123456">
                                    <label id="lb_error_password_confirm" style="color: red; ">{{$errors->first('confirm_confirmation')}}</label>
                                    <!-- /.input group -->
                                </div>
                                
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.gender.title')}}<strong style="color: red">(*)</strong></label>
                                    <select id="gender" class="form-control select2" style="width: 100%;" name="gender">
                                        <option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
                                        <option value="1"
                                        <?php
                                            if (old('gender') == 1) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->gender == 1)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.gender.female')}}
                                        </option>
                                        <option value="2"
                                        <?php
                                            if (old('gender') == 2) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->gender == 2)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.gender.male')}}
                                        </option>
                                        <option value="3"
                                        <?php
                                            if (old('gender') == 3) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->gender == 3)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.gender.na')}}
                                        </option>
                                    </select>
                                    <label id="lb_error_gender" style="color: red;">{{$errors->first('gender')}}</label>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.marital_status.title')}}<strong style="color: red">(*)</strong></label>
                                    <select id="married" class="form-control select2" style="width: 100%;" name="marital_status">
                                        <option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
                                        <option value="1"
                                        <?php
                                            if (old('marital_status') == 1) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->marital_status == 1)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.marital_status.single')}}
                                        </option>
                                        <option value="2"
                                        <?php
                                            if (old('marital_status') == 2) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->marital_status == 2)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.marital_status.married')}}
                                        </option>
                                        <option value="3"
                                        <?php
                                            if (old('marital_status') == 3) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->marital_status == 3)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.marital_status.separated')}}
                                        </option>
                                        <option value="4"
                                        <?php
                                            if (old('marital_status') == 4) echo 'selected';
                                            if (isset($employee)) {
                                                if ($employee->marital_status == 4)
                                                    echo 'selected';
                                            }
                                            ?>
                                        >{{trans('employee.profile_info.marital_status.divorced')}}
                                        </option>
                                    </select>
                                    <label id="lb_error_marital_status" style="color: red;">{{$errors->first('marital_status')}}</label>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.birthday')}}<strong style="color: red">(*)</strong></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right" id="birthday" name="birthday"

                                               value="{{ old('birthday')}}<?php if (isset($employee)) {
                                                   echo $employee->birthday;
                                               }?>"
                                               style="height: 33px;">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; ">{{$errors->first('birthday')}}</label>
                                    <!-- /.input group -->
                                </div>
                                
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.team')}}<strong style="color: red">(*)</strong></label><br>
                                    @foreach ($dataTeam as $val)
                                       @if ($val["name"] == "NALs") 
                                            <div style="display: inline-block;width: 130px;"><input type="checkbox" name="team_id[]" checked value="<?php echo $val["id"]; ?>">&ensp;<?php echo $val["name"];?></div>
                                        @else
                                            <div style="display: inline-block;width: 130px;"><input type="checkbox" name="team_id[]" value="<?php echo $val["id"]; ?>">&ensp;<?php echo $val["name"];?></div>
                                        @endif
                                    @endforeach
                                    <label id="lb_error_team_id" style="color: red; ">{{$errors->first('team_id')}}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.name')}}<strong style="color: red">(*)</strong></label>
                                    <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.name')}}" name="name" id="name"
                                           value="{!! old('name') !!}@if(isset($employee)){{ $employee->name }}@endif">
                                    <label id="lb_error_name" style="color: red; ">{{$errors->first('name')}}</label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.address')}}<strong style="color: red">(*)</strong></label>
                                    <input type="text" class="form-control" placeholder="{{trans('employee.profile_info.address')}}" name="address"
                                           id="address"
                                           value="{!! old('address') !!}@if(isset($employee)){{ $employee->address }}@endif">
                                    <label id="lb_error_address" style="color: red; ">{{$errors->first('address')}}</label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.phone')}}<strong style="color: red">(*)</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="number" class="form-control" placeholder="{{trans('employee.profile_info.phone')}}" name="mobile"
                                               id="mobile"
                                               value="{!! old('mobile') !!}@if(isset($employee)){{ $employee->mobile }}@endif">
                                    </div>
                                    <label id="lb_error_mobile" style="color: red; ">{{$errors->first('mobile')}}</label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.position')}}<strong style="color: red">(*)</strong></label>
                                    <select id="position" class="form-control select2" style="width: 100%;" name="contractual_type_id">
                                        <option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
                                        <?php
                                        foreach ($contractualTypes as $val) {
                                            $selected = "";
                                            if ($val["id"] == old('contractual_type_id')) {
                                                $selected = "selected";
                                            }
                                            if (isset($employee)) {
                                                if ($employee->contractual_type_id == $val["id"]) {
                                                    $selected = "selected";
                                                }
                                            }
                                            switch ($val["name"]) {
                                                case 'Internship':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.internship'). '</option>';
                                                    break;
                                                case 'Probationary':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.probatination'). '</option>';
                                                    break;
                                                case 'One-year':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.one-year'). '</option>';
                                                    break;
                                                case 'Three-year':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.three-year'). '</option>';
                                                    break;
                                                case 'Indefinite':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.indefinite'). '</option>';
                                                    break;
                                                case 'Part-time':
                                                    echo '<option value="' . $val["id"] . '" ' . $selected . '>' .trans('employee.contract.part-time'). '</option>';
                                                    break;
                                                
                                                default:
                                                    break;
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label id="lb_error_contractual_type_id" style="color: red; ">{{$errors->first('contractual_type_id')}}</label>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.role')}}<strong style="color: red">(*)</strong></label>
                                    <select id="role_team" class="form-control select2" style="width: 100%;" name="role_id">
                                        <option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
                                        <?php
                                        foreach ($dataRoles as $val) {
                                            $selected = "";
                                            if ($val["id"] == old('role_id')) {
                                                $selected = "selected";
                                            }
                                            if (isset($employee)) {
                                                if ($employee->role_id == $val["id"]) {
                                                    $selected = "selected";
                                                }
                                            }
                                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . $val["name"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label id="lb_error_role_id" style="color: red; ">{{$errors->first('role_id')}}</label>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('employee.profile_info.start_work')}}<strong style="color: red">(*)</strong></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>

                                        <input type="date" class="form-control pull-right" id="startwork_date"
                                               name="startwork_date"
                                               style="height: 33px;"
                                               value="{{date('Y-m-d')}}">
                                    </div>
                                    <label id="lb_error_startwork_date" style="color: red; ">{{$errors->first('startwork_date')}}</label>
                                </div>
                            
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                            <div class="col-md-6" style="display: inline; ">
                                <div style="float: right;">
                                    <button id="btn_reset_form_employee" type="button" class="btn btn-default"><span
                                        class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div>
                                    <button type="submit" class="btn btn-info">{{ trans('common.button.add')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
                    <script type="text/javascript"
                            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                    <script>
                        $(function () {
                            $("#btn_reset_form_employee").bind("click", function () {
                                if(confirm('{{trans('common.confirm_reset')}}')){
                                    $("#lb_error_email").empty();
                                    $("#lb_error_password").empty();
                                    $("#lb_error_address").empty();
                                    $("#lb_error_birthday").empty();
                                    $("#lb_error_contractual_type_id").empty();
                                    $("#lb_error_endwork_date").empty();
                                    $("#lb_error_startwork_date").empty();
                                    $("#lb_error_gender").empty();
                                    $("#lb_error_marital_status").empty();
                                    $("#lb_error_mobile").empty();
                                    $("#lb_error_name").empty();
                                    $("#lb_error_role_id").empty();
                                    $("#lb_error_team_id").empty();
                                    $("#lb_error_password_confirm").empty();
                                    $("#email").val('');
                                    $("#password").val('');
                                    $("#cfPass").val('');
                                    $("#name").val('');
                                    $("#address").val('');
                                    $("#mobile").val('');
                                    $("#gender").val('').change();
                                    $("#married").val('').change();
                                    $("#team_id").val('').change();
                                    $('input[type=checkbox]').prop('checked',false);
                                    $("#role_team").val('').change();
                                    $("#position").val('').change();
                                    $("#birthday").val('value', '');
                                    $("#startwork_date").val('value', '');
                                    $("#endwork_date").val('value', '');
                                }
                            });
                        });
                    </script>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <style>
        button.btn.btn-info.pull-left {
            float:  left;
            width: 115px;
        }
    </style>
@endsection