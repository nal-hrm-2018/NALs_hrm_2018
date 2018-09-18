@extends('admin.template')
@section('content')
 <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Overtime Management
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
                            @if(isset($ot_po))
                            <h2 class="label label-success">Dev</h2>
                            @endif
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('overtime.number') }}</th>
                                        <th>{{ trans('overtime.project') }}</th>
                                        <th>{{ trans('overtime.employee') }}</th>
                                        <th class="text-center">{{ trans('overtime.date') }}</th>
                                        <th>{{ trans('overtime.reason') }}</th>
                                        <th class="text-center">{{ trans('overtime.start_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.end_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.type') }}</th>
                                        <th class="text-center">{{ trans('overtime.correct_total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0
                                @endphp
                                @foreach($ot_dev as $value)
                                    <tr class="employee-menu" id="employee-id-{{$value['id']}}"
                                    data-employee-id="{{$value['id']}}" >
                                        <td class="text-center" rowspan="">{{$i+1}}</td>
                                        <td rowspan="">{{$value['project']['name']}}</td>
                                        
                                        <td>{{$value['employee']['name'] }}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($value['date']))}}</td>
                                        <td>{{$value["reason"]}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["start_time"])->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["end_time"])->format('H:i')}}</td>
                                        @if(isset($value["total_time"]))
                                            <td class="text-center"><span class="label label-primary">{{$value["total_time"]}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        @if($value['type']['name'] == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @elseif($value['type']['name'] == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">Day off</span></td>
                                        @elseif($value['type']['name'] == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if(isset($value['correct_total_time']))
                                            <td class="text-center"><span class="label label-success">{{$value['correct_total_time']}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        
                                        @if($value['status']['name'] == "Accepted")
                                        <td class="text-center"><span class="label label-success">{{ $value['status']['name'] }}<span></td>
                                        @elseif($value['status']['name'] == "Rejected" )
                                        <td class="text-center"><span class="label label-danger">{{ $value['status']['name'] }}<span></td>
                                        @else
                                        <td class="text-center">
                                            <div id="action_bt">
                                                <a href="/ot/po-ot/{{$value['id']}}"  class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                                </a>
                                                <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{$value['id']}}">
                                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                        <ul class="contextMenu" data-employee-id="{{$value['id']}}" hidden>
                                            <li><a href="{{ route('employee.show',['employee'=> $value['employee_id']]) }}?basic=0&project=0&overtime=1&absence=0">
                                                    <i class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a>
                                            </li>
                                        </ul>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$value['id']}}"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document" style="width: 25%;">
                                            <form action="/ot/po-ot/reject/{{$value['id']}}" method="get" onsubmit="return validate();">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Do you want to reject this form?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="verify">Accept time</label>
                                                            <input type="number" step="0.1" min=0 max="{{$value["total_time"]}}" class="form-control" id="correct_total_time" name="correct_total_time">
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
                                        @php
                                            $i++;
                                        @endphp
                                @endforeach
                                </tbody>
                            </table>
                            @if (isset($ot_po))
                            <h2 class="label label-warning">PO</h2>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('overtime.number') }}</th>
                                        <th>{{ trans('overtime.project') }}</th>
                                        <th>{{ trans('overtime.employee') }}</th>
                                        <th class="text-center">{{ trans('overtime.date') }}</th>
                                        <th>{{ trans('overtime.reason') }}</th>
                                        <th class="text-center">{{ trans('overtime.start_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.end_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.type') }}</th>
                                        <th class="text-center">{{ trans('overtime.correct_total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0
                                @endphp
                                @foreach($ot_po as $value)
                                    <tr class="employee-menu" id="employee-id-{{$value['id']}}"
                                    data-employee-id="{{$value['id']}}" >
                                        <td class="text-center" rowspan="">{{$i+1}}</td>
                                        <td rowspan="">{{$value['project']['name']}}</td>
                                        
                                        <td>{{$value['employee']['name'] }}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($value['date']))}}</td>
                                        <td>{{$value["reason"]}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["start_time"])->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["end_time"])->format('H:i')}}</td>
                                        @if(isset($value["total_time"]))
                                            <td class="text-center"><span class="label label-primary">{{$value["total_time"]}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        @if($value['type']['name'] == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @elseif($value['type']['name'] == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">Day off</span></td>
                                        @elseif($value['type']['name'] == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if(isset($value['correct_total_time']))
                                            <td class="text-center"><span class="label label-success">{{$value['correct_total_time']}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        
                                        @if($value['status']['name'] == "Accepted")
                                        <td class="text-center"><span class="label label-success">{{ $value['status']['name'] }}<span></td>
                                        @elseif($value['status']['name'] == "Rejected" )
                                        <td class="text-center"><span class="label label-danger">{{ $value['status']['name'] }}<span></td>
                                        @else
                                        <td class="text-center">
                                            <div id="action_bt">
                                                <a href="/ot/po-ot/{{$value['id']}}"  class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                                </a>
                                                <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{$value['id']}}">
                                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                        <ul class="contextMenu" data-employee-id="{{$value['id']}}" hidden>
                                            <li><a href="{{ route('employee.show',['employee'=> $value['employee_id']]) }}?basic=0&project=0&overtime=1&absence=0">
                                                    <i class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a>
                                            </li>
                                        </ul>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$value['id']}}"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document" style="width: 25%;">
                                            <form action="/ot/po-ot/reject/{{$value['id']}}" method="get" onsubmit="return validate();">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Do you want to reject this form?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="verify">Accept time</label>
                                                            <input type="number" step="0.1" min=0 max="{{$value["total_time"]}}" class="form-control" id="correct_total_time" name="correct_total_time">
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
                                        @php
                                            $i++;
                                        @endphp
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                            @if(isset($ot_hr))
                            <h2 class="label label-danger">HR</h2>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('overtime.number') }}</th>
                                        <th>{{ trans('overtime.project') }}</th>
                                        <th>{{ trans('overtime.employee') }}</th>
                                        <th class="text-center">{{ trans('overtime.date') }}</th>
                                        <th>{{ trans('overtime.reason') }}</th>
                                        <th class="text-center">{{ trans('overtime.start_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.end_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.type') }}</th>
                                        <th class="text-center">{{ trans('overtime.correct_total_time') }}</th>
                                        <th class="text-center">{{ trans('overtime.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0
                                @endphp
                                @foreach($ot_hr as $value)
                                    <tr class="employee-menu" id="employee-id-{{$value['id']}}"
                                    data-employee-id="{{$value['id']}}" >
                                        <td class="text-center" rowspan="">{{$i+1}}</td>
                                        <td class="text-center" rowspan="">-</td>
                                        
                                        <td>{{$value['employee']['name'] }}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($value['date']))}}</td>
                                        <td>{{$value["reason"]}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["start_time"])->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["end_time"])->format('H:i')}}</td>
                                        @if(isset($value["total_time"]))
                                            <td class="text-center"><span class="label label-primary">{{$value["total_time"]}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        @if($value['type']['name'] == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @elseif($value['type']['name'] == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">Day off</span></td>
                                        @elseif($value['type']['name'] == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if(isset($value['correct_total_time']))
                                            <td class="text-center"><span class="label label-success">{{$value['correct_total_time']}} hours<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        
                                        @if($value['status']['name'] == "Accepted")
                                        <td class="text-center"><span class="label label-success">{{ $value['status']['name'] }}<span></td>
                                        @elseif($value['status']['name'] == "Rejected" )
                                        <td class="text-center"><span class="label label-danger">{{ $value['status']['name'] }}<span></td>
                                        @else
                                        <td class="text-center">
                                            <div id="action_bt">
                                                <a href="/ot/po-ot/{{$value['id']}}"  class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                                </a>
                                                <button  type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{$value['id']}}">
                                                    <i class="glyphicon glyphicon-remove"></i>&nbsp;
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                        <ul class="contextMenu" data-employee-id="{{$value['id']}}" hidden>
                                            <li><a href="{{ route('employee.show',['employee'=> $value['employee_id']]) }}?basic=0&project=0&overtime=1&absence=0">
                                                    <i class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a>
                                            </li>
                                        </ul>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$value['id']}}"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document" style="width: 25%;">
                                            <form action="/ot/po-ot/reject/{{$value['id']}}" method="get" onsubmit="return validate();">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Do you want to reject this form?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="verify">Accept time</label>
                                                            <input type="number" step="0.1" min=0 max="{{$value["total_time"]}}" class="form-control" id="correct_total_time" name="correct_total_time">
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
                                        @php
                                            $i++;
                                        @endphp
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
 <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
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
        h4 {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }
    </style>
 <script type="text/javascript">
     $(function () {
         $('tr.employee-menu').on('contextmenu', function (event) {
             event.preventDefault();
             $('ul.contextMenu').fadeOut("fast");
             var eId = $(this).data('employee-id');
             $('ul.contextMenu[data-employee-id="' + eId + '"]')
                 .show()
                 .css({top: event.pageY - 100, left: event.pageX - 250, 'z-index': 300});

         });
         $(document).click(function () {
             if ($('ul.contextMenu:hover').length === 0) {
                 $('ul.contextMenu').fadeOut("fast");
             }
         });
     });

 </script>
@endsection
