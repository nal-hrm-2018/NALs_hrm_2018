@extends('admin.template')
@section('content')
 <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
            <h1>
                List OT
                <small>NAL Solutions</small>
            </h1>
        </section>
        <section class="content-header">
            <div style="display: flex; flex-direction: row-reverse;">
                <button class="btn btn-default">
                    <a href="">
                        <i class="glyphicon glyphicon-export"></i>&nbsp;{{trans('common.button.export')}}
                    </a>
                </button>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                        	<div>
                        		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                                </button>
                                <div id="demo" class="collapse margin-form-search">
                                    <form method="get" role="form">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.id')}}</button>
                                                            </div>
                                                            <input type="text" name="id" id="employeeId" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.name')}}</button>
                                                            </div>
                                                            <input type="text" name="name" id="nameEmployee" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.team')}}</button>
                                                            </div>
                                                            <select name="team" id="team_employee" class="form-control">
                                                            	<option></option>
                                                            	<option></option>
                                                            	<option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Date</button>
                                                            </div>
                                                            <input type="date" name="date" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Month</button>
                                                            </div>
                                                            <select name="month" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button"
                                                                        class="btn width-100"> Year</button>
                                                            </div>
                                                            <select name="year" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer center">
                                                <button id="btn_reset_employee" type="button" class="btn btn-default"><span class="fa fa-refresh"></span>
                                                    {{trans('common.button.reset')}}
                                                </button>
                                                <button type="submit" id="searchListEmployee" class="btn btn-info"><span
                                                            class="fa fa-search"></span>
                                                    {{trans('common.button.search')}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div style="float: right; margin-bottom: 15px;">
	                                <label class="lable-entries" style="float: right;">{{trans('pagination.show.number_record_per_page')}}</label><br />
	                                <select class="input-entries" style="float: right;">
	                                    <option>10</option>
	                                    <option>20</option>
	                                    <option>30</option>
	                                </select>
	                            </div>
                        	</div>
                            <table id="" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee</th>
                                        <th><span class="label" style="background: #9072ff;">Normal day</span></th>
                                        <th><span class="label" style="background: #643aff;">Day off</span></th>
                                        <th><span class="label" style="background: #3600ff;">Holiday</span></th>
                                    </tr>
                                </thead>
                                <tbody class="context-menu">
                                    <tr>
                                        <td>1</td>
                                        <td>Nguyễn Văn D</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style type="text/css">
        .table tbody tr td {
            vertical-align: middle;
        }
        .table thead tr th {
            vertical-align: middle;
        }
        .width-90 {
            width: 90px;
        }
    </style>
@endsection