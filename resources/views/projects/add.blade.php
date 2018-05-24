@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add project
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/employee">Project</a></li>
                <li class="active">Add project</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div id="msg">
                </div>
                    <form action="" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                        	<div class="col-md-1">
                        	</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Project ID</label>
                                    <input type="text" class="form-control" placeholder="Project ID" name="id" id="id"  value="">
                                    <label id="lb_error_email" style="color: red;"></label>
                                </div>
                               
                                <div class="form-group">
                                    <label>Project name</label>
                                    <input type="text" class="form-control" placeholder="Project name" name="name" id="name" value="">
                                    <label id="lb_error_email" style="color: red;"></label>
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
                                        <input type="date" class="form-control pull-right" name="estimate_start_date" id="estimate_start_date" value="">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
                                    <!-- /.input group -->
                                </div>
		                            
                                <div class="form-group">
                                    <label>Estimate end date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right" name="estimate_end_date" id="estimate_end_date" value="">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
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
                                        <input type="date" class="form-control pull-right" name="start_date" id="start_date" value="">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
                                    <!-- /.input group -->
                                </div>
		                            
                                <div class="form-group">
                                    <label>End work date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right" name="end_date" id="end_date" value="">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-1" style="margin-left: 0px;">
                        		<br />
                        		<button type="button" class="btn btn-default buttonAdd">
                                    <a onclick="addFunction()"><i
                                                class="fa fa-user-plus"></i> ADD</a>
                                </button>
                        	</div>
                        	<div class="col-md-2">
                        		<div class="form-group">
	                                <label>Member</label><br/>
	                                <select class="form-control select2" name="employee_id" id="employee_id" >
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
	                                </select>
	                                <label id="lb_error_members" style="color: red; "></label>
	                            </div>
                        	</div>
                        	<div class="col-md-2"  style="margin-left: 5px;">
                        		<div class="form-group">
                                    <label>Start date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-left" name="start_date" id="start_date" value="" style="width: 80%">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
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
                                        <input type="date" class="form-control pull-left" name="end_date" id="end_date" value="" style="width: 80%">
                                    </div>
                                    <label id="lb_error_birthday" style="color: red; "></label>
                                    <!-- /.input group -->
                                </div>
                        	</div>
                        	<div class="col-md-2" style="margin-left: 5px;">
                        		<div class="form-group">
                                    <label>Man power</label>
                                    <input type="text" class="form-control" placeholder="Man power" name="man_power" id="man_power" value="">
                                    <label id="lb_error_email" style="color: red;"></label>
                                </div>
                        	</div>
                        	<div class="col-md-2" style="margin-left: 5px;">
                        		<div class="form-group">
	                                <label>Role</label><br/>
	                                <select class="form-control select2" name="role_id" id="role_id" >
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
	                                </select>
	                                <label id="lb_error_members" style="color: red; "></label>
	                            </div>
                        	</div>

                        </div>
                         <div class="row">
                        	<div>
                        		<div class="col-md-1" style="margin-left: 0px;">
                        		
	                        	</div>
	                        	<div class="col-md-2"  style="margin-left: 5px;">
	                        		<a class="btn-employee-remove"  style="float: left">
	                                                        <i class="fa fa-remove"
	                                                       onclick='removeEmployee() '></i>
	                                                   </a>
			                        <span style="float: right;">Nguyễn Văn A</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">1</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">Dev</span>
			                    </div>
                        	</div>
                        	<div>
                        		<div class="col-md-1" style="margin-left: 0px;">
                        		
	                        	</div>
	                        	<div class="col-md-2"  style="margin-left: 5px;">
	                        		<a class="btn-employee-remove"  style="float: left">
	                                                        <i class="fa fa-remove"
	                                                       onclick='removeEmployee() '></i>
	                                                   </a>
			                        <span style="float: right;">Nguyễn Văn A</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">1</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">Dev</span>
			                    </div>
                        	</div>
                        	<div>
                        		<div class="col-md-1" style="margin-left: 0px;">
                        		
	                        	</div>
	                        	<div class="col-md-2"  style="margin-left: 5px;">
	                        		<a class="btn-employee-remove"  style="float: left">
	                                                        <i class="fa fa-remove"
	                                                       onclick='removeEmployee() '></i>
	                                                   </a>
			                        <span style="float: right;">Nguyễn Văn A</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">22-02-1996</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">1</span>
			                    </div>
			                    <div class="col-md-2"  style="margin-left: 5px;">
			                        <span  style="float: right;">Dev</span>
			                    </div>
                        	</div>

		                </div>

                        <div class="row">
                        	<div class="col-md-1">
                        	</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Income</label>
                                    <input type="text" class="form-control" placeholder="Income" name="income" id="income" value="" >
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
                                    <textarea class="form-control" placeholder="Description" name="description" id="description" value=""></textarea>
                                    <label id="lb_error_email" style="color: red;"></label>
                                </div>
                        	</div>
                        </div>
                        <div class="row">
                        	<div class="col-md-1">
                        	</div>
                        	<div class="col-md-3">
                        		<div class="form-group">
	                                <label>Kick off</label><br/>
	                                <select class="form-control select2" name="status_id" id="status_id" >
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
	                     				<option>1</option>
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
                    </form>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <style>
        button.btn.btn-info.pull-left {
            float:  left;
            width: 115px;
        }
    </style>
@endsection