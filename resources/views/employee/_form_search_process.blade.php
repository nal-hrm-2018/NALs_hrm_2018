<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{ trans('common.label_form.project_name')  }}</button>
                </div>
                {{ Form::text('project_name', '',
                    ['class' => 'form-control',
                    'id' => 'project_name',
                    'autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{  trans('common.label_form.role_name') }}</button>
                </div>
                {!! Form::select(
                    'role',
                    $roles ,
                    null,
                    ['class' => 'form-control' , 'placeholder' => trans('employee_detail.drop_box.placeholder-default')]
                    )
                 !!}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{  trans('common.label_form.status_project') }}</button>
                </div>
                <select name="project_status" class="form-control" >
                    <option selected="selected" value="">{{  trans('employee_detail.drop_box.placeholder-default') }}</option>
                    <option value="1">Kick Off</option>
                    <option value="2">Pending</option>
                    <option value="3">In-Progress</option>
                    <option value="4">Releasing</option>
                    <option value="5">Complete</option>
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{  trans('common.label_form.start_date') }}</button>
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
                    <button type="button" class="btn width-100">{{  trans('common.label_form.start_date') }}</button>
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
