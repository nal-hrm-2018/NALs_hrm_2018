{!! Form::open(
['url' =>route('projects.store'),
'method'=>'Post',
'id'=>'form_add_project',
'class'=>"form-horizontal"
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="list_error" class="col-md-12 alert alert-danger" style="display: none">
    @if(session()->has('error_messages'))
        <script>
            $(function () {
                $("#list_error").css('display', 'block');
            })
        </script>
        @foreach(session()->get('error_messages') as $key=>$values)
            {{trans('common.path.employee')." ( id : ".getIdEmployeefromProcessError($key)." ) : ".
            (!is_null(getEmployee((int)getIdEmployeefromProcessError($key)))?getEmployee((int)getIdEmployeefromProcessError($key))->name:'id wrong')
            }}
            <script>
                $(document).ready(function () {
                    $('#tr_member_'+'{{$key}}').css('background','#DD0000');
                })
            </script>
            <br>
            @foreach($values['errors']->all() as $value)
                @if(!empty($value))
                    {{trans('common.error').": ".$value }}<br>
                @endif
            @endforeach
            @if(!empty($values['available_processes']))
                @php
                    echo showListAvailableProcesses($values['available_processes']);
                @endphp
            @endif
        @endforeach
    @endif
    @if($errors->any())
        <script>
            $(function () {
                $("#list_error").css('display', 'block');
            })
        </script>
        @foreach($errors->all() as $key=>$error)
            @if(!empty($error))
                {{trans('common.error').": ".$error }}<br>
            @endif
        @endforeach
    @endif
</div>
<div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-4">
        <div>
            <label>{{trans('project.id')}}<strong style="color: red">(*)</strong> </label>
            {{ Form::text('id', old('id'),
                ['class' => 'form-control',
                'id' => 'id',
                'autofocus' => true,
                'placeholder'=>trans('project.id'),
                ])
            }}
            {{--<label class="id" id="lb_error_project_id" style="color: red; ">{{$errors->first('id')}}</label>--}}
        </div>
        <div>
            <label>{{trans('project.project_name')}}<strong style="color: red">(*)</strong> </label>
            {{ Form::text('name', old('name'),
                ['class' => 'form-control',
                'id' => 'name',
                'autofocus' => true,
                'placeholder'=>trans('project.project_name'),
                ])
            }}
            {{--<label class="name" id="lb_error_project_name" style="color: red; ">{{$errors->first('name')}}</label>--}}
        </div>
        <div>
            <label>{{trans('project.estimate_start_date')}}<strong style="color: red">(*)</strong> </label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="estimate_start_date"
                       id="estimate_start_date"
                       value="{{ old('estimate_start_date')}}"/>

            </div>
        {{--<label class="estimate_start_date" id="lb_error_estimate_start_date"--}}
        {{--style="color: red; ">{{$errors->first('estimate_start_date')}}</label>--}}
        <!-- /.input group -->
        </div>
        <div>
            <label>{{trans('project.estimate_end_date')}}<strong style="color: red">(*)</strong> </label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="estimate_end_date" id="estimate_end_date"
                       value="{{ old('estimate_end_date')}}">

            </div>
        {{--<label class="estimate_end_date" id="lb_error_estimate_end_date"--}}
        {{--style="color: red; ">{{$errors->first('estimate_end_date')}}</label>--}}
        <!-- /.input group -->
        </div>
        <div>
            <label>{{trans('project.start_date_real')}}</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="start_date_project" id="start_date_project"
                       value="{{ old('start_date_project')}}">

            </div>
        {{--<label class="start_date_project" id="lb_error_start_date_project"--}}
        {{--style="color: red; ">{{$errors->first('start_date_project')}}</label>--}}
        <!-- /.input group -->
        </div>
        <div>
            <label>{{trans('project.end_date_real')}}</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="end_date_project" id="end_date_project"
                       value="{{ old('end_date_project')}}">
            </div>
        {{--<label class="end_date_project" id="lb_error_end_date_project"--}}
        {{--style="color: red; ">{{$errors->first('end_date_project')}}</label>--}}
        <!-- /.input group -->
        </div>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div>
            <label>{{trans('project.income')}}<strong style="color: red">(*)</strong> </label>
            {{ Form::number('income', old('income'),
                ['class' => 'form-control',
                'id' => 'income',
                'autofocus' => true,
                'placeholder'=>trans('project.income'),
                ])
            }}
            {{--<label id="lb_error_income" style="color: red;">{{$errors->first('income')}}</label>--}}
        </div>
        <div>
            <label>{{trans('project.estimate_cost')}}</label>
            {{ Form::text('estimate_cost', old('estimate_cost'),
                ['class' => 'form-control',
                'id' => 'estimate_cost',
                'autofocus' => true,
                'placeholder'=>trans('project.estimate_cost'),
                'readonly'=>'readonly',
                ])
            }}
            {{--<label id="lb_error_estimate_cost" style="color: red;"></label>--}}
        </div>
        <div>
            <label>{{trans('project.real_cost')}}</label>
            {{ Form::number('real_cost', old('real_cost'),
                ['class' => 'form-control',
                'id' => 'real_cost',
                'autofocus' => true,
                'placeholder'=>trans('project.real_cost'),
                ])
            }}
            {{--<label id="lb_error_real_cost" style="color: red;">{{$errors->first('real_cost')}}</label>--}}
        </div>
        <div>
            <label>{{trans('project.description')}}</label>
            {{ Form::textarea('description', old('description'),
                ['class' => 'form-control',
                'id' => 'description',
                'autofocus' => true,
                'placeholder'=>trans('project.description'),
                'rows' => '4',
                ])
            }}
            {{--<label id="lb_error_description" style="color: red;"></label>--}}
        </div>
        <div>
            <label>{{trans('project.status')}}<strong style="color: red">(*)</strong> </label><br/>
            <select name="status" id="status" class="form-control">
                <option {{ !empty(old('status'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($project_status as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('status')?'selected="selected"':'' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            {{--<label id="lb_error_project_status" style="color: red; ">{{$errors->first('status')}}</label>--}}
        </div>
        </div>
</div>
<div class="col-md-2">
    <button type="button" id="btn_add_process" class="btn btn-info ">
        <i class="fa fa-user-plus"></i> {{trans('common.button.add')}}
    </button>
</div>
<div class="col-md-6" style="width: 100% ; margin-bottom: 2em"></div>
<div class="col-md-2">
    <label>{{trans('project.members')}} <strong style="color: red">(*)</strong> </label><br/>
    <select name="employee_id" id="employee_id" class="form-control select2">
        <option {{ !empty(old('employee_id'))?'':'selected="selected"' }} value="">
            {{  trans('vendor.drop_box.placeholder-default') }}
        </option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}"
                    {{ (string)$employee->id===old('employee_id')?'selected="selected"':'' }}
                    id="member_{{ $employee->id }}">{{ $employee->name }}</option>
        @endforeach
    </select>
</div>
<div class="col-md-2">
    <label>{{trans('project.man_power')}} <strong style="color: red">(*)</strong> </label><br/>
    <select name="man_power" id="man_power" class="form-control">
        <option {{ !empty(old('man_power'))?'':'selected="selected"' }} value="">
            {{  trans('vendor.drop_box.placeholder-default') }}
        </option>
        @foreach($manPowers as $key=>$value)
            <option value="{{ $value }}" {{ (string)$value===old('man_power')?'selected="selected"':'' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-2">
    <label>{{trans('project.role')}} <strong style="color: red">(*)</strong> </label><br/>
    <select name="role_id" id="role" class="form-control">
        <option {{ !empty(old('role_id'))?'':'selected="selected"' }} value="">
            {{  trans('vendor.drop_box.placeholder-default') }}
        </option>
        @foreach($roles as $key=>$value)
            <option value="{{ $key }}" {{ (string)$key===old('role_id')?'selected="selected"':'' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-3">
    <label>{{trans('project.process_start_date')}} <strong style="color: red">(*)</strong> </label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="date" class="form-control  " name="start_date_process" id="start_date_process"
               value="{{ old('start_date_process')}}">
    </div>
    <!-- /.input group -->
</div>
<div class="col-md-3">
    <label>{{trans('project.process_end_date')}}<strong style="color: red">(*)</strong> </label>
    <div class="input-group date ">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="date" class="form-control " name="end_date_process" id="end_date_process"
               value="{{ old('end_date_process')}}">
    </div>
    <!-- /.input group -->
</div>
<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
{{--table--}}
<div id="table_add" class="col-md-12" style="display: block">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        </thead>
        <tbody id="list_add">

        @if(session()->has('processes'))
            @foreach(session()->get('processes') as $process)
                @if((string)($process['delete_flag'])==='0')
                    <tr id="tr_member_{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}">
                @else
                    <tr style="display: none"
                        id="tr_member_{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}">
                        @endif
                        <input class="process_id" type="hidden"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][id]"
                               value="{{$process['id']}}">
                        <input class="delete_flag" type="hidden"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][delete_flag]"
                               value="{{$process['delete_flag']}}">
                        <input class="employee_id" type="hidden"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][employee_id]"
                               value="{{$process['employee_id']}}">
                        <input type="hidden"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][man_power]"
                               value="{{$process['man_power']}}">
                        <input class="role_id" type="hidden"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][role_id]"
                               value="{{$process['role_id']}}">
                        <input type="hidden" class="start_date_process"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][start_date_process]"
                               value="{{$process['start_date_process']}}">
                        <input type="hidden" class="end_date_process"
                               name="processes[{{$process['employee_id']}}_{{$process['end_date_process']}}{{$process['id']}}][end_date_process]"
                               value="{{$process['end_date_process']}}">
                    <td class="employee_name" style="width: 17%;">
                        {{
                        !is_null(getEmployee($process['employee_id']))?
                        getEmployee($process['employee_id'])->name:''
                        }}
                    </td>
                    <td class="man_power" style="width: 17%;"><span class="badge">{{$process['man_power']}}</span></td>
                    <td class="roles" style="width: 17%;">
                        <?php
                        if(!is_null(getRole($process['role_id']))){
                            if(getRole($process['role_id'])->name == "PO"){
                                echo "<span class='label label-primary'>". getRole($process['role_id'])->name ."</span>";
                            } else if(getRole($process['role_id'])->name == "Dev"){
                                echo "<span class='label label-success'>". getRole($process['role_id'])->name ."</span>";
                            } else if(getRole($process['role_id'])->name == "BA"){
                                echo "<span class='label label-info'>". getRole($process['role_id'])->name ."</span>";
                            } else if(getRole($process['role_id'])->name == "ScrumMaster"){
                                echo "<span class='label label-warning'>". getRole($process['role_id'])->name ."</span>";
                            }
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td style="width: 27%;">{{ date('d/m/Y',strtotime($process['start_date_process'])) }}</td>
                    <td >{{ date('d/m/Y',strtotime($process['end_date_process'])) }}</td>
                    <td><a><i name="{{!is_null(getEmployee($process['employee_id']))?
                                    getEmployee($process['employee_id'])->name:'' }}"
                              id="{{$process['employee_id']}}" class="fa fa-remove remove_employee"></i>
                        </a></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
<div class=" col-md-12 text-center" style="margin-top: 20px;">
    <div class="col-md-4"></div>
    <div class="col-md-2">
        <button id="btn_reset_form_project" type="button" class="btn btn-default"><span
                    class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
        </button>
    </div>
    <div class="col-md-2">
        <button id="btn_submit_form_add_project" type="submit" class="btn btn-info"
                >{{trans('common.button.add')}}</button>
    </div>
{{-- nhan hien bang nhap form --}}
{!! Form::close() !!}

<script>
    // public/admin/template/myscript/project


    $(document).ready(function () {
        var language = $('#language_active').attr('lang');
        lang.init("project", language, function () {
            $('#form_add_project').on('submit', function (event) {
                var id_project = $('#id').val();
                var name_project = $('#name').val();
                if (confirm(message_confirm_project(lang.getString('add'), lang.getString('project'), id_project, name_project))) {
                    return true;
                }
                return false;
            });

            $('#btn_reset_form_project').on('click', function (event) {
                if (confirm(lang.getString('reset_form_add'))) {
                    resetFormAddProject();
                }
            });
            $(document).on('click', ".remove_employee", function (event) {
                var target = $(event.target).parent().closest('tr');
                var employee_id = $(event.target).attr('id');
                var employee_name = $(event.target).attr('name');
                if (confirm(message_confirm_project(lang.getString('remove'),lang.getString('employee'), employee_id, employee_name))) {
                    removeEmployee(employee_id, target);
                }
            });
            $('#btn_add_process').on("click", function () {
                var employee_id = $('#employee_id :selected').val();
                var employee_role = $('#role :selected').val();
                var employee_name = $('#employee_id :selected').text();
                if (employee_id === '' || employee_name === '') {
                    return confirm(lang.getString('alert_choose_employee'));
                } else {
                    if (confirm(message_confirm_project(lang.getString('add'), lang.getString('employee'), employee_id, employee_name))) {
                        var end_date_process_selected = $('#end_date_process').val();
                        var start_date_process_selected = $('#start_date_process').val();
                        if (checkDupeMember(employee_id, employee_name, start_date_process_selected, end_date_process_selected)) {
                            return false;
                        }
                        if (checkPOProcess(employee_role, employee_name, employee_id, start_date_process_selected, end_date_process_selected, 'PO')) {
                            return false;
                        }
                        requestAjax('{{route('checkProcessAjax')}}', '{{csrf_token()}}');
                    }
                }
            });
        });
    });
</script>