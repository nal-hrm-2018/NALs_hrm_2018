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
            <label>{{trans('vendor.profile_info.email')}} </label><label style="color: red;font-size: large">*</label>
            {{ Form::text('email', old('email'),
                [
                'placeholder'=>trans('vendor.profile_info.email'),
                'class' => 'form-control',
                'id' => 'email',
                'autofocus' => true,
                ])
            }}
            <label style="color: red;">{{$errors->first('email')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.password')}}</label></label><label style="color: red;font-size: large">*</label>
            {{ Form::password('password',
            [
                'class' => 'form-control',
                'id'=>'password',
                'placeholder'=>trans('vendor.profile_info.password')
            ])
            }}
            <label style="color: red; ">{{$errors->first('password')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.confirm_password')}}</label>
            {{ Form::password('confirm_confirmation',
            [
                'class' => 'form-control',
                'id'=>'cfPass',
                'placeholder'=>trans('vendor.profile_info.confirm_password')
            ])
            }}
            <label style="color: red; ">{{$errors->first('confirm_confirmation')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.name')}}</label></label><label style="color: red;font-size: large">*</label>
            {{ Form::text('name', old('name'),
                    [
                    'placeholder'=>trans('vendor.profile_info.name'),
                    'class' => 'form-control',
                    'id' => 'name',
                    'autofocus' => true,
                    ])
                }}
            <label style="color: red; ">{{$errors->first('name')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.address')}}</label></label><label style="color: red;font-size: large">*</label>
            {{ Form::text('address', old('address'),
                    [
                    'placeholder'=>trans('vendor.profile_info.address'),
                    'class' => 'form-control',
                    'id' => 'address',
                    'autofocus' => true,
                    ])
                }}
            <label style="color: red; ">{{$errors->first('address')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.phone')}}</label></label><label style="color: red;font-size: large">*</label>
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
            <label style="color: red; ">{{$errors->first('mobile')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.gender.title')}}</label></label><label style="color: red;font-size: large">*</label>
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
            <label style="color: red; ">{{$errors->first('gender')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.married')}}</label></label><label style="color: red;font-size: large">*</label>
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
            <label style="color: red; ">{{$errors->first('marital_status')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.birthday')}}</label></label><label style="color: red;font-size: large">*</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" id="birthday" name="birthday"
                       value="{{ old('birthday')}}"/>
            </div>
            <label style="color: red; ">{{$errors->first('birthday')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.company')}}</label></label><label style="color: red;font-size: large">*</label>
            {{ Form::text('company', old('company'),
                    [
                    'placeholder'=>trans('vendor.profile_info.company'),
                    'class' => 'form-control',
                    'id' => 'company',
                    'autofocus' => true,
                    ])
                }}
            <label style="color: red; ">{{$errors->first('company')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.position.position')}}</label></label><label style="color: red;font-size: large">*</label>
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
            <label style="color: red; ">{{$errors->first('employee_type_id')}}</label>
        </div>
        <div class="form-group">
            <label>{{trans('vendor.profile_info.role_in_team')}}</label></label><label style="color: red;font-size: large">*</label>
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
            <label style="color: red; ">{{$errors->first('role_id')}}</label>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('vendor.profile_info.start_work_date')}}</label></label><label style="color: red;font-size: large">*</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <input type="date" class="form-control pull-right" id="startwork_date"
                               name="startwork_date"
                               value="{{old('startwork_date')}}"/>
                    </div>
                    <label style="color: red; ">{{$errors->first('startwork_date')}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('vendor.profile_info.end_work_date')}}</label></label><label style="color: red;font-size: large">*</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="endwork_date"
                               name="endwork_date"
                               value="{{ old('endwork_date')}}"/>
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