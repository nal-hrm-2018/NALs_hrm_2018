<section class="content-header">
    <div>
        <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal" id="btn-search">
            SEARCH
        </button>
        <button type="button" class="btn btn-default">
            <a href="{{ asset('projects/create')}}"><i class="fa fa-user-plus"></i> ADD</a>
        </button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="get" role="form" id="form_search_employee" onsubmit="return validate();">
                    <!-- Modal content-->
                    <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                           value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Project Name</button>
                                        </div>
                                        {{--<input type="text" name="name" id="project_name" class="form-control"
                                               value="{{!empty(request('name'))?request('name'):null}}"/>--}}
                                        {{ Form::text('name', old('name'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_name',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_project_name"></label>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">PO Name</button>
                                        </div>
                                        {{--<input type="text" name="po_name" id="project_po_name" class="form-control"--}}
                                               {{--value="{{!empty(request('po_name'))?request('po_name'):null}}"/>--}}
                                        {{ Form::text('po_name', old('po_name'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_po_name',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_po_name"></label>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Member's</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="number" name="number_from" id="project_number_from" class="form-control"--}}
                                                       {{--value="{{!empty(request('number_from'))?request('number_from'):null}}"/>--}}
                                                {{ Form::number('number_from', old('number_from'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_number_from',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="number" name="number_to" id="project_number_to" class="form-control"--}}
                                                       {{--value="{{!empty(request('number_to'))?request('number_to'):null}}"/>--}}
                                                {{ Form::number('number_to', old('number_to'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_number_to',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_number"></label>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Employee Name</button>
                                        </div>
                                        {{--<input type="text" name="name_member" id="project_name_member" class="form-control"--}}
                                               {{--value="{{!empty(request('name_member'))?request('name_member'):null}}"/>--}}
                                        {{ Form::text('name_member', old('name_member'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_name_member',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_project_name_member"></label>

                                </div>

                                <span class="glyphicon glyphicon-arrow-right"></span>
                                <span class="glyphicon glyphicon-arrow-right number-2"></span>
                                <span class="glyphicon glyphicon-arrow-right number-3"></span>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Est. Date</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="date" name="project_date_from" id="project_date_from" class="form-control"--}}
                                                       {{--value="{{!empty(request('project_date_from'))?request('project_date_from'):null}}"/>--}}
                                                {{ Form::date('project_date_from', old('project_date_from'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_date_from',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="date" name="project_date_to" id="project_date_to" class="form-control"--}}
                                                       {{--value="{{!empty(request('project_date_to'))?request('project_date_to'):null}}"/>--}}
                                                {{ Form::date('project_date_to', old('project_date_to'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_date_to',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_project_date"></label>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Real Date</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="date" name="project_date_real_from" id="project_date_real_from" class="form-control"--}}
                                                       {{--value="{{!empty(request('project_date_real_from'))?request('project_date_real_from'):null}}"/>--}}
                                                {{ Form::date('project_date_real_from', old('project_date_real_from'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_date_real_from',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                {{--<input type="date" name="project_date_real_to" id="project_date_real_to" class="form-control"--}}
                                                       {{--value="{{!empty(request('project_date_real_to'))?request('project_date_real_to'):null}}"/>--}}
                                                {{ Form::date('project_date_real_to', old('project_date_real_to'),
                                                    ['class' => 'form-control',
                                                    'id' => 'project_date_real_to',
                                                    'autofocus' => false,
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_project_date_real"></label>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn width-100">Status</button>
                                        </div>
                                        <select name="status" id="project_status" class="form-control">
                                            <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">
                                                {{  trans('employee.drop_box.placeholder-default') }}
                                            </option>
                                            @foreach($getAllStatusInStatusTable as $getStatusInStatusTable)
                                                <option value="{{ $getStatusInStatusTable->name }}" {{ (string)$getStatusInStatusTable->name ===request('status')?'selected="selected"':'' }}>
                                                    {{ $getStatusInStatusTable->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label style="color: red; margin-left: 130px;" id="error_project_status"></label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer center">
                            <button id="btn_reset_edit_password" type="button" class="btn btn-default"><span
                                        class="fa fa-refresh"></span>
                                RESET
                            </button>
                            <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                        class="fa fa-search"></span>
                                SEARCH
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>