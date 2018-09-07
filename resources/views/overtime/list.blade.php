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
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demooo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                                </button>
                                <div id="demooo" class="collapse margin-form-search">
                                    <form method="get" role="form">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.id')}}</button>
                                                            </div>
                                                            <input type="text" name="id" id="employeeId" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Date type</button>
                                                            </div>
                                                            <select name="team" id="team_employee" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Status</button>
                                                            </div>
                                                            <select name="team" id="team_employee" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Date</button>
                                                            </div>
                                                            <input type="date" name="date" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Month</button>
                                                            </div>
                                                            <select name="month" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button"
                                                                        class="btn width-100">Year</button>
                                                            </div>
                                                            <select name="year" class="form-control">
                                                                <option></option>
                                                                <option></option>
                                                                <option></option>
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
                                <div style="float: right; margin-bottom: 15px;">
                                    <label class="lable-entries" style="float: right;">{{trans('pagination.show.number_record_per_page')}}</label><br />
                                    <select class="input-entries" style="float: right;">
                                        <option>10</option>
                                        <option>20</option>
                                        <option>30</option>
                                    </select>
                                </div>
                            </div>
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
