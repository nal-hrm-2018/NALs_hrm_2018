<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.id')}}</button>
                </div>
                {{ Form::text('id', old('id'),
                    ['class' => 'form-control',
                    'id' => 'employeeId',
                    'autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.name')}}</button>
                </div>
                {{ Form::text('name', old('name'),
                    ['class' => 'form-control',
                    'id' => 'employeeName',
                    'autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.company')}}</button>
                </div>
                {{ Form::text('company', old('company'),
                    ['class' => 'form-control',
                    'id' => 'employeeCompany',
                    'autofocus' => true,
                    ])
                }}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.email')}}</button>
                </div>
                {{ Form::email('email', old('email'),
                [
                    'class' => 'form-control',
                    'id'=>'employeeEmail'
                ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.role')}}</button>
                </div>
                <select name="role_in_process" id="role_in_process" class="form-control">
                    <option {{ !empty(request('role_in_process'))?'':'selected="selected"' }} value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                    @foreach($roles as $key=>$value)
                        <option value="{{ $key }}" {{ (string)$key===request('role_in_process')?'selected="selected"':'' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.status')}}</button>
                </div>
                <select name="status" id="status" class="form-control">
                    <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                    @foreach($status as $key=>$value)
                        <option value="{{ $key }}" {{ (string)$key===request('status')?'selected="selected"':'' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

</div>