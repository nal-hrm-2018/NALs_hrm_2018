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
        <th colspan="4"></th>
        <th class="text-center project-center" colspan="3">{{trans('absence.number_of_days_off')}}</th>
        <th colspan="2"></th>
    </tr>
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
        .list-project tr td {
            vertical-align: middle !important;
        }
    </style>
    <tbody class="context-menu list-project">
    @foreach($employees as $employee)

    @endforeach
    </tbody>
</table>
@if($employees->hasPages())
    <div class="col-sm-5">
        <div class="dataTables_info" style="float:left" id="example2_info" role="status"
             aria-live="polite">
            {{getInformationDataTable($employees)}}
        </div>
    </div>
    <div class="col-sm-7">
        {{  $employees->appends($param)->render('vendor.pagination.custom') }}
    </div>
@endif