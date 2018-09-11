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
    			{{trans('common.path.edit_overtime')}}
    			<small>NAL Solutions</small>
    		</h1>
    	</section>
    	<section class="content">
    		<div class="box box-default">
    			<div id="msg"></div>
    			<div class="box-body">
	    			<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
	    			 {{Form::model($ot_history,array('url' => ['/ot', $ot_history->id], 'method' => 'PUT', 'id' => 'form_edit_overtime', 'onSubmit' => 'return confirm_edit_overtime()'))}}
	    				<div class="row">
	    					<div class="col-md-1"></div>
	    					<div class="col-md-4">	
		    					@if($projects)						
								<div class="form-group">
								    <label for="">{{trans('overtime.project')}}<strong style="color: red">(*)</strong></label>
								    <select class="form-control select2" id="project_id" name="project_id">
							    		@foreach($projects as $pro)
							    			@php
							    				$selected = "";
								    			if($pro->id == old('project_id', isset($ot_history->project_id) ? $ot_history->project_id : null)){
								    				$selected = "selected";
								    			}
							    			@endphp
											<option  value="{{$pro->id}}" {{$selected}}>{{$pro->name}}</option>
							    		@endforeach
								    </select>
								</div>
		    					@endif	
								<label for="">{{trans('overtime.date')}}<strong style="color: red">(*)</strong></label>
								<div class="form-group input-group">								    
								    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
								    <input type="date" class="form-control" id="ot_date" name="ot_date" value="{!! old('ot_date', isset($ot_history->date) ? $ot_history->date->format("Y-m-d") : null) !!}">
									<label id="lb_error_date" style="color: red; ">{{$errors->first('date')}}</label>
								</div>
								<div class="form-group">
									<label for="example3">{{trans('overtime.start_time')}}<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" name="start_time" id="start_time" value="{!! old('start_time', isset($ot_history->start_time) ? $ot_history->start_time: null) !!}">
									<label id="lb_error_start_time" style="color: red; ">{{$errors->first('start_time')}}</label>
								</div>
								<div class="form-group">
									<label for="example4">{{trans('overtime.end_time')}}<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" id="end_time" name="end_time" value="{!! old('end_time', isset($ot_history->end_time) ? $ot_history->end_time : null) !!}">
									<label id="lb_error_end_time" style="color: red; ">{{$errors->first('end_time')}}</label>
								</div>
	    					</div>
	    					<div class="col-md-2"></div>
	    					<div class="col-md-4">
	    						<div class="form-group">
	    							<label for="example5">{{trans('overtime.total_time')}}<strong style="color: red">(*)</strong></label>
	    							<input type="text" class="form-control" id="total_time" name="total_time" value="{!! old('total_time', isset($ot_history->total_time) ? $ot_history->total_time : null) !!}" >
									<label id="lb_error_total_time" style="color: red; ">{{$errors->first('total_time')}}</label>
	    						</div>
	    						<div class="form-group">
	    							<label for="example7">{{trans('overtime.reason')}}<strong style="color: red">(*)</strong></label>
	    							<textarea class="form-control" id="example7" name="reason" rows="11">{{ old('reason', isset($ot_history->reason) ? $ot_history->reason : null) }}</textarea>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                            <div class="col-md-6" style="display: inline; ">
                                <div style="float: right;">
                                    <button id="btn_reset_form_employee" type="reset" class="btn btn-default"><span
                                        class="fa fa-refresh"></span>&nbsp;{{ trans('common.button.reset')}}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div>
                                    <button type="submit" class="btn btn-info">{{ trans('common.button.edit')}}</button>
                                </div>
                            </div>
                        </div>
	    			 {{ Form::close() }}
    			</div>
    		</div>
    	</section>
    </div>
    <script type="text/javascript">
    	var timepicker = new TimePicker(['example3','example4'], {
		  	lang: 'en',
		  	theme: 'dark'
		});
		var input = document.getElementById('example3');

			timepicker.on('change', function(evt) {
		  
		  		var value = (evt.hour || '00') + ':' + (evt.minute || '00');
		  		evt.element.value = value;
		});
    </script>
    <SCRIPT LANGUAGE="JavaScript">
       function confirm_edit_overtime() {
             return confirm(message_confirm('{{trans("common.action_confirm.edit")}}', 'form', "", ""));
       }
   </SCRIPT>
@endsection