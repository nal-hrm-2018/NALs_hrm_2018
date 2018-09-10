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
        <section class="content-header">
            <div style="display: flex; flex-direction: row-reverse;">
                {{--<button class="btn btn-default">--}}
                    {{--<a href="">--}}
                        {{--<i class="glyphicon glyphicon-export"></i>&nbsp;--}}
                    {{--</a>--}}
                {{--</button>--}}
                {{--{{trans('common.button.export')}}--}}
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                        	<div>
                        		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                                </button>
                                <div id="demo" class="collapse margin-form-search">
                                    <form method="get" role="form" id="form_search_employee">
                                        <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                               value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
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
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.name')}}</button>
                                                            </div>
                                                            <input type="text" name="name" id="nameEmployee" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">{{trans('employee.profile_info.team')}}</button>
                                                            </div>
                                                            <select name="team" id="team_employee" class="form-control">
                                                                <option {{ !empty(request('team'))?'':'selected="selected"' }} value="">
                                                                    {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                                @foreach($teams as $team)
                                                                    <option value="{{ $team->name}}" {{ (string)$team->name===request('team')?'selected="selected"':'' }}>
                                                                        {{ $team->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Date</button>
                                                            </div>
                                                            <input type="date" name="date_ot" class="form-control">
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn width-100">Month</button>
                                                            </div>
                                                            <select name="month_ot" class="form-control">
                                                                <option {{ !empty(request('team'))?'':'selected="selected"' }} value="">
                                                                    {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                                @php
                                                                $dataMonth = [1,2,3,4,5,6,7,8,9,10,11,12];
                                                                @endphp
                                                                @foreach($dataMonth as $month)
                                                                <?php
                                                                    $selected="";
                                                                    if ($month == request()->get('month_ot')) {
                                                                        $selected = "selected";
                                                                    }
                                                                ?>
                                                                <option value="{{$month}}" <?php echo $selected;?>>{{$month}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group margin">
                                                            <div class="input-group-btn">
                                                                <button type="button"
                                                                        class="btn width-100"> Year</button>
                                                            </div>
                                                            <select name="year_ot" class="form-control">
                                                                <option {{ !empty(request('team'))?'':'selected="selected"' }} value="">
                                                                    {{  trans('vendor.drop_box.placeholder-default') }}
                                                                </option>
                                                                <?php
                                                                $selectedNow = ""; $selectedLessThanNow = "";
                                                                    if(request()->get('year_ot')==date("Y")){
                                                                        $selectedNow = "selected";
                                                                    }
                                                                if(request()->get('year_ot')==date("Y")-1){
                                                                    $selectedLessThanNow = "selected";
                                                                }
                                                                ?>
                                                                <option value="{{ date("Y") }}" <?php echo $selectedNow; ?>>{{ date("Y") }}</option>
                                                                <option value="{{ date("Y")-1 }}" <?php echo $selectedLessThanNow; ?>>{{ date("Y")-1 }}</option>
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
                                            $('#form_search_employee').submit()
                                        }
                                    </script>
	                            </div>
                        	</div>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Employee ID</th>
                                        <th>Name</th>
                                        <th>Project</th>
                                        <th class="text-center"><span class="label" style="background: #9072ff;">Normal day</span></th>
                                        <th class="text-center"><span class="label" style="background: #643aff;">Day off</span></th>
                                        <th class="text-center"><span class="label" style="background: #3600ff;">Holiday</span></th>
                                    </tr>
                                </thead>
                                <tbody class="context-menu">
                                @foreach($employees as $employee)
                                    <tr class="employee-menu" id="employee-id-{{$employee->id}}"
                                        data-employee-id="{{$employee->id}}">
                                        <td class="text-center">{{ isset($employee->id)?$employee->id:'-' }}</td>
                                        <td>{{ isset($employee->name)?$employee->name:'-' }}</td>
                                        <td>
                                            @foreach($employee->projects as $process)
                                                @php
                                                    echo $process->name.',';
                                                @endphp
                                            @endforeach
                                        </td>
                                        <?php
                                        $date_ot = ""; $year_ot="";
                                        if(request()->get('date_ot') !== null){
                                            $date_ot= request()->get('date_ot');
                                            $sumNomarday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',1)->whereDate('date', '=', $date_ot)->sum('total_time');
                                            $sumWeekend = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',2)->whereDate('date', '=', $date_ot)->sum('total_time');
                                            $sumHoliday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',3)->whereDate('date', '=', $date_ot)->sum('total_time');
                                        }elseif(request()->get('year_ot') !== null){
                                            $year_ot= request()->get('year_ot');
                                            $sumNomarday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',1)->whereYear('date', $year_ot)->sum('total_time');
                                            $sumWeekend = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',2)->whereYear('date', $year_ot)->sum('total_time');
                                            $sumHoliday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',3)->whereYear('date', $year_ot)->sum('total_time');
                                        }elseif(request()->get('month_ot') !== null){
                                            $month_ot= request()->get('month_ot');
                                            $sumNomarday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',1)->whereMonth('date', $month_ot)->sum('total_time');
                                            $sumWeekend = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',2)->whereMonth('date', $month_ot)->sum('total_time');
                                            $sumHoliday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',3)->whereMonth('date', $month_ot)->sum('total_time');
                                        }else{
                                            $year_ot= request()->get('year_ot');
                                            $sumNomarday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',1)->whereMonth('date', date('m'))->sum('total_time');
                                            $sumWeekend = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',2)->whereMonth('date', date('m'))->sum('total_time');
                                            $sumHoliday = DB::table('overtime')->where('employee_id',$employee->id)->where('overtime_type_id',3)->whereMonth('date', date('m'))->sum('total_time');
                                        }
                                        ?>
                                        @if($sumNomarday > 0)
                                        <td class="text-center"><span class="label label-success">{{ isset($sumNomarday)?$sumNomarday:'-' }}</span></td>
                                        @else
                                        <td class="text-center"><span class="">-</span></td>
                                        @endif
                                        @if($sumWeekend > 0)
                                            <td class="text-center"><span class="label label-success">{{ isset($sumWeekend)?$sumWeekend:'-' }}</span></td>
                                        @else
                                            <td class="text-center"><span class="">-</span></td>
                                        @endif
                                        @if($sumHoliday > 0)
                                            <td class="text-center"><span class="label label-success">{{ isset($sumHoliday)?$sumHoliday:'-' }}</span></td>
                                        @else
                                            <td class="text-center"><span class="">-</span></td>
                                        @endif
                                        <ul class="contextMenu" data-employee-id="{{$employee->id}}" hidden>
                                            <li><a href="{{ route('employee.show',['employee'=> $employee->id]) }}?basic=0&project=0&overtime=1&absence=0">
                                                    <i class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}</a>
                                            </li>
                                        </ul>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                @if($employees->hasPages())
                                    <div class="col-sm-5">
                                        <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                            {{getInformationDataTable($employees)}}
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        {{  $employees->appends($param)->render('vendor.pagination.custom') }}
                                    </div>
                                @endif
                            </div>
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
 <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
 <script type="text/javascript">
     $(function () {
         $('tr.employee-menu').on('contextmenu', function (event) {
             event.preventDefault();
             $('ul.contextMenu').fadeOut("fast");
             var eId = $(this).data('employee-id');
             $('ul.contextMenu[data-employee-id="' + eId + '"]')
                 .show()
                 .css({top: event.pageY - 170, left: event.pageX - 250, 'z-index': 300});

         });
         $(document).click(function () {
             if ($('ul.contextMenu:hover').length === 0) {
                 $('ul.contextMenu').fadeOut("fast");
             }
         });
     });

 </script>
@endsection