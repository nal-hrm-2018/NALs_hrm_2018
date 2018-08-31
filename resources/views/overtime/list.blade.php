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
                            <div style="float: right; margin-bottom: 15px;">
                                <label class="lable-entries" style="float: right;">{{trans('pagination.show.number_record_per_page')}}</label><br />
                                <select class="input-entries" style="float: right;">
                                    <option>10</option>
                                    <option>20</option>
                                    <option>30</option>
                                </select>
                            </div>
                            <table id="" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Reasons</th>
                                        <th>From time</th>
                                        <th>To time</th>
                                        <th>Number time</th>
                                        <th>Date type</th>
                                        <th>Status</th>
                                        <th>Accept time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    @foreach($ot as $val)
                                        <td>{{$val->id}}</td>
                                        <td>{{$val->date->format('d/m/Y')}}</td>
                                        <td>{{$val->reason}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$val->start_time)->format('H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$val->end_time)->format('H:i')}}</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        <td><span class="label label-danger">Reject</span></td>
                                        <td><span class="label label-success">1.5 hours</span></td>
                                        <td>
                                            <a class="btn btn-warning"><em class="fa fa-pencil"></em></a>
                                            <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
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
                                    @endforeach
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