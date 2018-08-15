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

<div class="main-container container-fluid">
    <!-- table -->
    <table class="table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
        <thead class="thead-dark">
        <tr>
            <th class="text-center project-center">STT</th>
            <th class="text-center project-center">Tên ngày nghỉ</th>
            <th class="text-center project-center">Năm</th>
            <th class="text-center project-center">Tháng</th>
            <th class="text-center project-center">Ngày</th>
            <th class="text-center project-center">Loại nghỉ</th>
            <th class="text-center project-center">Ghi chú</th>
            <th class="text-center project-center" colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list_holiday as $holiday)
        <tr class="data-row">
            <td class="align-middle id-holiday">{{ $holiday['id']}}</td>
            <td class="align-middle name-holiday">{{ $holiday['name']}}</td>
            <td class="align-middle year-holiday">{{ $holiday['date']->format('Y')}}</td>
            <td class="align-middle month-holiday">{{ $holiday['date']->format('m')}}</td>
            <td class="align-middle day-holiday">{{ $holiday['date']->format('d')}}</td>
            <td class="align-middle type-holiday-id" style="display: none;">{{ $holiday['status']['id']}}</td>
            <td class="align-middle type-holiday">{{ $holiday['status']['name']}}</td>
            <td class="align-middle description-holiday">{{ $holiday['description']}}</td>
            <td class="align-middle ">
                <button type="button" class="btn btn-warning" id="edit-item" data-item-id="1"><i class="fa fa-edit"></i></button>
            </td>
            <td class="align-middle">
                <form action="{{route('absences-holiday-delete',['id' => $holiday['id']])}}" method="post" class="holiday-delete">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">
                        <i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!-- /table -->
</div>

