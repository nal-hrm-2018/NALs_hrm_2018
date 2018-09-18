<input id="number_record_per_page" type="hidden" name="number_record_per_page"
       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
<div style="float:right; margin-bottom: 15px;">
    <div class="dataTables_length" id="project-list_length">
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
                $('#form_search_employee').submit()
            }
        </script>
    </div>
</div>

<script>
    (function () {
        $('#select_length').change(function () {
            $("#number_record_per_page").val($(this).val());
            $('#form_search_employee').submit()
        });
    })();
</script>
    <table id="" class="table table-bordered table-striped">
    {{-- <table id="hr-absence-list" class="table table-bordered table-striped"> --}}
        <thead>
        <style type="text/css">
            .list-project th {
                vertical-align: middle !important;
            }
        </style>
        <!-- <tr class="list-project">
            <th colspan="4"></th>
            <th class="text-center project-center" colspan="3">{{trans('absence.number_of_days_off')}}</th>
            <th colspan="2"></th>
        </tr> -->
        <tr class="list-project">
            <th class="text-center project-center">{{trans('common.number')}} </th>
            <th class="text-center project-center">{{trans('common.name.employee_name')}}</th>
            <th class="text-center project-center">{{trans('employee.profile_info.email')}}</th>
            <th class="text-center project-center">{{trans('absence.type.this_year')}}</th>
            <th class="text-center project-center">{{trans('absence.type.last_year')}}</th>
            <th class="text-center project-center">{{trans('absence.type.annual_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.unpaid_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.maternity_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.marriage_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.bereavement_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.sick_leave')}}</th>
            <th class="text-center project-center">{{trans('absence.type.remaining_leave')}}</th>
        </tr>
        </thead>

        <style type="text/css">
            .list-project td {
                vertical-align: middle !important;
            }
        </style>
        <tbody class="context-menu">
        @php
            $count = 0
        @endphp
        @foreach($list_absences as $employee)
            <tr class="employee-menu" id="employee-id-{{$employee['id']}}" data-employee-id="{{$employee['id']}}">
                @php
                    $count++;
                @endphp
                <td>{{$count}}</td>
                <td
                        {{checkExpiredPolicy(
                                    $employee['id'],
                                    empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
                                    empty(request()->get('month_absence'))?null:request()->get('month_absence')
                                )?"style=background-color:red":''
                        }}
                >{{ $employee['name']}}</td>

                <input  type="hidden"
                       name="absences[{{$employee['id']}}][{{ trans('common.name.employee_name')}}]"
                       value="{{$employee['name']}}">

                <td>{{$employee['email']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{ trans('employee.profile_info.email')}}]"
                        value="{{$employee['email']}}">

                <td>{{$employee['pemission_annual_leave'] }}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{ trans('absence.type.this_year') }}]"
                        value="{{$employee['pemission_annual_leave'] }}">

                <td>{{$employee['remaining_last_year'] }}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{ trans('absence.type.last_year') }}]"
                        value="{{$employee['remaining_last_year'] }}">

                <td>{{$employee['annual_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.annual_leave')}}]"
                        value="{{$employee['annual_leave']}}">

                <td>{{$employee['unpaid_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.unpaid_leave')}}]"
                        value="{{$employee['unpaid_leave']}}">

                <td>{{$employee['maternity_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.maternity_leave')}}]"
                        value="{{$employee['maternity_leave']}}">

                <td>{{$employee['marriage_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.marriage_leave')}}]"
                        value="{{$employee['marriage_leave']}}">

                <td>{{$employee['bereavement_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.bereavement_leave')}}]"
                        value="{{$employee['bereavement_leave']}}">

                <td>{{$employee['sick_leave']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.type.sick_leave')}}]"
                        value="{{$employee['sick_leave']}}">

                <td>{{$employee['remaining_this_year']}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.remaining_date')}}]"
                        value="{{$employee['remaining_this_year']}}">

                <ul class="contextMenu" data-employee-id="{{$employee['id']}}" hidden>
                    <li><a href="{{ route('employee.show',['employee'=> $employee['id']]) }}?basic=0&project=0&overtime=0&absence=1"><i
                                    class="fa fa-id-card width-icon-contextmenu"></i> {{trans('common.action.view')}}
                        </a></li>
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