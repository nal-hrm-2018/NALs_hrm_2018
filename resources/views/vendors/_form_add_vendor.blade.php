{!! Form::open(
[
    'url' =>route('vendors.store'),
    'method'=>'POST',
    'id'=>'form_create_vendor',
    'class'=>'form-horizontal',
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3">
        <CENTER>
            <div>
                <img src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}"/>
            </div>
        </CENTER>
        <div class="row" style="margin-top: 20px;">
            <CENTER><label>{{trans('vendor.label.avatar')}}</label></CENTER>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <!-- /.form-group -->
        <div class="form-group">
            <label>{{trans('vendor.profile_info.email')}}<strong style="color: red">(*)</strong> </label>
            {{ Form::text('email', old('email'),
                [
                'placeholder'=>trans('vendor.profile_info.email'),
                'class' => 'form-control',
                'id' => 'email',
                'autofocus' => true,
                ])
            }}
            <label id="lb_error_email" style="color: red;">{{$errors->first('email')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.password')}}<strong style="color: red">(*)</strong></label>
            {{ Form::password('password',
            [
                'class' => 'form-control',
                'id'=>'password',
                'placeholder'=>trans('vendor.profile_info.password')
            ])
            }}
            <label id="lb_error_password" style="color: red; ">{{$errors->first('password')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.confirm_password')}}<strong style="color: red">(*)</strong></label>
            {{ Form::password('confirm_confirmation',
            [
                'class' => 'form-control',
                'id'=>'cfPass',
                'placeholder'=>trans('vendor.profile_info.confirm_password')
            ])
            }}
            <label id="lb_error_password_confirm" style="color: red; ">{{$errors->first('confirm_confirmation')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.name')}}<strong style="color: red">(*)</strong></label>
            {{ Form::text('name', old('name'),
                    [
                    'placeholder'=>trans('vendor.profile_info.name'),
                    'class' => 'form-control',
                    'id' => 'name',
                    'autofocus' => true,
                    ])
                }}
            <label id="lb_error_name" style="color: red; ">{{$errors->first('name')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.address')}}<strong style="color: red">(*)</strong></label>
            {{ Form::text('address', old('address'),
                    [
                    'placeholder'=>trans('vendor.profile_info.address'),
                    'class' => 'form-control',
                    'id' => 'address',
                    'autofocus' => true,
                    ])
                }}
            <label id="lb_error_address" style="color: red; ">{{$errors->first('address')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.phone')}}<strong style="color: red">(*)</strong></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </div>
                {{ Form::number('mobile', old('mobile'),
                    [
                    'placeholder'=>trans('vendor.profile_info.phone'),
                    'class' => 'form-control',
                    'id' => 'mobile',
                    'autofocus' => true,
                    ])
                }}

            </div>
            <label id="lb_error_mobile" style="color: red; ">{{$errors->first('mobile')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.gender.title')}}<strong style="color: red">(*)</strong></label>
            <select name="gender" id="gender" class="form-control select2">
                <option {{ !empty(old('gender'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($genders as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('gender')?'selected="selected"':'' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <label id="lb_error_gender" style="color: red;">{{$errors->first('gender')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.married')}}<strong style="color: red">(*)</strong></label>
            <select name="marital_status" id="married" class="form-control select2">
                <option {{ !empty(old('marital_status'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($marries as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('marital_status')?'selected="selected"':'' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <label id="lb_error_marital_status" style="color: red;">{{$errors->first('marital_status')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.birthday')}}<strong style="color: red">(*)</strong></label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" id="birthday" name="birthday"
                       value="{{ old('birthday')}}"/>
            </div>
            <label id="lb_error_birthday" style="color: red; ">{{$errors->first('birthday')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.company')}}<strong style="color: red">(*)</strong></label>
            {{ Form::text('company', old('company'),
                    [
                    'placeholder'=>trans('vendor.profile_info.company'),
                    'class' => 'form-control',
                    'id' => 'company',
                    'autofocus' => true,
                    ])
                }}
            <label id="lb_error_company" style="color: red; ">{{$errors->first('company')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.position.position')}}<strong style="color: red">(*)</strong></label>
            <select name="employee_type_id" id="position" class="form-control select2">
                <option {{ !empty(old('employee_type_id'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($employeeTypes as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('employee_type_id')?'selected="selected"':'' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <label id="lb_error_employee_type_id" style="color: red; ">{{$errors->first('employee_type_id')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.role_in_team')}}<strong style="color: red">(*)</strong></label>
            <select name="role_id" id="role_team" class="form-control select2">
                <option {{ !empty(old('role_id'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($roles as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('role_id')?'selected="selected"':'' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <label id="lb_error_role_id" style="color: red; ">{{$errors->first('role_id')}}</label>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('vendor.profile_info.start_work_date')}}<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <input type="date" class="form-control pull-right" id="startwork_date"
                               name="startwork_date"
                               value="{{old('startwork_date')}}"/>
                    </div>
                    <label id="lb_error_startwork_date" style="color: red; ">{{$errors->first('startwork_date')}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('vendor.profile_info.end_work_date')}}<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="endwork_date"
                               name="endwork_date"
                               value="{{ old('endwork_date')}}"/>
                    </div>
                    <label id="lb_error_endwork_date" style="color: red; ">{{$errors->first('endwork_date')}}</label>
                    <!-- /.input group -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
    <div class="col-md-6" style="display: inline; ">
        <div style="float: right;">
            <button id="btn_reset_form_vendor" type="button" class="btn btn-default"><span
                        class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
            </button>
        </div>
    </div>
    <div class="col-md-2" style="display: inline;">
        <div style="float: right;">
            <button type="submit" class="btn btn-info pull-left">{{trans('vendor.button.add_vendor')}}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
<style>
    button.btn.btn-info.pull-left {
        float: left;
        width:  115px;
    }
</style>