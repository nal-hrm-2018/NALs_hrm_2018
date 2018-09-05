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
        <div id="msg">
        </div>
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
                                        <th>{{ trans('overtime_po.correct_total_time') }}</th>
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


                                    <tr class="overtime-menu" >
                                        <td rowspan="">{{$va->id}}</td>
                                        <td rowspan="">{{ \App\Models\Project::where('id',$va->project_id)->first()->name }}</td>
                                        <td>{{ \App\Models\Employee::where('id',$va->employee_id)->first()->name }}</td>
                                        <td>{{ $va->date }}</td>
                                        <td>{{ $va->reason }}</td>
                                        <td>{{ $va->start_time }}</td>
                                        <td>{{ $va->end_time }}</td>
                                        @if(isset($va->total_time))
                                            <td><span class="label label-success">{{ $va->total_time }}<span></td>
                                        @else
                                            <td><span>-<span></td>
                                        @endif
                                        @if(isset($va->correct_total_time))
                                            <td><span class="label label-warning">{{ $va->correct_total_time }}<span></td>
                                        @else
                                            <td><span>-<span></td>
                                        @endif
                                        @php
                                            $name_overtime_type = \App\Models\OvertimeType::find($va->overtime_type_id)->name;
                                        @endphp
                                        @if ($name_overtime_type == 'normal')
                                            <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @elseif($name_overtime_type == 'weekend')
                                            <td><span class="label" style="background: #643aff;">Day off</span></td>
                                        @elseif($name_overtime_type == 'holiday')
                                            <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @php
                                            $name_overtime_status = \App\Models\OvertimeStatus::find($va->overtime_status_id)->name;
                                        @endphp
                                        @if( $name_overtime_status == "Accepted")
                                        <td><span class="label label-success">{{ $name_overtime_status }}<span></td>
                                        @elseif($name_overtime_status == "Rejected" )
                                        <td><span class="label label-danger">{{ $name_overtime_status }}<span></td>
                                        @else
                                        <td>
                                            <div id="action_bt">
                                                <a href="/ot/po-ot/{{$va->id}}"  class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                                </a>
                                                <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{$va->id}}">
                                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$va->id}}"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document" style="width: 25%;">
                                            <form action="/ot/po-ot/reject/{{$va->id}}" method="get" onsubmit="return validate();">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Do you want to reject this form?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="verify">Accept time</label>
                                                            <input type="number" class="form-control" name="correct_total_time" id="correct_total_time">
                                                            <label id="lb_error_correct_total_time" style="color: red; ">{{$errors->first('correct_total_time')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger" >Reject request</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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