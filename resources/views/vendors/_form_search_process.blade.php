<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                   value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('project.name')  }}</button>
                </div>
                {{ Form::text('project_name', old('project_name'),
                    ['class' => 'form-control',
                    'id' => 'project_name',
                    'autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('project.role')  }}</button>
                </div>
                <select name="role" id="role" class="form-control">
                    <option {{ !empty(request('role'))?'':'selected="selected"' }} value="">
                        {{  trans('employee.drop_box.placeholder-default') }}
                    </option>
                    @foreach($roles as $key=>$value)
                        <option value="{{ $key }}" {{ (string)$key===request('role')?'selected="selected"':'' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('project.status')  }}</button>

                </div>
                <select name="project_status" id="project_status" class="form-control">
                    <option {{ !empty(request('project_status'))?'':'selected="selected"' }} value="">
                        {{  trans('employee.drop_box.placeholder-default') }}
                    </option>
                    @foreach($project_statuses as $key=>$value)
                        <option value="{{ $key }}" {{ (string)$key===request('project_status')?'selected="selected"':'' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('project.start_date')  }}</button>
                </div>
                {{ Form::date('start_date', '',
                   ['class' => 'form-control',
                    'id' => 'start_date',
                    'autofocus' => true
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('project.end_date')  }}</button>
                </div>
                {{ Form::date('end_date', '',
                    ['class' => 'form-control',
                    'id' => 'end_date',
                    'autofocus' => true,
                    ])
                }}
            </div>
        </div>
    </div>

</div>
