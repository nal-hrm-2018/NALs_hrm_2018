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
                    <a href="{{asset('ot/create')}}"><i class="glyphicon glyphicon-plus"></i>&nbsp;Add OT</a>
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
                                        <th>No.</th>
                                        <th>Name of Project</th>
                                        <th>Date</th>
                                        <th>Reasons</th>
                                        <th>From time</th>
                                        <th>To time</th>
                                        <th>Total time</th>
                                        <th>Date type</th>
                                        <th>Status</th>
                                        <th>Accept time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                            $i = 0;    
                                        @endphp
                                    @foreach($ot as $val)
                                        @php
                                            $i+=1;
                                        @endphp
                                        <td>{{$i}}</td>
                                        <td>{{$val->project->name}}</td>
                                        <td>{{$val->date->format('d/m/Y')}}</td>
                                        <td>{{$val->reason}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$val->start_time)->format('H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('H:i:s',$val->end_time)->format('H:i')}}</td>
                                        <td><span class="label label-primary">{{$val->total_time}} hours<span></td>
                                        @if ($val->Type->name == 'normal')
                                            <td><span class="label" style="background: #9072ff;">{{$val->type->name}}</span></td>
                                        @elseif($val->Type->name == 'weekend')
                                            <td><span class="label" style="background: #643aff;">{{$val->type->name}}</span></td>
                                        @elseif($val->Type->name == 'holiday')
                                            <td><span class="label" style="background: #3600ff;">{{$val->type->name}}</span></td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($val->Status->name == 'Not yet')
                                            <td><span class="label label-default">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Reviewing')
                                            <td><span class="label label-info">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Accepted')
                                            <td><span class="label label-success">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Rejected')
                                            <td><span class="label label-warning">{{$val->Status->name}}</span></td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($val->correct_total_time)
                                            <td><span class="label label-primary">{{$val->correct_total_time}} hours</span></td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-warning" href="ot/{{$val->id}}/edit"><em class="fa fa-pencil"></em></a>
                                            <a class="btn btn-danger" href="ot/{{$val->id}}"><em class="fa fa-trash"></em></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7" rowspan="3"></td>
                                        <td rowspan="3">Total</td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @if ($time['normal'])
                                            <td><span class="label label-primary">{{$time['normal']}} hours</span></td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #643aff;">Day off</span></td>
                                        @if ($time['weekend'])
                                            <td><span class="label label-primary">{{$time['weekend']}} hours</span></td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @if ($time['holiday'])
                                            <td><span class="label label-primary">{{$time['holiday']}} hours</span></td>
                                        @else
                                            <td>-</td>
                                        @endif
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