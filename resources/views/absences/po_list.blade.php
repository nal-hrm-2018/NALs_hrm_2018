@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{  trans('common.title_header.absence_list') }}
                <small>NAL Solutions</small>
            </h1>
        </section>

        <section class="content">
            <div class="nav-tabs-custom">
                <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                <?php
                $number_record_per_page = null; $employee_name = null; $email = null; $project_id = null; $absence_type = null;
                $from_date = null; $to_date = null; $time_type = null; $page=1;
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
                    if (!empty($value['time_type'])) {
                        $time_type = $value['time_type'];
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
                        {{-- <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                            <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                            <button  type="button" class="btn btn-default export-confirm-list" id="click-here" style="float: right"
                                     onclick="return confirmExport('{{trans('absence_po.list_po.msg.confirm_export')}}')">
                                <a id="export"
                                   href="#">
                                    <i class="fa fa-vcard"></i>
                                    {{trans('common.button.export')}}</a>
                            </button>
                        </button> --}}
                        <div id="demo" class="collapse">
                            <div class="modal-dialog">
                            {!! Form::open(
                                ['url' =>route('showListPO'),
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
                                                    <button type="button" class="btn width-100">{{trans('absence.absence_time')}}</button>
                                                </div>
                                                <select name="time_type" id="time_type" class="form-control">
                                                    <option {{!empty(request('time_type'))?'':'selected="selected"'}} value="">
                                                        {{trans('employee.drop_box.placeholder-default')}}
                                                    </option>
                                                     @foreach($absenceTime as $item)
                                                        <option value="{{$item->id}}"
                                                                {{ (string)$item->id===request('time_type')?'selected="selected"':'' }}>
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
                           {{--  <div class="dataTables_length" id="confirm-list-length" style="float:right">
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
                             !!} --}}

                        </div>

                        <style type="text/css">
                            .list-confirm tr td {
                                vertical-align: middle !important;
                            }
                        </style>
                        <table id="confirm-po-list" class="table table-bordered table-striped">
                            <thead class="list-confirm">
                            <tr>
                                <th>{{trans('overtime.number')}} </th>
                                <th>{{trans('absence.confirmation.employee_name')}}</th>
                                <th>{{trans('absence.confirmation.email')}}</th>
                                <th>{{trans('absence.confirmation.project_name')}}</th>
                                <th>{{trans('absence.confirmation.from')}}</th>
                                <th>{{trans('absence.confirmation.to')}}</th>
                                <th>{{trans('absence.absence_type')}}</th>
                                <th>{{trans('absence.absence_time')}}</th>
                                <th>{{trans('absence.reason')}}</th>
                                <th>{{trans('absence.description')}}</th>
                            </tr>
                            </thead>
                            <tbody class="list-confirm">
                                @php
                                    $count = 0
                                @endphp

                                @foreach($absence_list as $val)

                             {{-- @dd($val); @die(); --}}

                                <tr>
                                    @php
                                        $count++;
                                    @endphp
                                    <td>{{$count}}</td>
                                    <td>{{$val['name']}}</td>
                                    <td>{{$val['email']}}</td>
                                    <td>{{$val['project']}}</td> 
                                    <td>{{$val['start_date']}}</td>
                                    <td>{{$val['end_date']}}</td>
                                    @if(isset($val['absence_type']))
                                        @if($val['absence_type'] == 'annual_leave')
                                            <td>{{trans('absence.type.annual_leave')}}</td>
                                        @endif 
                                        @if($val['absence_type'] == 'unpaid_leave')
                                            <td>{{trans('absence.type.annual_leave')}}</td>
                                        @endif 
                                        @if($val['absence_type'] == 'maternity_leave')
                                            <td>{{trans('absence.type.maternity_leave')}}</td>
                                        @endif  
                                        @if($val['absence_type'] == 'marriage_leave')
                                            <td>{{trans('absence.type.marriage_leave')}}</td>
                                        @endif  
                                        @if($val['absence_type'] == 'bereavement_leave')
                                            <td>{{trans('absence.type.bereavement_leave')}}</td>
                                        @endif  
                                        @if($val['absence_type'] == 'sick_leave')
                                            <td>{{trans('absence.type.sick_leave')}}</td>
                                        @endif  
                                        @if($val['absence_type'] == 'subtract_salary_date')
                                            <td>{{trans('absence.type.subtract_salary_date')}}</td>
                                        @endif  
                                        @if($val['absence_type'] == 'insurance_date')
                                            <td>{{trans('absence.type.insurance_date')}}</td>
                                        @endif  
                                    @else
                                        <td>-</td>
                                    @endif
                                </span>
                                    @if(isset($val['absence_time']))
                                        @if($val['absence_time'] == 'all')
                                            <td>{{trans('absence.all')}}</td>
                                        @elseif($val['absence_time'] == 'morning')
                                            <td>{{trans('absence.morning')}}</td>
                                        @else
                                            <td>{{trans('absence.afternoon')}}</td>
                                        @endif
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>{{$val['reason']}}</td>
                                    <td>{{$val['description']}}</td>
                                </tr>          
                                @endforeach                  
                            </tbody>
                        </table>
                            <div class="row">
                                {{-- @if($absences->hasPages())
                                    <div class="col-sm-4">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                            {{getInformationDataTable($absences)}}
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        {{  $absences->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif --}}
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