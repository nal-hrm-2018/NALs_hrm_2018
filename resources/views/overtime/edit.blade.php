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
    			<div class="box-body">
	    			<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
	    			<form>
	    				<div class="row">
	    					<div class="col-md-1"></div>
	    					<div class="col-md-4">
								<div class="form-group">
								    <label for="">Project<strong style="color: red">(*)</strong></label>
								    <select class="form-control" id="">
								    	<option selected>Choose Project</option>
								    	<option>project a</option>
								    	<option>project b</option>
								    	<option>project c</option>
								    </select>
								</div>
								<div class="form-group">
								    <label for="">Date<strong style="color: red">(*)</strong></label>
								    <input type="date" class="form-control" id="">
								</div>
								<div class="form-group">
									<label for="example3">From time<strong style="color: red">(*)</strong></label>
									<input type="text" class="form-control" id="example3">
								</div>
								<div class="form-group">
									<label for="example4">To time<strong style="color: red">(*)</strong></label>
									<input type="text" class="form-control" id="example4">
								</div>
	    					</div>
	    					<div class="col-md-2"></div>
	    					<div class="col-md-4">
	    						<div class="form-group">
	    							<label for="">Number time<strong style="color: red">(*)</strong></label>
	    							<input type="text" class="form-control" id="">
	    						</div>
	    						<div class="form-group">
	    							<label for="">Date Type<strong style="color: red">(*)</strong></label>
	    							<select class="form-control" id="">
	    								<option selected>Choose date type</option>
	    								<option>Normal day</option>
	    								<option>Day off</option>
	    								<option>Holiday</option>
	    							</select>
	    						</div>
	    						<div class="form-group">
	    							<label for="">Reason<strong style="color: red">(*)</strong></label>
	    							<textarea class="form-control" id="" rows="5" style="line-height: 1.36;"></textarea>
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
	    			</form>
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
@endsection