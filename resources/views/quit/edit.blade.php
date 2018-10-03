@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('leftbar.nav.add.quit')}}
                <small>NAL Solutions</small>
            </h1>
        </section>
        <style type="text/css">
            .form-horizontal .form-group {
                margin-right: 0px;
            }
        </style>
        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-body">

                    <div id="msg">
                    </div>
                    <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
                    <div class="row">
                        {{-- <form action="{{asset('quit_process.update')}}" method="post" class="form-horizontal" > --}}
                        {{Form::model($quit,array('url' => ['/quit_process', $quit->id], 'method'=>isset($quit->id)?'PUT':'POST', 'id' => 'form_edit_quit',))}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="employee" name="employee" value="{{ isset($quit->employee->id)?$quit->employee->id:''}}">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                            <label>{{trans('quit.employee')}}<strong style="color: red"></strong></label><br />
                                    <input id="employee_id" class="form-control" name="employee_id" value="{!! old('employee_id', isset($quit->employee->name) ? $quit->employee->name : null) !!}" placeholder="" disabled/>
                                            <label id="lb_error_reason" style="color: red; ">{{$errors->first('reason')}}</label>
                                        </div>
                                    <div class="form-group">
                                        <label>{{trans('quit.reason')}}<strong style="color: red">(*)</strong></label>
                                        <textarea id="reason" rows="4" name="reason" value="" placeholder="">{!! old('reason', isset($quit->reason) ? $quit->reason : null) !!}</textarea>
                                        <label id="lb_error_reason" style="color: red; ">{{$errors->first('reason')}}</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label for="date">{{trans('quit.quit_date')}}<strong style="color: red">(*)</strong></label>
                                    </div>
                                    <div class="form-group input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control" id="quit_date" name="quit_date" value="{!! old('quit_date', isset($quit->quit_date) ? $quit->quit_date : null) !!}">
                                    </div>
                                    <label id="lb_error_quit_date" style="color: red; ">{{$errors->first('quit_date')}}</label> 
                                </div>
                                <!-- /.form-group -->
                                <div class="col-md-3"></div>

                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6" style="display: inline;">
                                    <div style="float: right;">
                                        <button onclick="return confirm_reset();" type="button" id="btn_reset_form_quit" class="btn btn-default"><span class="fa fa-refresh"></span>
                                            {{ trans('common.button.reset')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: inline;">
                                    <div>
                                        <button onclick="return confirm_add();" type="submit" class="btn btn-info">
                                            {{ trans('common.button.edit')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        {{-- </form> --}}

                    </div>
                    <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script>
                $(function () {
                    $("#btn_reset_form_quit").bind("click", function () {
                        if(confirmAction("{{trans('common.confirm_reset')}}"))
                            location.reload();
                    });
                });
            </script>
            <script type="text/javascript">
                $(function () {
                    $('.form_datetime').datetimepicker({
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        forceParse: 0,
                        showMeridian: 1});
                });
            </script>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        function confirm_add(){
            return confirm(message_confirm('{{trans('common.action.add')}}','{{trans('quit.quit')}}',''));
        }
    </script>

@endsection