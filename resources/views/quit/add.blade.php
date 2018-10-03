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
                        <form action="{{asset('quit_process')}}" method="post" class="form-horizontal" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
									<label>{{trans('quit.employee')}}<strong style="color: red">(*)</strong></label>
                                        <select class="form-control" value="{{ old('employee_id') }}" id="employee_id" name="employee_id">
											<option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
											@foreach($employees as $employee)
												<?php
													$selected = "";
													if($employee->id == old('employee_id')){
														$selected = "selected";
													}
												?>
												<option value="{{$employee->id}}" <?php echo $selected; ?>>{{ $employee->name }}
												</option>
											@endforeach
										</select>
										<label id="lb_error_employee_id" style="color: red; ">{{$errors->first('employee_id')}}</label>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('quit.reason')}}<strong style="color: red">(*)</strong></label>
                                        <textarea id="reason" rows="4" name="reason" value="" placeholder="">{{ old('reason') }}</textarea>
                                        <label id="lb_error_reason" style="color: red; ">{{$errors->first('reason')}}</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label for="date">{{trans('quit.quit_date')}}<strong style="color: red">(*)</strong></label>
                                    </div>
                                    <div class="form-group input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control" id="quit_date" name="quit_date" value="{{ old('quit_date') }}">
                                    </div>
                                    <label id="lb_error_quit_date" style="color: red; ">{{$errors->first('quit_date')}}</label> 
                                </div>
                                <!-- /.form-group -->
                                <div class="col-md-3"></div>

                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6" style="display: inline;">
                                    <div style="float: right;">
                                        <button onclick="return confirm_reset();" type="button" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                                            {{ trans('common.button.reset')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: inline;">
                                    <div>
                                        <button onclick="return confirm_add();" type="submit" class="btn btn-info">
                                            {{ trans('common.button.add')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--{{ Form::close() }}--}}
                        </form>

                    </div>
                    <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <script type="text/javascript"
                    src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                    <script>
                        $(function () {
                            $("#btn_reset_form_employee").bind("click", function () {
                                if(confirm('{{trans('common.confirm_reset')}}')){
                                    $("#employee_id").val('');
                                    $("#reason").val('');
                                    $("#quit_date").val('').change();
                                    $("#lb_error_employee_id").empty();
                                    $("#lb_error_reason").empty();
                                    $("#lb_error_quit_date").empty();
                                }
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