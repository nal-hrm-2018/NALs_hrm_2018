@extends('admin.template')
@section('content')
 <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
            <h1>
                My overtime
                <small>NAL Solutions</small>
            </h1>
        </section>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default">
                    <a href=""><i class="glyphicon glyphicon-plus"></i>&nbsp;Add OT</a>
                </button>
            </div>
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
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>From time</th>
                                        <th>To time</th>
                                        <th>Number time</th>
                                        <th>Date type</th>
                                        <th>Status</th>
                                        <th>Verify number</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        <td><span class="label label-danger">Reject</span></td>
                                        <td><span class="label label-success">1.5 hours</span></td>
                                        <td>
                                            <button type="button" class="btn btn-default width-90">
                                                <a href=""><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-default width-90">
                                                <a href=""><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</a>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" rowspan="3"></td>
                                        <td rowspan="3">Total</td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        <td><span class="label label-success">6 hours</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #643aff;">Day off</span></td>
                                        <td><span class="label label-success">6 hours</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        <td><span class="label label-success">6 hours</span></td>
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