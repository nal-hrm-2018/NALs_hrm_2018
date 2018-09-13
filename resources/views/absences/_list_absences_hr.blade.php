<input id="number_record_per_page" type="hidden" name="number_record_per_page"
       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
<div style="float:right">
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
    <table id="hr-absence-list" class="table table-bordered table-striped">
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
            <th class="text-center project-center">{{trans('common.name.employee_name')}}</th>
            <th class="text-center project-center">{{trans('employee.profile_info.email')}}</th>
            <th class="text-center project-center">{{trans('absence.total_date_absences')}}</th>
            <th class="text-center project-center">{{trans('absence.last_year_absences_date')}}</th>

            <th class="text-center project-center">{{trans('absence.absented_date')}}</th>
            <th class="text-center project-center">{{trans('absence.non_salary_date')}}</th>
            <th class="text-center project-center">{{trans('absence.insurance_date')}}</th>

            <th class="text-center project-center">{{trans('absence.subtract_salary_date')}}</th>
            <th class="text-center project-center">{{trans('absence.remaining_date')}}</th>
        </tr>
        </thead>

        <style type="text/css">
            .list-project td {
                vertical-align: middle !important;
            }
        </style>
        <tbody class="context-menu">

        @foreach($list_absences as $employee)
            <tr class="employee-menu" id="employee-id-{{$employee['id']}}" data-employee-id="{{$employee['id']}}">
                <td
                        {{checkExpiredPolicy(
                                    $employee['id'],
                                    empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
                                    empty(request()->get('month_absence'))?null:request()->get('month_absence')
                                )?"style=background-color:red":''
                        }}
                >{{ $employee[trans('common.name.employee_name')]}}</td>

                <input  type="hidden"
                       name="absences[{{$employee['id']}}][{{ trans('common.name.employee_name')}}]"
                       value="{{$employee[trans('common.name.employee_name')]}}">

                <td>{{$employee[trans('employee.profile_info.email')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{ trans('employee.profile_info.email')}}]"
                        value="{{$employee[trans('employee.profile_info.email')]}}">

                <td>{{$employee[trans('absence.total_date_absences')] }}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{ trans('absence.total_date_absences') }}]"
                        value="{{$employee[trans('absence.total_date_absences')] }}">

                <td>{{$employee[trans('absence.last_year_absences_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.last_year_absences_date')}}]"
                        value="{{$employee[trans('absence.last_year_absences_date')]}}">

                <td>{{$employee[trans('absence.absented_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.absented_date')}}]"
                        value="{{$employee[trans('absence.absented_date')]}}">

                <td>{{$employee[trans('absence.non_salary_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.non_salary_date')}}]"
                        value="{{$employee[trans('absence.non_salary_date')]}}">

                <td>{{$employee[trans('absence.insurance_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.insurance_date')}}]"
                        value="{{$employee[trans('absence.insurance_date')]}}">

                <td>{{$employee[trans('absence.subtract_salary_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.subtract_salary_date')}}]"
                        value="{{$employee[trans('absence.subtract_salary_date')]}}">

                <td>{{$employee[trans('absence.remaining_date')]}}</td>

                <input  type="hidden"
                        name="absences[{{$employee['id']}}][{{trans('absence.remaining_date')}}]"
                        value="{{$employee[trans('absence.remaining_date')]}}">

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