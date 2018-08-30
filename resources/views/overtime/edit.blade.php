@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
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
								    <label for="example1">Date<strong style="color: red">(*)</strong></label>
								    <input type="date" class="form-control" id="example1">
								</div>
								<div class="form-group">
								    <label for="example2">Date<strong style="color: red">(*)</strong></label>
								    <select class="form-control" id="example2">
								    	<option selected>Choose Project</option>
								    	<option>project a</option>
								    	<option>project b</option>
								    	<option>project c</option>
								    </select>
								</div>
								<div class="form-group">
									<label for="example3">From time<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" id="example3">
								</div>
								<div class="form-group">
									<label for="example4">To time<strong style="color: red">(*)</strong></label>
									<input type="time" class="form-control" id="example4">
								</div>
	    					</div>
	    					<div class="col-md-2"></div>
	    					<div class="col-md-4">
	    						<div class="form-group">
	    							<label for="example5">Number time<strong style="color: red">(*)</strong></label>
	    							<input type="text" class="form-control" id="example5">
	    						</div>
	    						<div class="form-group">
	    							<label for="example6">Date Type<strong style="color: red">(*)</strong></label>
	    							<select class="form-control" id="example6">
	    								<option selected>Choose date type</option>
	    								<option>Normal day</option>
	    								<option>Day off</option>
	    								<option>Holiday</option>
	    							</select>
	    						</div>
	    						<div class="form-group">
	    							<label for="example7">Reason<strong style="color: red">(*)</strong></label>
	    							<textarea class="form-control" id="example7" rows="5"></textarea>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                            <div class="col-md-6" style="display: inline; ">
                                <div style="float: right;">
                                    <button id="btn_reset_form_employee" type="button" class="btn btn-default"><span
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
@endsection