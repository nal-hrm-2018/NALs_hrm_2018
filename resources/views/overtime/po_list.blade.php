@extends('admin.template')
@section('content')
 <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{trans('leftbar.nav.overtime_management')}}
                <small>NAL Solutions</small>
            </h1>
        </section>
        <div id="msg">
        </div>
        <?php
        $name = null; $type = null; $status = null; $from_date = null; $to_date = null; $page=1;
        $number_record_per_page = 20;
        $arrays[] = $_GET;
        foreach ($arrays as $key => $value) {
            if (!empty($value['name'])) {
                $name = $value['name'];
            }
            if (!empty($value['type'])) {
                $type = $value['type'];
            }
            if (!empty($value['status'])) {
                $status = $value['status'];
            }
            if (!empty($value['from_date'])) {
                $from_date = $value['from_date'];
            }
            if (!empty($value['to_date'])) {
                $to_date = $value['to_date'];
            }
            if (!empty($value['page'])) {
                $page = $value['page'];
            }
            if (!empty($value['number_record_per_page'])) {
                $number_record_per_page = $value['number_record_per_page'];
            }
        }
    ?>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <h3>{{ trans('overtime.list') }}</h3>
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
                                @foreach($ot_review as $value)
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
                                            <td class="text-center"><span class="label label-primary">{{$value["total_time"]}} {{ ($value["total_time"]<2)? trans('overtime.hour'): trans('overtime.hours') }}<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        @if($value['type']['name'] == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">{{ trans('overtime.day_type.normal') }}</span></td>
                                        @elseif($value['type']['name'] == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">{{ trans('overtime.day_type.day_off') }}</span></td>
                                        @elseif($value['type']['name'] == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">{{ trans('overtime.day_type.holiday') }}</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if(isset($value['correct_total_time']))
                                            <td class="text-center"><span class="label label-success">{{$value['correct_total_time']}} {{ ($value["correct_total_time"]<2)? trans('overtime.hour'): trans('overtime.hours') }}<span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                            
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
                                                        <h4 class="modal-title" id="myModalLabel">{{ trans('overtime.modal.title') }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="verify">{{ trans('overtime.modal.accept_time') }}</label>
                                                            <input type="number" step="0.1" min=0 max="{{$value["total_time"]}}" class="form-control" id="correct_total_time" name="correct_total_time">
                                                            <label id="lb_error_correct_total_time" style="color: red; ">{{$errors->first('correct_total_time')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('overtime.modal.cancel') }}</button>
                                                        <button type="submit" class="btn btn-danger" >{{ trans('overtime.modal.reject') }}</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <h3>{{ trans('overtime.history') }}</h3>
                            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse" style="margin-bottom: 10px;">
                                <span class="fa fa-search"></span>&nbsp;{{trans('common.button.search')}}
                            </button>
                            <div id="demo" class="collapse margin-form-search">
                                <form method="get" role="form" id="form_search_overtime">
                                    <!-- Modal content-->
                                    <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                           value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn width-100">{{trans('overtime.project')}}</button>
                                                        </div>
                                                        <input type="text" name="name" id="project_name" class="form-control" value="{{$name}}">
                                                    </div>
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn width-100">{{trans('overtime.type')}}</button>
                                                        </div>
                                                        <select name="type" id="ot_type" class="form-control">
                                                            <option {{ !empty(request('type'))?'':'selected="selected"' }} value="">{{  trans('vendor.drop_box.placeholder-default') }}</option>
                                                            @foreach($ot_type as $type)
                                                                <option value="{{$type->name}}"{{ (string)$type->name===request('type')?'selected="selected"':'' }}>
                                                                    @if ($type->name == 'normal')
                                                                    {{trans('overtime.day_type.normal')}}
                                                                    @elseif($type->name == 'weekend')
                                                                    {{trans('overtime.day_type.day_off')}}
                                                                    @elseif($type->name == 'holiday')
                                                                    {{trans('overtime.day_type.holiday')}}
                                                                    @endif  
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn width-100">{{trans('overtime.status')}}</button>
                                                        </div>
                                                        <select name="status" id="ot_status" class="form-control">
                                                        <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">{{  trans('vendor.drop_box.placeholder-default') }}</option>
                                                            @foreach($ot_status as $status)
                                                                <option value="{{ $status->name}}" {{ (string)$status->name===request('status')?'selected="selected"':'' }}>
                                                                    @if($status->name == "Accepted")
                                                                        {{ trans('overtime.status_type.accepted') }}
                                                                    @elseif($status->name == "Rejected")
                                                                        {{ trans('overtime.status_type.rejected') }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn width-100">{{trans('overtime.start_time')}}</button>
                                                        </div>
                                                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{$from_date}}">
                                                    </div>
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn width-100">{{trans('overtime.end_time')}}</button>
                                                        </div>
                                                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{$to_date}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer center">
                                            <button id="btn_reset_overtime" type="button" class="btn btn-default"><span class="fa fa-refresh"></span>
                                                {{trans('common.button.reset')}}
                                            </button>
                                            <button type="submit" id="searchListOvertime" class="btn btn-info"><span
                                                        class="fa fa-search"></span>
                                                {{trans('common.button.search')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                        <th class="text-center">{{ trans('overtime.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0
                                @endphp
                                @foreach($ot as $value)
                                    <tr class="employee-menu" id="employee-id-{{$value['id']}}"
                                    data-employee-id="{{$value['id']}}" >
                                        <td class="text-center" rowspan="">{{$i+1}}</td>
                                        @if(isset($value['project']['name']))
                                            <td rowspan="">{{$value['project']['name']}}</td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        <td>{{$value['employee']['name'] }}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($value['date']))}}</td>
                                        <td>{{$value["reason"]}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["start_time"])->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$value["end_time"])->format('H:i')}}</td>
                                        @if(isset($value["total_time"]))
                                            <td class="text-center"><span class="label label-primary">{{$value["total_time"]}} 
                                                @php
                                                    if ($value["total_time"]>1) {
                                                        echo trans('overtime.hours');
                                                    }else{
                                                        echo trans('overtime.hours');
                                                    }
                                                @endphp
                                                <span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        @if($value['type']['name'] == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">{{ trans('overtime.day_type.normal') }}</span></td>
                                        @elseif($value['type']['name'] == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">{{ trans('overtime.day_type.day_off') }}</span></td>
                                        @elseif($value['type']['name'] == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">{{ trans('overtime.day_type.holiday') }}</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if(isset($value['correct_total_time']))
                                            <td class="text-center"><span class="label label-success">{{$value['correct_total_time']}} 
                                                @php
                                                    if ($value["correct_total_time"]>1) {
                                                        echo trans('overtime.hours');
                                                    }else{
                                                        echo trans('overtime.hours');
                                                    }
                                                @endphp
                                                <span></td>
                                        @else
                                            <td class="text-center"><span>-<span></td>
                                        @endif
                                        
                                        @if($value['status']['name'] == "Accepted")
                                            <td class="text-center"><span class="label label-success">{{ trans('overtime.status_type.accepted') }}<span></td>
                                        @elseif($value['status']['name'] == "Rejected" )
                                            <td class="text-center"><span class="label label-danger">{{ trans('overtime.status_type.rejected') }}<span></td>
                                        @endif
                                        <ul class="contextMenu" data-employee-id="{{$value['id']}}" hidden>
                                            <li><a href="{{ route('employee.show',['employee'=> $value['employee_id']]) }}?basic=0&project=0&overtime=1&absence=0">
                                                    <i class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a>
                                            </li>
                                        </ul>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
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
        $("#btn_reset_overtime").on("click", function () {
                $("#project_name").val('');
                $("#ot_type").val('').change();
                $("#ot_status").val('').change();
                $("#from_date").val('').change();
                $("#to_date").val('').change();
            });
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
