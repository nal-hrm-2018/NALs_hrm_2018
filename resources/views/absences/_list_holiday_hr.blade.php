<div class="main-container container-fluid">
    <!-- table -->
    <table class="table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
        <thead class="thead-dark">
        <tr>
            <th class="text-center project-center">{{trans('holiday.name')}}</th>
            <th class="text-center project-center">{{trans('holiday.year')}}</th>
            <th class="text-center project-center">{{trans('holiday.month')}}</th>
            <th class="text-center project-center">{{trans('holiday.day')}}</th>
            <th class="text-center project-center">{{trans('holiday.type')}}</th>
            <th class="text-center project-center">{{trans('holiday.description')}}</th>
            <th class="text-center project-center" colspan="2">{{trans('holiday.action')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list_holiday as $holiday)
        <tr class="data-row">
            <td class="align-middle id-holiday" hidden>{{ $holiday['id']}}</td>
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

