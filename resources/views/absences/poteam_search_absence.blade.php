<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {{--<input id="number_record_per_page" type="hidden" name="number_record_per_page"--}}
                   {{--value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>--}}
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.name')}}</button>
                </div>
                {{ Form::text('name', old('name'),
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
                {{ Form::text('email', old('email'),
                    ['class' => 'form-control',
                    'id' => 'email_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.start_date')}}</button>
                </div>
                {{ Form::date('start_date', old('start_date'),
                    ['class' => 'form-control',
                    'id' => 'start_date_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.end_date')}}</button>
                </div>
                {{ Form::date('end_date', old('end_date'),
                    ['class' => 'form-control',
                    'id' => 'end_date_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.type')}}</button>
                </div>
                <select name="role" id="role" class="form-control">
                    <option value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                </select>
            </div>

        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.reason')}}</button>
                </div>
                {{ Form::text('reason', old('reason'),
                    ['class' => 'form-control',
                    'id' => 'reason_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.note')}}</button>
                </div>
                {{ Form::text('note', old('note'),
                    ['class' => 'form-control',
                    'id' => 'note_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.status')}}</button>
                </div>
                <select name="role" id="role" class="form-control">
                    <option value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                </select>
            </div>
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('absence_po.list_po.profile_info.note_po')}}</button>
                </div>
                {{ Form::text('note_po', old('note_po'),
                    ['class' => 'form-control',
                    'id' => 'note_po_absence',
                    'autofocus' => false,
                    ])
                }}
            </div>
        </div>
        {{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="input-group margin">
                <div class="input-group-btn">
                    <button type="button" class="btn width-100">{{trans('vendor.profile_info.role')}}</button>
                </div>
                <select name="role" id="role" class="form-control">
                    <option {{ !empty(request('role'))?'':'selected="selected"' }} value="">
                        {{  trans('vendor.drop_box.placeholder-default') }}
                    </option>
                    @foreach($roles as $key=>$value)
                        <option value="{{ $value }}" {{ (string)$value===request('role')?'selected="selected"':'' }}>
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
                            {{trans('vendor.profile_info.status_children.'.$value)}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>--}}
    </div>

</div>