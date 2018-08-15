@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <h4 class="modal-title">{{  trans('common.path.absence') }}</h4>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a>
                </li>
                <li><a href="{{asset('/employee')}}">{{trans('common.path.absence')}}</a></li>
                <li class="active">{{trans('common.path.po_project')}}</li>
            </ol>

        </section>

        <section class="content">
            <div class="nav-tabs-custom">
                {{--<ul class="nav nav-tabs">--}}
                    {{--<li>--}}
                        {{--<a id="tab-confirmation" href="#confirmation" data-toggle="tab">{{trans('common.path.confirmation')}}</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a id="tab-statistic" href="#statistic" data-toggle="tab">{{trans('common.path.statistic')}}</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                <?php
                $number_record_per_page = null; $employee_name = null; $email = null; $project_id = null; $absence_type = null;
                $from_date = null; $to_date = null; $confirm_status = null; $page=1;
                $arrays[] = $_GET;
                foreach ($arrays as $key => $value) {
                    if (!empty($value['number_record_per_page'])) {
                        $number_record_per_page = $value['number_record_per_page'];
                    }
                    if (!empty($value['employee_name'])) {
                        $employee_name = $value['employee_name'];
                    }
                    if (!empty($value['email'])) {
                        $email = $value['email'];
                    }
                    if (!empty($value['project_id'])) {
                        $project_id = $value['project_id'];
                    }
                    if (!empty($value['absence_type'])) {
                        $absence_type = $value['absence_type'];
                    }
                    if (!empty($value['from_date'])) {
                        $from_date = $value['from_date'];
                    }
                    if (!empty($value['to_date'])) {
                        $to_date = $value['to_date'];
                    }
                    if (!empty($value['confirm_status'])) {
                        $confirm_status = $value['confirm_status'];
                    }
                    if (!empty($value['page'])) {
                        $page = $value['page'];
                    }
                }
                ?>
                {{--<div class="tab-content">--}}
                    {{--<div class="tab-pane" id="confirmation">--}}
                <div class="tab-content">
                    <div>
                        <div class="box-body">
                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                            <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                            <button  type="button" class="btn btn-default export-confirm-list" id="click-here" style="float: right"
                                     onclick="return confirmExport('{{trans('absence_po.list_po.msg.confirm_export')}}')">
                                <a id="export"
                                   href="{{asset('export-confirm-list').'?'.'po_id='.$id.'&number_record_per_page='.$number_record_per_page
                                   .'&employee_name='.$employee_name.'&email='.$email.'&project_id='.$project_id.'&absence_type='.$absence_type
                                   .'&from_date='.$from_date.'&to_date='.$to_date.'&confirm_status='.$confirm_status.'&page='.$page}}">
                                    <i class="fa fa-vcard"></i>
                                    <span id="contain-canvas" style="">
                                <canvas id="my_canvas" width="16" height="16" style=""></canvas>
                            </span>
                                    {{trans('common.button.export')}}</a>
                            </button>
                        </button>
                        <div id="demo" class="collapse">
                            <div class="modal-dialog">
                            {!! Form::open(
                                ['url' =>route('confirmRequest'),
                                'method'=>'GET',
                                'id'=>'form_search_confirm'
                                ]) !!}
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                                       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.employee_name')}}</button>
                                                    </div>
                                                    {{ Form::text('employee_name', old('employee_name'),
                                                        ['class' => 'form-control',
                                                        'id' => 'employee_name',
                                                        'autofocus' => false,
                                                        ])
                                                    }}
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.email')}}</button>
                                                    </div>
                                                    {{ Form::text('email', old('email'),
                                                        ['class' => 'form-control',
                                                        'id' => 'email',
                                                        'autofocus' => false,
                                                        ])
                                                    }}
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.project_name')}}</button>
                                                    </div>
                                                    <select name="project_id" id="project_id" class="form-control">
                                                        <option {{!empty(request('project_id'))?'':'selected="selected"'}} value="">
                                                            {{trans('employee.drop_box.placeholder-default')}}
                                                        </option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->project_id}}"
                                                                    {{ (string)$project->project_id===request('project_id')?'selected="selected"':'' }}>
                                                                {{$project->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.type')}}</button>
                                                    </div>
                                                    <select name="absence_type" id="absence_type" class="form-control">
                                                        <option {{!empty(request('absence_type'))?'':'selected="selected"'}} value="">
                                                            {{trans('employee.drop_box.placeholder-default')}}
                                                        </option>
                                                        @foreach($absenceType as $item)
                                                            <option value="{{$item->id}}"
                                                                    {{ (string)$item->id===request('absence_type')?'selected="selected"':'' }}>
                                                                {{trans('absence_po.list_po.type.'.$item->name)}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                                <div class="input-group margin date form_datetime" >
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.from')}}</button>
                                                    </div>
                                                    <div class='input-group date form_datetime' style="width:100%;">
                                                        {{ Form::text('from_date', old('from_date'),
                                                        ['class' => 'form-control',
                                                        'id' => 'from_date',
                                                        'autofocus' => false,
                                                        'placeholder'=>'yyyy-MM-dd HH:mm'
                                                        ])
                                                    }}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                    </div>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.to')}}</button>
                                                    </div>
                                                    {{--{{ Form::text('to_date', old('to_date'),--}}
                                                        {{--['class' => 'form-control',--}}
                                                        {{--'id' => 'to_date',--}}
                                                        {{--'autofocus' => false,--}}
                                                        {{--])--}}
                                                    {{--}}--}}
                                                    <div class='input-group date form_datetime' style="width:100%;">
                                                        {{ Form::text('to_date', old('to_date'),
                                                        ['class' => 'form-control',
                                                        'id' => 'to_date',
                                                        'autofocus' => false,
                                                        'placeholder'=>'yyyy-MM-dd HH:mm'
                                                        ])
                                                    }}
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                    </div>
                                                    </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.status')}}</button>
                                                    </div>
                                                    <select name="confirm_status" id="confirm_status" class="form-control">
                                                        <option {{!empty(request('confirm_status'))?'':'selected="selected"'}} value="">
                                                            {{trans('employee.drop_box.placeholder-default')}}
                                                        </option>
                                                        @foreach($absenceStatus as $item)
                                                            <option value="{{$item->id}}"
                                                                    {{ (string)$item->id===request('confirm_status')?'selected="selected"':'' }}>
                                                                {{trans('absence_po.list_po.status.'.$item->name )}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer center">
                                        <button id="btn_reset" type="button" class="btn btn-default"><span class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
                                        </button>
                                        <button id="btn-submit-search" type="submit" class="btn btn-primary"><span class="fa fa-search"></span> {{ trans('common.button.search')  }}</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                            <div class="dataTables_length" id="confirm-list-length" style="float:right">
                                <span>{{trans('pagination.show.number_record_per_page')}}</span>
                                {!! Form::select(
                                    'select_length',
                                    getArraySelectOption() ,
                                    null ,
                                    [
                                    'id'=>'select_length',
                                    'class' => 'form-control input-sm',
                                    'aria-controls'=>"confirm-list-length"
                                    ]
                                    )
                                 !!}

                            </div>

                            <style type="text/css">
                                .list-confirm tr td {
                                    vertical-align: middle !important;
                                }
                            </style>
                            <table id="confirm-po-list" class="table table-bordered table-striped">
                            <thead class="list-confirm">
                            <tr>
                                <th hidden>ID</th>
                                <th>{{trans('absence.confirmation.employee_name')}}</th>
                                <th>{{trans('absence.confirmation.email')}}</th>
                                <th>{{trans('absence.confirmation.project_name')}}</th>
                                <th>{{trans('absence.confirmation.from')}}</th>
                                <th>{{trans('absence.confirmation.to')}}</th>
                                <th>{{trans('absence.confirmation.type')}}</th>
                                <th>{{trans('absence.confirmation.cause')}}</th>
                                <th>{{trans('absence.confirmation.description')}}</th>
                                <th>{{trans('absence.confirmation.action')}}</th>
                                <th>{{trans('absence.confirmation.status')}}</th>
                                <th>{{trans('absence.confirmation.reject_cause')}}</th>
                            </tr>
                            </thead>
                            <tbody class="list-confirm">
                            <?php
                                $idWaiting = $absenceStatus->where('name', '=', 'waiting')->first()->id;
                                $idAccepted = $absenceStatus->where('name', '=', 'accepted')->first()->id;
                                $idRejected = $absenceStatus->where('name', '=', 'rejected')->first()->id;
                            ?>
                            @foreach($listConfirm as $confirm)
                                <tr>
                                    <td hidden>{{$confirm->id}}</td>
                                    <td>{{isset($confirm->absence)?isset($confirm->absence->employee)?$confirm->absence->employee->name:'-':'-'}}</td>

                                    <td>{{isset($confirm->absence)?isset($confirm->absence->employee)?$confirm->absence->employee->email:'-':'-'}}</td>
                                    <td>{{isset($confirm->project)?$confirm->project->name:'-'}}</td>
                                    <td>{{isset($confirm->absence)?$confirm->absence->from_date:'-'}}</td>
                                    <td>{{isset($confirm->absence)?$confirm->absence->to_date:'-'}}</td>
                                    <td><span
                                        <?php
                                            $absenceTypeName = isset($confirm->absence)?isset($confirm->absence->absenceType)?
                                                                $confirm->absence->absenceType->name:'-':'-';
                                        ?>
                                        @if($absenceTypeName === config('settings.status_common.absence_type.salary_date'))
                                            class="label label-success"
                                        @elseif($absenceTypeName === config('settings.status_common.absence_type.insurance_date'))
                                            class="label label-primary"
                                        @elseif($absenceTypeName === config('settings.status_common.absence_type.non_salary_date'))
                                            class="label label-warning"
                                        @endif
                                        >{{$absenceTypeName === '-' ? '-' : trans('absence_po.list_po.type.'.$absenceTypeName)}}</span></td>
                                    <td>{{isset($confirm->absence)?$confirm->absence->reason:'-'}}</td>
                                    <td>{{isset($confirm->absence)?isset($confirm->absence->description)?$confirm->absence->description:'-':'-'}}</td>
                                    <td class="description-confirm" id="description-confirm-{{$confirm->id}}">
                                        @if($confirm->absence_status_id === $idWaiting)
                                            @if($confirm->absence->is_deny === 0)
                                                <span class="label label-primary">{{trans('absence.confirmation.absence_request')}}</span>
                                            @elseif($confirm->absence->is_deny === 1)
                                                <span class="label label-warning">{{trans('absence.confirmation.cancel_request')}}</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td id="status-confirm-{{$confirm->id}}">
                                        @if($confirm->absence_status_id === $idWaiting)
                                            @if($confirm->absence->is_deny === 0)
                                                <div class="btn-group-vertical">
                                                    <button class="btn btn-xs btn-primary button-confirm" id="button-absence-accept-{{$confirm->id}}">{{trans('absence_po.list_po.modal.done')}}</button>
                                                    <button class="btn btn-xs btn-danger button-confirm" id="button-absence-reject-{{$confirm->id}}" data-toggle="modal"
                                                            data-target="#show-modal-confirm">{{trans('absence_po.list_po.modal.cancel')}}</button>
                                                </div>
                                            @elseif($confirm->absence->is_deny === 1)
                                                <div class="btn-group-vertical">
                                                    <button class="btn btn-xs btn-primary button-confirm" id="button-cancel-accept-{{$confirm->id}}">{{trans('absence_po.list_po.modal.done')}}</button>
                                                    <button class="btn btn-xs btn-danger button-confirm" id="button-cancel-reject-{{$confirm->id}}" data-toggle="modal"
                                                            data-target="#show-modal-confirm">{{trans('absence_po.list_po.modal.cancel')}}</button>
                                                </div>
                                            @endif
                                        @else
                                            @if($confirm->absence_status_id === $idAccepted)
                                                <span class="label label-success">{{trans('absence_po.list_po.status.absence_accepted')}}</span>
                                            @elseif($confirm->absence_status_id === $idRejected)
                                                <span class="label label-default">{{trans('absence_po.list_po.status.absence_rejected')}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="reason-confirm" id="reason-confirm-{{$confirm->id}}">
                                        {{isset($confirm->reason)?$confirm->reason:'-'}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            <div class="row">
                                @if($listConfirm->hasPages())
                                    <div class="col-sm-4">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                            {{getInformationDataTable($listConfirm)}}
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        {{  $listConfirm->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
                            </div>

                            <div id="show-modal-confirm" class="modal fade" role="dialog">
                                <div class="modal-dialog" style="width: 400px">
                                    <!-- Modal content-->
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><th>{{trans('absence_po.list_po.modal.reason')}}</th></h4>

                                            <div class="modal-body">
                                                <div>
                                                    <textarea class="form-control" rows="5" id="reason-content" required="required"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" data-dismiss="modal" id="btn-submit-form-reject-reason">Gửi</button>
                                            </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane" id="statistic">

                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- Main content -->
        </section>
        <!-- /.content -->
    <!-- /.content-wrapper -->
    <!-- jQuery 3 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).ready(function () {
                $('#tab-confirmation').tab('show');

                $('#confirm-po-list').DataTable({
                    'paging': false,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': false,
                    'autoWidth': false,
                    "aaSorting": [
                        [0, 'DESC'],
                    ],
                });

                $('.button-confirm').click(function(){
                    var id_element = $(this).attr('id');
                    var id_td_button = $(this).parent().parent().attr('id');
                    var id_td_description = $(this).parent().parent().parent().find('td.description-confirm').attr('id');
                    var id_td_reason = $(this).parent().parent().parent().find('td.reason-confirm').attr('id');
                    var type_confirm = id_element.split('-')[1];
                    var action_confirm = id_element.split('-')[2];
                    var id_confirm = id_element.split('-')[3];
                    if(action_confirm == 'reject'){
                        $('#btn-submit-form-reject-reason').click(function(){
                            var reason = $('#reason-content').val();
                            if(reason != "") {
                                ajaxConfirm(type_confirm, action_confirm, id_confirm, reason, id_td_button, id_td_description, id_td_reason);
                            }
                            $('#btn-submit-form-reject-reason').off();
                        });
                    } else {
                        ajaxConfirm(type_confirm, action_confirm, id_confirm, "", id_td_button, id_td_description, id_td_reason)
                    }
                });

                select_length_page();
            });
        });
    </script>
    <script>
        function ajaxConfirm(type_confirm, action_confirm, id_confirm, reason, id_td_button, id_td_description, id_td_reason) {
            $.ajax({
                type: "POST",
                url: '{{ url('/absence/po-project/' . $id) }}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'type_confirm': type_confirm,
                    'action_confirm': action_confirm,
                    'id_confirm': id_confirm,
                    'reason': reason,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    $('#' + id_td_button).html(msg.msg);
                    $('#' + id_td_description).html('-');
                    if(reason != ""){
                        $('#' + id_td_reason).html(reason);
                    }
                    $('#reason-content').val("");
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $("#btn_reset").on("click", function () {
                $("#employee_name").val('');
                $("#email").val('');
                $("#project_id").val('').change();
                $("#absence_type").val('').change();
                $("#from_date").val('');
                $("#to_date").val('');
                $("#confirm_status").val('').change();
            });
        });
    </script>
    <script>
        (function () {
            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_confirm').submit()
            });
        })();

        function select_length_page(){
            var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
            var options = $("#select_length option");
            var select = $('#select_length');

            for(var i = 0 ; i< options.length ; i++){
                if(options[i].value=== old){
                    select.val(old).change();
                }
            }
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $('.form_datetime').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1});
        });
    </script>
    <SCRIPT LANGUAGE="JavaScript">
        function confirmExport(msg) {
            $check = confirm(msg);
            if($check == true){
                $(document).ready(function (){
                    var ctx = document.getElementById('my_canvas').getContext('2d');
                    var al = 0;
                    var start = 4.72;
                    var cw = ctx.canvas.width;
                    var ch = ctx.canvas.height;
                    var diff;
                    function runTime() {
                        diff = ((al / 100) * Math.PI*0.2*10).toFixed(2);
                        ctx.clearRect(0, 0, cw, ch);
                        ctx.lineWidth = 3;
                        ctx.fillStyle = '#09F';
                        ctx.strokeStyle = "#09F";
                        ctx.textAlign = 'center';
                        ctx.beginPath();
                        ctx.arc(10, 10, 5, start, diff/1+start, false);
                        ctx.stroke();
                        if (al >= 100) {
                            clearTimeout(sim);
                            sim = null;
                            al=0;
                            $("#contain-canvas").css("visibility","hidden")
                            // Add scripting here that will run when progress completes
                        }
                        al++;
                    }
                    var sim = null;
                    $("i.fa fa-vcard").css("visibility","hidden")
                    $("#contain-canvas").css("visibility","visible")
                    sim = setInterval(runTime, 15 );

                });
            }
            return $check;
        }
    </SCRIPT>
@endsection