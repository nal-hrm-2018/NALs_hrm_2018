@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <head>
    	<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
		<link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
    </head>
    <div class="content-wrapper">
    	<section class="content-header">
    		<h1>
    			Add Overtime
    			<small>NAL Solutions</small>
    		</h1>
    	</section>
        <div id="msg"></div>
    	<section class="content">
    		<div class="box box-default">
    			<div class="box-body">
	    			<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
	    			<form action="{{asset('ot')}}" method="post" onsubmit="return confirmTime();">
	    				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	    				<div class="row">
	    					<div class="col-md-1"></div>
	    					<div class="col-md-4">
								<div class="form-group">
								    <label for="">{{trans('overtime.project')}}<strong style="color: red">(*)</strong></label>
									@if($processes->count() > 0)
									<select class="form-control" value="{{ old('process_id') }}" id="process_id" name="process_id">
										<option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
										@foreach($processes as $process)
											<?php
												$selected = "";
												if($process->id == old('process_id')){
												    $selected = "selected";
												}
											?>
											<option value="{{$process->id}}" <?php echo $selected; ?>>{{ $process->project->name }}
											</option>
										@endforeach
									</select>
									@else
									<select class="form-control" id="process_id" name="process_id" disabled>
										<option value="">-</option>
									</select>
									@endif

									<label id="lb_error_process_id" style="color: red; ">{{$errors->first('process_id')}}</label>
								</div>
								<label for="">{{trans('overtime.date')}}<strong style="color: red">(*)</strong></label>
								<div class="form-group input-group">
									<div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
									<input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
								</div>
								<label id="lb_error_date" style="color: red; ">{{$errors->first('date')}}</label>
								<div class="form-group">
									<label for="example3">{{trans('overtime.start_time')}}<strong style="color: red">(*)</strong></label>
									<input type="text" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" readonly style="background: white;">
									<label id="lb_error_start_time" style="color: red; ">{{$errors->first('start_time')}}</label>
								</div>
								<div class="form-group">
									<label for="example4">{{trans('overtime.end_time')}}<strong style="color: red">(*)</strong></label>
									<input type="text" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" readonly style="background: white;">
									<label id="lb_error_end_time" style="color: red; ">{{$errors->first('end_time')}}</label>
								</div>
	    					</div>
	    					<div class="col-md-2"></div>
	    					<div class="col-md-4">
	    						<div class="form-group">
	    							<label for="">{{trans('overtime.total_time')}}<strong style="color: red">(*)</strong></label>
	    							<input type="text" class="form-control" id="total_time" name="total_time" value="{{ old('total_time') }}">
									<label id="lb_error_total_time" style="color: red; ">{{$errors->first('total_time')}}</label>
	    						</div>
	    						<div class="form-group">
	    							<label for="">{{trans('overtime.reason')}}<strong style="color: red">(*)</strong></label>
	    							<textarea class="form-control" id="reason" rows="11" style="line-height: 1.36;" name="reason">{{ old('reason') }}</textarea>
									<label id="lb_error_reason" style="color: red; ">{{$errors->first('reason')}}</label>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                            <div class="col-md-6" style="display: inline; ">
                                <div style="float: right;">
                                    <button id="btn_reset_form_overtime" type="reset" class="btn btn-default"><span
                                        class="fa fa-refresh"></span>&nbsp;{{ trans('common.button.reset')}}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div>
                                    <button type="submit" class="btn btn-info">{{ trans('common.button.add')}}</button>
                                </div>
                            </div>
                        </div>
	    			</form>
    			</div>
    		</div>
    	</section>
    </div>
	<script type="text/javascript"
			src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script type="text/javascript">
    	var timepicker = new TimePicker(['start_time','end_time'], {
		  	lang: 'en',
		  	theme: 'dark'
		});
		var input = document.getElementById(['start_time','end_time']);

			timepicker.on('change', function(evt) {
		  
		  		var value = (evt.hour || '00') + ':' + (evt.minute || '00');
		  		evt.element.value = value;
		});
    </script>
@endsection