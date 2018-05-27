{!! Form::open(
['url' =>route('projects.store'),
'method'=>'Post',
'id'=>'form_add_project',
'class'=>"form-horizontal"
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="container" style="margin-top: 15px">
    <div class="row">
        <div id="list_error" class="col-md-10 alert alert-danger" style="margin-left:25px ; display: none">
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
                    'placeholder'=>"Project ID",
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
                <label class="start_date_project" id="lb_error_start_date_project"
                       style="color: red; ">{{$errors->first('start_date_project')}}</label>
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

        <div id="process_box" class="col-md-10" style=" border: 2px solid #ccc;margin-top: 20px; margin-left:25px ;border-radius: 5px ">
            <div class="row" style="padding: 10px">
                <div class="col-md-6">
                    <div>
                        <label>Member</label><br/>
                        <select name="employee_id" id="employee_id" class="form-control select2" style="width: 100%">
                            <option {{ !empty(old('employees'))?'':'selected="selected"' }} value="">
                                {{  trans('vendor.drop_box.placeholder-default') }}
                            </option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                        {{ (string)$employee->id===old('employee_id')?'selected="selected"':'' }}
                                        id="member_{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="width: 100%">
                        <label>Man power</label><br/>
                        <select name="man_power" id="man_power" class="select2" style="width: 100%">
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
                </div>
            </div>
            <div class="row" style="padding: 10px">
                <div class="col-md-6">
                    <div>
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
                </div>
                <div class="col-md-6">
                    <div>
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
                </div>
            </div>
            <div class="row" style="padding: 10px; padding-bottom: 20px">
                <div class="col-md-6">
                    <div>
                        <label>Role</label><br/>
                        <select name="role" id="role" class=" select2" style="width: 100%">
                            <option {{ !empty(old('role'))?'':'selected="selected"' }} value="">
                                {{  trans('vendor.drop_box.placeholder-default') }}
                            </option>
                            @foreach($roles as $key=>$value)
                                <option value="{{ $key }}" {{ (string)$key===old('role')?'selected="selected"':'' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="row text-center" style="margin: 20px 0px 20px 0px">
                <button type="button" id="btn_add_process" class="btn btn-primary " style="width: 250px">
                    <i class="fa fa-user-plus"></i> Add
                </button>
            </div>
            {{--table--}}
            <div id="table_add" class="row" style="display: block">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Member</th>
                        <th scope="col">Man power</th>
                        <th scope="col">Role</th>
                        <th scope="col">Start date</th>
                        <th scope="col">End date</th>
                        <th scope="col">Remove</th>
                    </tr>
                    </thead>
                    <tbody id="list_add">

                    @if(session()->has('processes'))
                        @foreach(session()->get('processes') as $process)
                            <tr id="member_{{$process['employee_id']}}">
                                <td>
                                    {{
                                    !is_null(getEmployee($process['employee_id']))?
                                    getEmployee($process['employee_id'])->name:''
                                    }}
                                </td>
                                <td>{{$process['man_power']}}</td>
                                <td>{{getRole($process['role'])}}</td>
                                <td>{{$process['start_date_process']}}</td>
                                <td>{{$process['end_date_process']}}</td>
                                <td><a><i id="40" class="fa fa-remove removeajax"></i></a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-md-6 col-md-offset-1" style="margin-top: 20px">
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
        </div>
        <div class="col-md-6 col-md-offset-1">
            <div>
                <label>Estimate cost</label>
                {{ Form::number('estimate_cost', old('estimate_cost'),
                    ['class' => 'form-control',
                    'id' => 'estimate_cost',
                    'autofocus' => true,
                    'placeholder'=>"Estimate cost",
                    ])
                }}
                {{--<label id="lb_error_estimate_cost" style="color: red;"></label>--}}
            </div>
        </div>
        <div class="col-md-6 col-md-offset-1">
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
        </div>
        <div class="col-md-6 col-md-offset-1">
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
        </div>
        <div class="col-md-6 col-md-offset-1">
            <div>
                <label>Status</label><br/>
                <select name="status" id="status" class="form-control select2">
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
        <div class=" col-md-10 text-center" style="margin-top: 20px;">
            <button id="btn_reset_form_employee" type="button" class="btn btn-default" style="width: 150px"><span
                        class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
            </button>
            <button type="submit" class="btn btn-primary"
                    style="width: 150px">{{trans('common.button.add')}}</button>
        </div>
    </div>
</div>
{{-- nhan hien bang nhap form --}}
{!! Form::close() !!}

<script>

    function calculateEstimateCost() {

    }

    $(document).ready(function () {
        $(document).on('click', ".removeajax", function (event) {
            var target = $(event.target).parent().closest('tr');
            var employee_id = $(event.target).attr('id');
            var employee_name = $(event.target).attr('name');
            if (confirm("Do you want remove " + employee_name + " (id=" + employee_id + ") from project ?")) {
                removeAjax(employee_id, target, '{{route('removeProcessAjax')}}','{{csrf_token()}}');
            }
        });
        $('#btn_add_process').on("click", function () {
            var employee_id = $('#employee_id :selected').val();
            var employee_name = $('#employee_id :selected').text();
            if (employee_id === '' || employee_name === '') {
                return confirm('Please choose employee !')
            } else {
                if (confirm("Do you want add  " + employee_name + " (id=" + employee_id + ") to project ?")) {
                    requestAjax('{{route('checkProcessAjax')}}','{{csrf_token()}}');
                }
            }

        });
    });

</script>