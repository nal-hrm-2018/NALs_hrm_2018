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
        <div id="msg">
        </div>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;Search
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
                                                                <button type="button" class="btn width-100">Name of Project</button>
                                                            </div>
                                                            <input type="text" name="id" id="project_name" class="form-control" value="">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Date type</button>
                                                            </div>
                                                            <select name="type" id="ot_type" class="form-control">
                                                                <option {{ !empty(request('type'))?'':'selected="selected"' }} value="">
                                                                    {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                                @foreach($ot_type as $type)
                                                                    <option value="{{ $type->name}}"{{ (string)$type->name===request('type')?'selected="selected"':'' }}>
                                                                        {{ $type ->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Status</button>
                                                            </div>
                                                            <select name="status" id="ot_status" class="form-control">
                                                                    <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">
                                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                                    </option>
                                                                @foreach($ot_status as $status)
                                                                    <option value="{{ $status->name}}" {{ (string)$status->name===request('status')?'selected="selected"':'' }}>
                                                                        {{ $status->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Day</button>
                                                            </div>
                                                            <select name="days" id="days" class="form-control">
                                                                <option {{ !empty(request('day'))?'':'selected="selected"' }} value="">
                                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Month</button>
                                                            </div>
                                                            <select name="months" id="months" class="form-control">
                                                                <option {{ !empty(request('month'))?'':'selected="selected"' }} value="">
                                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Year</button>
                                                            </div>
                                                            <select name="years" id="years" class="form-control">
                                                                <option {{ !empty(request('year'))?'':'selected="selected"' }} value="">
                                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
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
                                <script>
                                    for (i = new Date().getFullYear()+1; i > 2000; i--){
                                        $('#years').append($('<option />').val(i).html(i));
                                    }
                                    for (i = 1; i < 13; i++){
                                        $('#months').append($('<option />').val(i).html(i));
                                    }
                                    updateNumberOfDays(); 
    
                                    $('#years, #months').on("change", function(){
                                        updateNumberOfDays(); 
                                    });
                                    function updateNumberOfDays(){
                                        $('#days').html('');
                                        month=$('#months').val();
                                        year=$('#years').val();
                                        days=daysInMonth(month, year);

                                        for(i=1; i < days+1 ; i++){
                                                $('#days').append($('<option />').val(i).html(i));
                                        }
                                    }
                                    function daysInMonth(month, year) {
                                        return new Date(year, month, 0).getDate();
                                    }
                                </script>
                                <div class="dataTables_length" id="project-list_length" style="float:right; margin-bottom: 20px;">
                                    <label class="lable-entries">{{trans('pagination.show.number_record_per_page')}}</label><br />
                                    <select class="input-entries" id="mySelect" onchange="myFunction()">
                                        <option value="20" <?php echo request()->get('number_record_per_page')==20?'selected':''; ?> >20</option>
                                        <option value="50" <?php echo request()->get('number_record_per_page')==50?'selected':''; ?> >50</option>
                                        <option value="100" <?php echo request()->get('number_record_per_page')==100?'selected':''; ?> >100</option>
                                    </select>
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
                                        <th class="text-center">No.</th>
                                        <th>Name of Project</th>
                                        <th class="text-center">Date</th>
                                        <th>Reasons</th>
                                        <th class="text-center">From time</th>
                                        <th class="text-center">To time</th>
                                        <th class="text-center">Total time</th>
                                        <th class="text-center">Date type</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Accept time</th>
                                        <th class="text-center">Actions</th>
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
                                        <td class="text-center">{{$i}}</td>
                                        <td>{{ isset($val->project->name)?$val->project->name:'-'}}</td>
                                        <td class="text-center">{{$val->date->format('d/m/Y')}}</td>
                                        <td>{{$val->reason}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->start_time)->format('H:i')}}</td>
                                        <td class="text-center">{{\Carbon\Carbon::createFromFormat('H:i:s',$val->end_time)->format('H:i')}}</td>
                                        <td class="text-center"><span class="label label-primary">{{$val->total_time}} hours<span></td>
                                        @if ($val->Type->name == 'normal')
                                            <td class="text-center"><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @elseif($val->Type->name == 'weekend')
                                            <td class="text-center"><span class="label" style="background: #643aff;">Day off</span></td>
                                        @elseif($val->Type->name == 'holiday')
                                            <td class="text-center"><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @else
                                            <td class="text-center"></td>
                                        @endif
                                        @if ($val->Status->name == 'Not yet')
                                            <td class="text-center"><span class="label label-default">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Reviewing')
                                            <td class="text-center"><span class="label label-info">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Accepted')
                                            <td class="text-center"><span class="label label-success">{{$val->Status->name}}</span></td>
                                        @elseif($val->Status->name == 'Rejected')
                                            <td class="text-center"><span class="label label-danger">{{$val->Status->name}}</span></td>
                                        @else
                                            <td class="text-center"></td>
                                        @endif
                                        @if ($val->correct_total_time)
                                            <td class="text-center"><span class="label label-success">{{$val->correct_total_time}} hours</span></td>
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
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7" rowspan="3"></td>
                                        <td rowspan="3">Total</td>
                                        <td><span class="label" style="background: #9072ff;">Normal day</span></td>
                                        @if ($time['normal'])
                                            <td class="text-center"><span class="label label-success">{{$time['normal']}} hours</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                        <td colspan="2" rowspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #643aff;">Day off</span></td>
                                        @if ($time['weekend'])
                                            <td class="text-center"><span class="label label-success">{{$time['weekend']}} hours</span></td>
                                        @else
                                            <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td><span class="label" style="background: #3600ff;">Holiday</span></td>
                                        @if ($time['holiday'])
                                            <td class="text-center"><span class="label label-success">{{$time['holiday']}} hours</span></td>
                                        @else
                                            <td class="text-center">-</td>
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
    <script>
        function confirm_delete(){
            return confirm(message_confirm('{{trans('common.action.remove')}}','form',''));
        }
    </script>
  <script type="text/javascript">
        $(function () {
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
