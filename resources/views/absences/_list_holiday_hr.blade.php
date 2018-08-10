<input id="number_record_per_page" type="hidden" name="number_record_per_page"
       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
<div class="dataTables_length" id="project-list_length" style="float:right">
    <label>{{trans('pagination.show.number_record_per_page')}}
        {!! Form::select(
            'select_length',
            getArraySelectOption() ,
            null ,
            [
            'id'=>'select_length',
            'class' => 'form-control input-sm',
            'aria-controls'=>"project-list"
            ]
            )
         !!}
    </label>
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
        .list-project tr td {
            vertical-align: middle !important;
        }
    </style>
    <tr class="list-project">
        <th class="text-center project-center">Tên ngày nghỉ</th>
        <th class="text-center project-center">Năm</th>
        <th class="text-center project-center">Tháng</th>
        <th class="text-center project-center">Ngày</th>
        <th class="text-center project-center">Loại nghỉ</th>
        <th class="text-center project-center">Ghi chú</th>
    </tr>
    </thead>

    <style type="text/css">
        .list-project tr td {
            vertical-align: middle !important;
        }
    </style>
    <tbody class="context-menu list-project">

    @foreach($list_holiday as $holiday)
        <tr class="holiday-menu" id="holiday-id-{{$holiday['id']}}" data-employee-id="{{$holiday['id']}}">
            <td>{{ $holiday['name']}}</td>
            <td>{{ $holiday['date']->format('Y')}}</td>
            <td>{{ $holiday['date']->format('m')}}</td>
            <td>{{ $holiday['date']->format('d')}}</td>
            <td>{{ $holiday['description']}}</td>
            <td>{{ $holiday['description']}}</td>

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{ trans('employee.profile_info.email')}}]"--}}
                    {{--value="{{$employee[trans('employee.profile_info.email')]}}">--}}

            {{--<td>{{$employee[trans('absence.total_date_absences')] }}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{ trans('absence.total_date_absences') }}]"--}}
                    {{--value="{{$employee[trans('absence.total_date_absences')] }}">--}}

            {{--<td>{{$employee[trans('absence.last_year_absences_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.last_year_absences_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.last_year_absences_date')]}}">--}}

            {{--<td>{{$employee[trans('absence.absented_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.absented_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.absented_date')]}}">--}}

            {{--<td>{{$employee[trans('absence.non_salary_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.non_salary_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.non_salary_date')]}}">--}}

            {{--<td>{{$employee[trans('absence.insurance_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.insurance_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.insurance_date')]}}">--}}

            {{--<td>{{$employee[trans('absence.subtract_salary_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.subtract_salary_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.subtract_salary_date')]}}">--}}

            {{--<td>{{$employee[trans('absence.remaining_date')]}}</td>--}}

            {{--<input  type="hidden"--}}
                    {{--name="absences[{{$employee['id']}}][{{trans('absence.remaining_date')}}]"--}}
                    {{--value="{{$employee[trans('absence.remaining_date')]}}">--}}

            {{--<ul class="contextMenu" data-employee-id="{{$employee['id']}}" hidden>--}}
                {{--<li><a href={{route('absences.show',$employee['id'])}}><i--}}
                                {{--class="fa fa-id-card"></i> {{trans('common.action.view')}}--}}
                    {{--</a></li>--}}
            {{--</ul>--}}
        </tr>
    @endforeach
    </tbody>
</table>
{{--@if($employees->hasPages())--}}
    {{--<div class="col-sm-5">--}}
        {{--<div class="dataTables_info" style="float:left" id="example2_info" role="status"--}}
             {{--aria-live="polite">--}}
            {{--{{getInformationDataTable($employees)}}--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-sm-7">--}}
        {{--{{  $employees->appends($param)->render('vendor.pagination.custom') }}--}}
    {{--</div>--}}
{{--@endif--}}