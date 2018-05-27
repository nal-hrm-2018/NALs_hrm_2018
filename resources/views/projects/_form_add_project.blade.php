{!! Form::open(
['url' =>route('projects.store'),
'method'=>'Post',
'id'=>'form_add_project',
'class'=>"form-horizontal"
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Project ID</label>
            {{ Form::text('id', old('id'),
                ['class' => 'form-control',
                'id' => 'id',
                'autofocus' => true,
                'placeholder'=>"Project ID",
                ])
            }}
            <label class="id" id="lb_error_project_id" style="color: red; ">{{$errors->first('id')}}</label>
        </div>

        <div class="form-group">
            <label>Project name</label>
            {{ Form::text('name', old('name'),
                ['class' => 'form-control',
                'id' => 'name',
                'autofocus' => true,
                'placeholder'=>"Project ID",
                ])
            }}
            <label class="name" id="lb_error_project_name" style="color: red; ">{{$errors->first('name')}}</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Estimate start date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="estimate_start_date" id="estimate_start_date"
                       value="{{ old('estimate_start_date')}}"/>
            </div>
            <label class="estimate_start_date" id="lb_error_estimate_start_date"
                   style="color: red; ">{{$errors->first('estimate_start_date')}}</label>
            <!-- /.input group -->
        </div>

        <div class="form-group">
            <label>Estimate end date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="estimate_end_date" id="estimate_end_date"
                       value="{{ old('estimate_end_date')}}">
            </div>
            <label class="estimate_end_date" id="lb_error_estimate_end_date"
                   style="color: red; ">{{$errors->first('estimate_end_date')}}</label>
            <!-- /.input group -->
        </div>
    </div>
    <div class="col-md-3" style="margin-left: 10px;">
        <div class="form-group">
            <label>Start work Date </label>
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

        <div class="form-group">
            <label>End work date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="end_date_project" id="end_date_project"
                       value="{{ old('end_date_project')}}">
            </div>
            <label class="end_date_project" id="lb_error_end_date_project"
                   style="color: red; ">{{$errors->first('end_date_project')}}</label>
            <!-- /.input group -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1" style="margin-left: 0px;">
        <br/>
        <button type="button" id="btn_add_process" class="btn btn-default buttonAdd">
            <i class="fa fa-user-plus"></i> ADD
        </button>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Member</label><br/>
            <select name="employee_id" id="employee_id" class="form-control select2">
                <option {{ !empty(old('employees'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"
                            id="member_{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <div class="form-group">
            <label>Start date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-left" name="start_date_process" id="start_date_process"
                       value="{{ old('start_date_process')}}" style="width: 80%">
            </div>
            <!-- /.input group -->
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <div class="form-group">
            <label>End date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-left" name="end_date_process" id="end_date_process"
                       value="{{ old('end_date_process')}}" style="width: 80%">
            </div>
            <!-- /.input group -->
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <div class="form-group">
            <label>Man power</label>
            <select name="man_power" id="man_power" class="form-control select2">
                <option {{ !empty(old('man_power'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($manPowers as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('man_power')?'selected="selected"':'' }} id="man_power_{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2" style="margin-left: 5px;">
        <div class="form-group">
            <label>Role</label><br/>
            <select name="role" id="role" class="form-control select2">
                <option {{ !empty(old('role'))?'':'selected="selected"' }} value="">
                    {{  trans('vendor.drop_box.placeholder-default') }}
                </option>
                @foreach($roles as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===old('role')?'selected="selected"':'' }} id="role_{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</div>
<div class="row" id="listProcess">
</div>

<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Income</label>
            <input type="text" class="form-control" placeholder="Income" name="income" id="income" value="">
            <label id="lb_error_email" style="color: red;"></label>
        </div>
    </div>
    <div class="col-md-3" style="margin-left: 10px;">
        <div class="form-group">
            <label>Estimate cost</label>
            <input type="text" class="form-control" placeholder="Estimate cost" name="" id="" value="">
            <label id="lb_error_email" style="color: red;"></label>
        </div>
    </div>
    <div class="col-md-3" style="margin-left: 10px;">
        <div class="form-group">
            <label>Real cost</label>
            <input type="text" class="form-control" placeholder="Real cost" name="real_cost" id="real_cost" value="">
            <label id="lb_error_email" style="color: red;"></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-9">
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Description" name="description" id="description"
                      value=""></textarea>
            <label id="lb_error_email" style="color: red;"></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-3">
        <div class="form-group">
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
            <label id="lb_error_members" style="color: red; "></label>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
    <div class="col-md-6" style="display: inline; ">
        <div style="float: right;">
            <button id="btn_reset_form_employee" type="button" class="btn btn-default"><span
                        class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
            </button>
        </div>
    </div>
    <div class="col-md-2" style="display: inline;">
        <div style="float: right;">
            <button type="submit" class="btn btn-info pull-left">ADD</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script>
    var listEmployee = new Array();
    var listEndDate = new Array();
    var listStartDate = new Array();
    var listManPower = new Array();
    var listRole = new Array();
</script>
<script>
    function requestAjax() {
        var employee_id = $('#employee_id').val();
        var estimate_start_date = $('#estimate_start_date').val();
        var estimate_end_date = $('#estimate_end_date').val();
        var start_date_project = $('#start_date_project').val();
        var end_date_project = $('#end_date_project').val();
        var end_date_process = $('#end_date_process').val();
        var start_date_process = $('#start_date_process').val();
        var man_power = $('#man_power').val();
        var role = $('#role').val();

        $.ajax({
            url: '{{route('checkProcessAjax')}}',
            type: 'POST',
            data: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                id: employee_id,
                estimate_start_date: estimate_start_date,
                estimate_end_date: estimate_end_date,
                start_date_project: start_date_project,
                end_date_project: end_date_project,
                end_date_process: end_date_process,
                start_date_process: start_date_process,
                man_power: man_power,
                role: role,
                _token: '{{csrf_token()}}',

            },
            success: function (json) {
                if(json.hasOwnProperty("msg_success")){
                    addProcess();
                }else{
                var string="";
                console.log(json);
                $.each(json[0], function (key, value) {
                    string += value;
                    $('#msg').html(string);
                });
                }
            },
            error: function (json) {
                if (json.status === 422) {
                    var errors = json.responseJSON;
                    $.each(json.responseJSON, function (key, value) {
                        $('#msg').html(value);
                    });
                } else {
                    // Error
                    // Incorrect credentials
                    // alert('Incorrect credentials. Please try again.')
                }
            }
        });
    }

    $(document).ready(function () {
        $('#btn_add_process').on("click", function () {
            requestAjax();
        });
    });

</script>
<script>
    function addProcess(){
        var employee_id = $('#employee_id').val();
        var end_date_process = $('#end_date_process').val();
        var start_date_process = $('#start_date_process').val();
        var man_power = $('#man_power').val();
        var role = $('#role').val();
        var check = true;
        for (var i = 0; i < listEmployee.length; i++) {
            if (employee_id == listEmployee[i]) {
                alert("member da dc chon");
                check = false;
                break;
            }

        }
        var listAdd = "";
        if(employee_id != 0 && check == true){
            listEmployee[listEmployee.length] = employee_id;
            listEndDate[listEndDate.length] = end_date_process;
            listStartDate[listStartDate.length] = start_date_process;
            listManPower[listManPower.length] = man_power;
            listRole[listRole.length] = role;
        
            for (var i = 0; i < listEmployee.length; i++) {
                var member = $('#member_'+listEmployee[i]).text();
                var man_power = $('#man_power_'+listManPower[i]).text();
                var name_role = $('#role_'+listRole[i]).text();
                listAdd +="<div id=\"process_"+listEmployee[i]+"\"><div class=\"col-md-1\" style=\"margin-left: 0px;\"></div>"+
                "<div class=\"col-md-2\" style=\"margin-left: 5px;\"><a class=\"btn-employee-remove\" style=\"float: left\"><i class=\"fa fa-remove\" onclick='removeProcess("+listEmployee[i]+") '></i></a>"+
                "<span style=\"float: right;\">"+member+"</span></div>"+
                "<div class=\"col-md-2\" style=\"margin-left: 5px;\"><span style=\"float: right;\">"+listStartDate[i]+"</span></div>"+
                "<div class=\"col-md-2\" style=\"margin-left: 5px;\"><span style=\"float: right;\">"+listEndDate[i]+"</span></div>"+
                "<div class=\"col-md-2\" style=\"margin-left: 5px;\"><span style=\"float: right;\">"+man_power+"</span></div>"+
                "<div class=\"col-md-2\" style=\"margin-left: 5px;\"><span style=\"float: right;\">"+name_role+"</span></div></div>";
            }
            $('#member_' + employee_id).prop('disabled', true);
            $('#employee_id').select2();
            document.getElementById("listProcess").innerHTML = listAdd;
        }
        

    }

</script>
<script type="text/javascript">
    function removeProcess(id) {
        $('div').remove('#process_' + id);
        listEmployee.splice(listEmployee.indexOf("" + id), 1);
        listEndDate.splice(listEmployee.indexOf("" + id), 1);
        listStartDate.splice(listEmployee.indexOf("" + id), 1);
        listEndDate.splice(listEmployee.indexOf("" + id), 1);
        listManPower.splice(listEmployee.indexOf("" + id), 1);
        listRole.splice( listEmployee.indexOf("" + id), 1);

        $('#member_' + id).prop('disabled', false);
        $('#employee_id').select2();
    }
</script>