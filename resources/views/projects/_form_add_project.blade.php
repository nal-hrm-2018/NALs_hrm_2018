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
            {{" Employee(id=".$key.") : ".(!is_null(getEmployee((int)$key))?getEmployee((int)$key)->name:'id wrong')}}
            <br>
            @foreach($values->all() as $value)
                @if(!is_null($value))
                    {{" Error : ".$value }}<br>
                @endif
            @endforeach
        @endforeach
    @endif
    @if($errors->any())
        <script>
            $(function () {
                $("#list_error").css('display', 'block');
            })
        </script>
        @foreach($errors->all() as $key=>$error)
            @if(!is_null($error))
                {{" Error : ".$error }}<br>
            @endif
        @endforeach
    @endif
</div>
<div class="col-md-6 col-md-offset-1">
    <div>
        <label>{{trans('project.id')}}</label>
        {{ Form::text('id', old('id'),
            ['class' => 'form-control',
            'id' => 'id',
            'autofocus' => true,
            'placeholder'=>"Project ID",
            ])
        }}
        {{--<label class="id" id="lb_error_project_id" style="color: red; ">{{$errors->first('id')}}</label>--}}
    </div>
    <div>
        <label>{{trans('project.project_name')}}</label>
        {{ Form::text('name', old('name'),
            ['class' => 'form-control',
            'id' => 'name',
            'autofocus' => true,
            'placeholder'=>"Project Name",
            ])
        }}
        {{--<label class="name" id="lb_error_project_name" style="color: red; ">{{$errors->first('name')}}</label>--}}
    </div>
    <div>
        <label>{{trans('project.estimate_start_date')}}</label>
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
        <label>{{trans('project.estimate_end_date')}}</label>
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
        <label>Start work date</label>
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
        <label>End work date</label>
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
<div class="col-md-6" style="width: 100% ; margin-bottom: 2em"></div>
<div class="col-md-2">
    <button type="button" id="btn_add_process" class="btn btn-primary ">
        <i class="fa fa-user-plus"></i> Add
    </button>
</div>
<div class="col-md-6" style="width: 100% ; margin-bottom: 2em"></div>
<div class="col-md-2">
    <label>Member</label><br/>
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
    <label>Man power</label><br/>
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
    <label>Role</label><br/>
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
    <label>Start date</label>
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
    <label>End date</label>
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
    <table class="table table-hover">
        <thead>
        </thead>
        <tbody id="list_add">

        @if(session()->has('processes'))
            @foreach(session()->get('processes') as $process)
                <tr id="member_{{$process['employee_id']}}">
                    <input type="hidden" name="processes[{{$process['employee_id']}}][employee_id]" value="{{$process['employee_id']}}">
                    <input type="hidden" name="processes[{{$process['employee_id']}}][man_power]" value="{{$process['man_power']}}">
                    <input type="hidden" name="processes[{{$process['employee_id']}}][role_id]" value="{{$process['role_id']}}">
                    <input type="hidden" name="processes[{{$process['employee_id']}}][start_date_process]" value="{{$process['start_date_process']}}">
                    <input type="hidden" name="processes[{{$process['employee_id']}}][end_date_process]" value="{{$process['end_date_process']}}">
                    <td class="members" style="width: 17%;">
                        {{
                        !is_null(getEmployee($process['employee_id']))?
                        getEmployee($process['employee_id'])->name:''
                        }}
                    </td>
                    <td class="man_power" style="width: 17%;">{{$process['man_power']}}</td>
                    <td class="roles" style="width: 17%;">
                        {{
                        !is_null(getRole($process['role_id']))?
                        getRole($process['role_id'])->name:''
                        }}
                    </td>
                    <td class="start_date_process"
                        style="width: 27%;">{{ date('d/m/Y',strtotime($process['start_date_process'])) }}</td>
                    <td class="end_date_process">{{ date('d/m/Y',strtotime($process['end_date_process'])) }}</td>
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
<div class="col-md-6 col-md-offset-1">
    <div>
        <label>Income</label>
        {{ Form::number('income', old('income'),
            ['class' => 'form-control',
            'id' => 'income',
            'autofocus' => true,
            'placeholder'=>"Income",
            ])
        }}
        {{--<label id="lb_error_income" style="color: red;">{{$errors->first('income')}}</label>--}}
    </div>
    <div>
        <label>Estimate cost</label>
        {{ Form::text('estimate_cost', old('estimate_cost'),
            ['class' => 'form-control',
            'id' => 'estimate_cost',
            'autofocus' => true,
            'placeholder'=>"Estimate cost",
            'readonly'=>'readonly',
            ])
        }}
        {{--<label id="lb_error_estimate_cost" style="color: red;"></label>--}}
    </div>
    <div>
        <label>Real cost</label>
        {{ Form::number('real_cost', old('real_cost'),
            ['class' => 'form-control',
            'id' => 'real_cost',
            'autofocus' => true,
            'placeholder'=>"Real cost",
            ])
        }}
        {{--<label id="lb_error_real_cost" style="color: red;">{{$errors->first('real_cost')}}</label>--}}
    </div>
    <div>
        <label>Description</label>
        {{ Form::textarea('description', old('description'),
            ['class' => 'form-control',
            'id' => 'description',
            'autofocus' => true,
            'placeholder'=>"Description",
            ])
        }}
        {{--<label id="lb_error_description" style="color: red;"></label>--}}
    </div>
    <div>
        <label>Status</label><br/>
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
<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
<div class=" col-md-6 text-center col-md-offset-1" style="margin-top: 20px;">
    <button id="btn_reset_form_project" type="button" class="btn btn-default" style="width: 150px"><span
                class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
    </button>
    <button id="btn_submit_form_add_project" type="submit" class="btn btn-primary"
            style="width: 150px">{{trans('common.button.add')}}</button>
</div>
{{-- nhan hien bang nhap form --}}
{!! Form::close() !!}

<script>
    // public/admin/template/myscript/project


    $(document).ready(function () {
        $('#form_add_project').on('submit', function (event) {
            if (confirm("Do you want add new Project ?")) {

                return true;

            } else {

            }
        });

        $('#btn_reset_form_project').on('click', function (event) {
            if (confirm("Do you wan't reset all field ?")) {
                resetFormAddProject();
            }
        });
        $(document).on('click', ".remove_employee", function (event) {
            var target = $(event.target).parent().closest('tr');
            var employee_id = $(event.target).attr('id');
            var employee_name = $(event.target).attr('name');
            if (confirm("Do you want remove " + employee_name + " (id=" + employee_id + ") from project ?")) {
                removeEmployee(employee_id, target);
            }
        });
        $('#btn_add_process').on("click", function () {
            var employee_id = $('#employee_id :selected').val();
            var employee_name = $('#employee_id :selected').text();
            if (employee_id === '' || employee_name === '') {
                return confirm('Please choose employee !')
            } else {
                if (confirm("Do you want add  " + employee_name + " (id=" + employee_id + ") to project ?")) {
                    requestAjax('{{route('checkProcessAjax')}}', '{{csrf_token()}}');
                }
            }

        });
    });
</script>