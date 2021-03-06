@extends('admin.template')
@section('content') 
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
    	.form-inline {
    	    display: inline;
    	}
    </style>

 <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
            <h1>
                {{trans('leftbar.nav.list.overtime')}}
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
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
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
                                                                        @if($status->name == "Not yet")
                                                                            {{ trans('overtime.status_type.not_yet') }}
                                                                        @elseif($status->name == "Reviewing")
                                                                            {{ trans('overtime.status_type.review') }}
                                                                        @elseif($status->name == "Accepted")
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
                                                                <button type="button" class="btn width-100">{{trans('overtime.from_date')}}</button>
                                                            </div>
                                                            <input type="date" name="from_date" id="from_date" class="form-control" value="{{$from_date}}">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('overtime.to_date')}}</button>
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
                                <div style="float: right;">
                                    <div class="dataTables_length" id="project-list_length" style="margin-bottom: 20px;">
                                        <label class="lable-entries" style="display: block;">{{trans('pagination.show.number_record_per_page')}}</label>
                                        <div class="input-entries">
                                            <select id="mySelect" onchange="myFunction()" style="width: 100%;">
                                                <option value="20" <?php echo request()->get('number_record_per_page')==20?'selected':''; ?> >20</option>
                                                <option value="50" <?php echo request()->get('number_record_per_page')==50?'selected':''; ?> >50</option>
                                                <option value="100" <?php echo request()->get('number_record_per_page')==100?'selected':''; ?> >100</option>
                                            </select>
                                        </div>
                                        <script>
                                            function myFunction() {
                                                var x = document.getElementById("mySelect").value;
                                                console.log(x);
                                                $('#number_record_per_page').val(x);
                                                $('#form_search_overtime').submit()
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <script>
                                (function () {
                                    $('#select_length').change(function () {
                                        $("#number_record_per_page").val($(this).val());
                                        $('#form_search_overtime').submit()
                                    });
                                })();
                            </script>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{trans('overtime.number')}}</th>
                                        <th>{{trans('overtime.project')}}</th>
                                        <th class="text-center">{{trans('overtime.date')}}</th>
                                        <th>{{trans('overtime.reason')}}</th>
                                        <th class="text-center">{{trans('overtime.start_time')}}</th>
                                        <th class="text-center">{{trans('overtime.end_time')}}</th>
                                        <th class="text-center">{{trans('overtime.total_time')}}</th>
                                        <th class="text-center">{{trans('overtime.type')}}</th>
                                        <th class="text-center">{{trans('overtime.status')}}</th>
                                        <th class="text-center">{{trans('overtime.correct_total_time')}}</th>
                                        <th class="text-center">{{trans('overtime.action')}}</th>
                                        <th class="text-center">{{ trans('overtime.reject_reason') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                            $i = ($page-1)*$number_record_per_page;    
                                        @endphp
                                    @foreach($ot as $val)
                                        @php
                                            $i+=1;
                                        @endphp
                                        <td class="text-center">{{$i}}</td>
                                        <td>{{ isset($val->process->project->name)?$val->process->project->name:'-'}}</td>
                                        <td class="text-center">{{$val->date->format('d/m/Y')}}</td>
                                        <td>{{$val->reason}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->start_time)->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->end_time)->format('H:i')}}</td>
                                        <td class="text-center"><span class="label label-primary">{{$val->total_time}} {{ ($val["total_time"]<2)? trans('overtime.hour'): trans('overtime.hours') }}<span></td>
                                        @if ($val->Type->name == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">{{trans('overtime.day_type.normal')}}</span></td>
                                        @elseif($val->Type->name == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">{{trans('overtime.day_type.day_off')}}</span></td>
                                        @elseif($val->Type->name == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">{{trans('overtime.day_type.holiday')}}</span></td>
                                        @else
                                            <td class="text-center"></td>
                                        @endif
                                        @if ($val->Status->name == 'Not yet')
                                            <td class="text-center"><span class="label label-default">{{trans('overtime.not_yet')}}</span></td>
                                        @elseif($val->Status->name == 'Reviewing')
                                            <td class="text-center"><span class="label label-info">{{trans('overtime.reviewing')}}</span></td>
                                        @elseif($val->Status->name == 'Accepted')
                                            <td class="text-center"><span class="label label-success">{{trans('overtime.accepted')}}</span></td>
                                        @elseif($val->Status->name == 'Rejected')
                                            <td class="text-center"><span class="label label-danger">{{trans('overtime.rejected')}}</span></td>
                                        @else
                                            <td class="text-center"></td>
                                        @endif
                                        @if (isset($val->correct_total_time))
                                            <td class="text-center"><span class="label label-success">{{$val->correct_total_time}} {{($val["correct_total_time"]<2)? trans('overtime.hour'): trans('overtime.hours') }}</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        @if ($val->Status->name == 'Not yet')
                                        <td class="text-center">
                                            <a class="btn btn-default" href="ot/{{$val->id}}/edit"><em class="fa fa-pencil"></em></a>
                                            {{ Form::open(array('url' => ['/ot', $val["id"]], 'method' => 'delete', 'class' => 'form-inline')) }}
                                                <button type="submit" onclick="return confirm_delete();" class="btn btn-danger">
                                                    <em class="fa fa-trash"></em>
                                                </button>
                                            {{ Form::close() }}
                                        </td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        <td>{{$val->reason_reject}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7" rowspan="3"></td>
                                        <td rowspan="3">{{trans('overtime.total')}}</td>
                                        <td><span class="label" style="background: #9072ff;">{{trans('overtime.day_type.normal')}}</span></td>
                                        @if ($time['normal'])
                                            <td class="text-center">
                                                <span class="label label-success">{{$time['normal']}} {{($time['normal']<2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                            </td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        <td colspan="2" rowspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #643aff;">{{trans('overtime.day_type.day_off')}}</span></td>
                                        @if ($time['weekend'])
                                            <td class="text-center">
                                                <span class="label label-success">{{$time['weekend']}} {{($time['weekend']<2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                            </td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #3600ff;">{{trans('overtime.day_type.holiday')}}</span></td>
                                        @if ($time['holiday'])
                                            <td class="text-center">
                                                <span class="label label-success">{{$time['holiday']}} {{($time['holiday']<2)? trans('overtime.hour'): trans('overtime.hours') }}</span>
                                            </td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                @if($ot->hasPages())
                                    {{-- <div class="col-sm-5">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                            {{getInformationDataTable($ot)}}
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-12">
                                        {{  $ot->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
    <script>
        function confirm_delete(){
            return confirm(message_confirm('{{trans('common.action.remove')}}','form',''));
        }
    </script>
  <script type="text/javascript">
        $(function () {
            $("#btn_reset_overtime").on("click", function () {
                $("#project_name").val('');
                $("#ot_type").val('').change();
                $("#ot_status").val('').change();
                $("#from_date").val('').change();
                $("#to_date").val('').change();
            });
            $('.btn-overtime-remove').click(function () {
                var elementRemove = $(this).data('overtime-id');
                console.log(elementRemove);
                if (confirm(message_confirm('{{trans("common.action_confirm.delete")}}', 'form', ""))) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/ot') }}' + '/' + elementRemove,
                        data: {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            "id": elementRemove,
                            '_method': 'DELETE',
                            _token: '{{csrf_token()}}',
                        },
                        success: function (msg) {
                            alert(msg.status);
                            var fade = "overtime-id-" + msg.id;
                            $('ul.contextMenu[data-overtime-id="' + msg.id + '"').hide();
                            var fadeElement = $('#' + fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
                }
            });
        });
    </script>
@endsection
