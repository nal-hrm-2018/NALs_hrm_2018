<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
{!! Form::open(
    ['url' =>route('cong_test'),
    'method'=>'Post',
    'id'=>'form_add_team'
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3">
        @if(session()->has('available_processes'))
            @foreach(session()->get('available_processes') as $item)
                {{ 'ID = '. $item->employee_id}}
                {{ 'start_date= '.date('d/m/Y',strtotime($item->start_date)) }}
                {{'end_date='.date('d/m/Y',strtotime($item->end_date))}}
                {{'man_power='.$item->man_power}}
                <br>
            @endforeach

        @endif
    </div>
    <!-- /.col -->
    <div class="col-md-7">
        <div class="form-group">
            <label>ID employee</label>
        {{ Form::text('id', old('id'),
          ['class' => 'form-control width80',
          'id' => 'id',
          'autofocus' => true,
          ])
        }}
        <!-- /.input group -->
            <label class="id" id="lb_error_team_name" style="color: red; ">{{$errors->first('id')}}</label>
        </div>
        <div class="form-group">
            <label>Man power</label>
        {{ Form::number('man_power', old('man_power'),
        ['class' => 'form-control width80',
        'id' => 'man_power',
        'autofocus' => true,
        'step'=>"any"
        ])
        }}
        <!-- /.input group -->
            <label class="man_power" id="lb_error_team_name" style="color: red; ">{{$errors->first('man_power')}}</label>
        </div>
        <div class="form-group">
            <label>role</label>
        {{ Form::number('role', old('role'),
        ['class' => 'form-control width80',
        'id' => 'role',
        'autofocus' => true,
        ])
        }}
        <!-- /.input group -->
            <label class="role" id="lb_error_team_name" style="color: red; ">{{$errors->first('role')}}</label>
        </div>
        <div class="form-group">
            <label>start_date_project</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="start_date_project" name="start_date_project"
                       value="{{ old('start_date_project')}}">
            </div>
            <label class="start_date_project" id="lb_error_birthday" style="color: red; ">{{$errors->first('start_date_project')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>end_date_project</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="end_date_project" name="end_date_project"
                       value="{{ old('end_date_project')}}">
            </div>
            <label class="end_date_project" id="lb_error_birthday" style="color: red; ">{{$errors->first('end_date_project')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>estimate_start_date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="estimate_start_date" name="estimate_start_date"
                       value="{{ old('estimate_start_date')}}">
            </div>
            <label class="estimate_start_date" id="lb_error_birthday" style="color: red; ">{{$errors->first('estimate_start_date')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>estimate_end_date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="estimate_end_date" name="estimate_end_date"
                       value="{{ old('estimate_end_date')}}">
            </div>
            <label class="estimate_end_date" id="lb_error_birthday" style="color: red; ">{{$errors->first('estimate_end_date')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>start_date_process</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="start_date_process" name="start_date_process"
                       value="{{ old('start_date_process')}}">
            </div>
            <label class="start_date_process" id="lb_error_birthday" style="color: red; ">{{$errors->first('start_date_process')}}</label>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label>end_date_process</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control " id="end_date_process" name="end_date_process"
                       value="{{ old('end_date_process')}}">
            </div>
            <label class="end_date_process" id="lb_error_birthday" style="color: red; ">{{$errors->first('end_date_process')}}</label>
            <!-- /.input group -->
        </div>
    </div>
</div>
<div id="msg"></div>
<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
    <div class="col-md-1" style="display: inline;">
        <div>
            <button type="submit" class="btn btn-info">{{trans('common.button.save')}}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var form = $('#form_add_team');
        form.submit(function (e) {
            e.preventDefault();
            $('.id').html('');
            $('.man_power').html('');
            $('.start_date_project').html('');
            $('.end_date_project').html('');
            $('.estimate_start_date').html('');
            $('.estimate_end_date').html('');
            $('.start_date_process').html('');
            $('.end_date_process').html('');
            $('.role').html('');
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data:$(this).serialize(),
                success: function (json) {
                    console.log(json);
                    $.each(json, function (key, value) {
                        $('.'+key).html('');
                        $('.'+key).html(value);
                    });
                },
                error: function (json) {
                    if(json.status === 422) {
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
        });

    });

</script>


</html>