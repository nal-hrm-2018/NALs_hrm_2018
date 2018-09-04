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
    			Edit overtime
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
								<div class="form-group">
								    <label for="">Project<strong style="color: red">(*)</strong></label>
								    <select class="form-control" id="">
								    	
								    </select>
								</div>
								<label for="">Date<strong style="color: red">(*)</strong></label>
								<div class="form-group input-group">								    
								    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
								    <input type="date" class="form-control" id="ot_date" name="ot_date" value="{!! old('ot_date', isset($ot_history->date) ? $ot_history->date->format("Y-m-d") : null) !!}">
								</div>
								<div class="form-group">
									<label for="example3">From time<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" name="start_time" id="start_time" value="{!! old('start_time', isset($ot_history->start_time) ? $ot_history->start_time: null) !!}">
								</div>
								<div class="form-group">
									<label for="example4">To time<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" id="end_time" name="end_time" value="{!! old('end_time', isset($ot_history->end_time) ? $ot_history->end_time : null) !!}">
								</div>
	    					</div>
	    					<div class="col-md-2"></div>
	    					<div class="col-md-4">
	    						<div class="form-group">
	    							<label for="example5">Number time<strong style="color: red">(*)</strong></label>
	    							<input type="text" class="form-control" id="total_time" name="total_time" value="{!! old('total_time', isset($ot_history->total_time) ? $ot_history->total_time : null) !!}" >
	    						</div>
	    						<!-- <div class="form-group">
	    							<label for="">Overtime Type<strong style="color: red">(*)</strong></label>
	    							<select class="form-control" id="">
	    								<option selected>{{$ot_history->type->name}}</option>
	    								@foreach($overtime_type as $type)
	    									@if($type->name <> $ot_history->type->name)
	    										<option>{{$type->name}}</option>
								    		@endif
	    								@endforeach
	    							</select>
	    						</div> -->
	    						<div class="form-group">
	    							<label for="example7">Reason<strong style="color: red">(*)</strong></label>
	    							<textarea class="form-control" id="example7" name="reason" rows="11">{{ old('reason', isset($ot_history->reason) ? $ot_history->reason : null) }}</textarea>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                            <div class="col-md-6" style="display: inline; ">
                                <div style="float: right;">
                                    <button id="btn_reset_form_employee" type="reset" class="btn btn-default"><span
                                        class="fa fa-refresh"></span>&nbsp;RESET
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div>
                                    <button type="submit" class="btn btn-info">EDIT</button>
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