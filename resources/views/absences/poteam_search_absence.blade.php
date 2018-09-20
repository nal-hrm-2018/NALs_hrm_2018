<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                   value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.name')}}</button>
                </div>
                {{ Form::text('name', $requestSearch['name'],
                    ['class' => 'form-control',
                    'id' => 'name_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.email')}}</button>
                </div>
                {{ Form::text('email', $requestSearch['email'],
                    ['class' => 'form-control',
                    'id' => 'email_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>

            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.type')}}</button>
                </div>
                <select name="type" id="type" class="form-control">
                    <option value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                    @foreach($getAllAbsenceTypes as $key=>$value)
                        <option value="{{ $value['name'] }}" {{ (string)$value['name']===request('type')?'selected="selected"':'' }}>
                            {{trans('absence_po.list_po.type.'.$value["name"] )}}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.start_date')}}</button>
                </div>
                {{ Form::text('start_date', $requestSearch['start_date'],
                    ['class' => 'form-control form_datetime',
                    'id' => 'start_date_absence',
                    'autofocus' => false,
                    'placeholder'=>"yyyy-MM-dd HH:mm"
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.end_date')}}</button>
                </div>
                {{ Form::text('end_date', $requestSearch['end_date'],
                    ['class' => 'form-control form_datetime',
                    'id' => 'end_date_absence',
                    'autofocus' => false,
                    'placeholder'=>"yyyy-MM-dd HH:mm"
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.status')}}</button>
                </div>
                <select name="absence_status" id="absence_status" class="form-control">
                    <option value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                    @foreach($getAllAbsenceStatus as $key=>$value)
                        <option value="{{ $value['name'] }}" {{ (string)$value['name']===request('absence_status')?'selected="selected"':'' }}>
                            {{trans('absence_po.list_po.status.'.$value["name"] )}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

</div>