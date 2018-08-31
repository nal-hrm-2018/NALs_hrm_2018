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
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Project</th>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Reasons</th>
                                        <th>From time</th>
                                        <th>To time</th>
                                        <th>Number time</th>
                                        <th>Date type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="3">1</td>
                                        <td rowspan="3">Ecomer</td>
                                        <td>Nguyễn Văn D</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info width-90">
                                                <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                            </button>
                                            <button type="button" class="btn btn-danger width-90">
                                                <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>Nguyễn Văn D</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #643aff;">Day off</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info width-90">
                                                <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                            </button>
                                            <button type="button" class="btn btn-danger width-90">
                                                <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>Nguyễn Văn D</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info width-90">
                                                <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                            </button>
                                            <button type="button" class="btn btn-danger width-90">
                                                <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3">2</td>
                                        <td rowspan="3">Ecomer2</td>
                                        <td>Nguyễn Văn D</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info width-90">
                                                <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                            </button>
                                            <button type="button" class="btn btn-danger width-90">
                                                <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>Nguyễn Văn D</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info">
                                                <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                            </button>
                                            <button type="button" class="btn btn-danger">
                                                <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                            </button>
                                        </td>
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