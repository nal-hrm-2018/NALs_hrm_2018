<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <input type="hidden" name="id" value="{{ $employee->id  }}"/>
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">Project Name</button>
                </div>
                {{ Form::text('project_name', '',
                    ['class' => 'form-control',
                    'id' => 'project_name','autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">Role</button>
                </di
                    <select name="role" class="form-control">
                        <option>Select Role</option>
                        <option>PO</option>
                        <option>TeamDev</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group margin">
                    <div class="input-group-btn">
                        <button type="button" class="btn width-100">Start Date</button>
                    </div>
                    {{ Form::date('start_date', '',
                       ['class' => 'form-control',
                                  ['class' => 'form-control',
                        'id' => 'start_date', 'autofocus' => true
                        ])
                    }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">End Date</button>
                </div>
                {{ Form::date('end_date', '',
                    ['class' => 'form-control',
                    'id' => 'end_date','autofocus' => true,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">Status</button>
                </div>
                <select class="form-control">
                    <option>Kick Off</option>
                    <option>Pending</option>
                    <option>In-Progress</option>
                    <option>Releasing</option>
                    <option>Complete</option>
                </select>
            </div>
        </div>
    </div>
</div>