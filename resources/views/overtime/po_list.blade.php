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
                                        <th>{{ trans('overtime_po.stt') }}</th>
                                        <th>{{ trans('overtime_po.project') }}</th>
                                        <th>{{ trans('overtime_po.employee') }}</th>
                                        <th>{{ trans('overtime_po.date') }}</th>
                                        <th>{{ trans('overtime_po.reason') }}</th>
                                        <th>{{ trans('overtime_po.from_time') }}</th>
                                        <th>{{ trans('overtime_po.to_time') }}</th>
                                        <th>{{ trans('overtime_po.number_time') }}</th>
                                        <th>{{ trans('overtime_po.data_type') }}</th>
                                        <th>{{ trans('overtime_po.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0
                                @endphp
                                @foreach($OT[$i] as $value)
                                    @foreach($value['project']['overtime'] as $va)


                                    <tr>
                                        <td rowspan="">{{$va->id}}</td>
                                        <td rowspan="">{{ \App\Models\Project::find($va->project_id)->first()->name }}</td>
                                        <td>{{ \App\Models\Employee::find($va->employee_id)->first()->name }}</td>
                                        <td>{{ $va->date }}</td>
                                        <td>{{ $va->reason }}</td>
                                        <td>{{ $va->start_time }}</td>
                                        <td>{{ $va->end_time }}</td>
                                        @if(isset($va->total_time))
                                        <td><span class="label label-success">{{ $va->total_time }}<span></td>
                                        @else
                                        <td><span>-<span></td>
                                        @endif
                                        <td><span class="label" style="background: #3600ff;">{{ \App\Models\OvertimeType::find($va->overtime_type_id)->name }}</span></td>
                                        @if(isset($va->overtime_status_id))
                                        <td><span class="label label-success">{{ \App\Models\OvertimeStatus::find($va->overtime_status_id)->name }}<span></td>
                                        @else
                                        <td>
                                            <div id="action_bt">
                                                <button onclick="return confirm_accept();" type="button" class="btn btn-primary width-90">
                                                    <i class="glyphicon glyphicon-ok"></i>&nbsp;Accept
                                                </button>
                                                <button onclick="return confirm_reject();" type="button" class="btn btn-danger width-90">
                                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;Reject
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
     <script>
         function confirm_accept() {
             document.getElementById("action_bt").style.visibility = "hidden";
         }
         function confirm_reject() {
             document.getElementById("action_bt").style.visibility = "hidden";
         }
     </script>
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