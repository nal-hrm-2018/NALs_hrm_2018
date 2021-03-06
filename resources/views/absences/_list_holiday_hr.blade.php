<style type="text/css">
    tr td {
        vertical-align: middle !important; 
    }

    tr th {
        vertical-align: middle !important; 
    }
</style>

<div class="main-container container-fluid">
    <div class="input-group col-md-4">
        <input class="form-control" id="search" placeholder="Search name of holiday" name="s" autocomplete="off"
               autofocus>
        <div class="input-group-btn">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    id="yearSelector">
                Year
            </button>
            <div class="dropdown-menu dropdown-menu-right" style="background: #ededed; min-width: unset;">
                @for ($i = $min_year; $i <= $max_year+1; $i++)
                    <a class="dropdown-item select-year" href="javascript:void(0)" onclick="searchTableYear(this.innerHTML)">{{$i}}</a>
                @endfor
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item select-year" href="javascript:void(0)" onclick="searchTableYear('all')">All</a>
            </div>
            <style type="text/css">
                .select-year {
                    color: #333; 
                    display: block; 
                    padding: 10px 20px;
                }

                .select-year:hover {
                    background: white;
                }
            </style>
        </div>
        <input id="year_now" value="{{$year_now}}" hidden>
    </div>
    <br>
    <div class="results"></div>
    <!-- table -->
    <table class="table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
        <thead class="thead-dark">
        <tr class="header">
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
        @foreach($list_holiday_default as $holiday)
            <tr class="data-row default-year">
                <td class="align-middle id-holiday" hidden>{{ $holiday['id']}}</td>
                <td class="align-middle name-holiday">{{ $holiday['name']}}</td>
                <td class="align-middle text-center year-holiday">All year</td>
                <td class="align-middle text-center month-holiday">{{ $holiday['date']->format('m')}}</td>
                <td class="align-middle text-center day-holiday">{{ $holiday['date']->format('d')}}</td>
                <td class="align-middle text-center type-holiday-id" style="display: none;">{{ $holiday['status']['id']}}</td>
                <td class="align-middle  type-holiday">{{ $holiday['status']['name']}}</td>
                <td class="align-middle description-holiday">{{ $holiday['description']}}</td>
                <!-- <td class="align-middle text-center">
                    {{--<button type="button" class="btn btn-warning" id="edit-item" data-item-id="1"><i class="fa fa-edit"></i></button>--}}
                </td>
                <td class="align-middle text-center">
                    {{--<form action="{{route('absences-holiday-delete',['id' => $holiday['id']])}}" method="post" class="holiday-delete">--}}
                        {{--@csrf--}}
                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                        {{--<button class="btn btn-danger" type="submit">--}}
                            {{--<i class="fa fa-trash"></i></button>--}}
                    {{--</form>--}}
                </td> -->
                <td class="align-middle text-center">-</td>
            </tr>
        @endforeach
        @foreach($list_holiday as $holiday)
            <tr class="data-row">
                <td class="align-middle id-holiday" hidden>{{ $holiday['id']}}</td>
                <td class="align-middle name-holiday">{{ $holiday['name']}}</td>
                <td class="align-middle text-center year-holiday">{{ $holiday['date']->format('Y')}}</td>
                <td class="align-middle text-center month-holiday">{{ $holiday['date']->format('m')}}</td>
                <td class="align-middle text-center day-holiday">{{ $holiday['date']->format('d')}}</td>
                <td class="align-middle text-center type-holiday-id" style="display: none;">{{ $holiday['status']['id']}}</td>
                <td class="align-middle type-holiday">{{ $holiday['status']['name']}}</td>
                <td class="align-middle description-holiday">{{ $holiday['description']}}</td>
                <td class="align-middle text-center">
                    <button type="button" class="btn btn-default" id="edit-item" data-item-id="1" data-toggle="modal" data-target="#edit-modal"><i class="fa fa-pencil"></i></button>
                
                    <form action="{{route('absences-holiday-delete',['id' => $holiday['id']])}}" method="post" class="holiday-delete" style="display: inline;">
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
<script>
    window.onload = function() {
        searchTableYear($('#year_now').val());
    };
    $(function () {
        $('#search').on('input', function () {
            searchRow();
        });
    })

    function searchRow() {
        var $rows = $('#myTable > tbody > tr').not(".header");
        var val1 = $.trim($('#search').val()).replace(/ +/g, ' ').toLowerCase();
        var val2 = $.trim($("#yearSelector").text()).toLowerCase();
        val2 = (val2 === "year") ? "" : val2;

        $rows.show().filter(function () {
            var text1 = $(this).find('td:nth-child(2)').text().replace(/\s+/g, ' ').toLowerCase();
            var text2 = $(this).find('td:nth-child(3)').text().replace(/\s+/g, ' ').toLowerCase();
            return !~text1.indexOf(val1) || !~text2.indexOf(val2) && text2.indexOf('all year');
        }).hide();
    }

    function searchTableYear(year) {
        $("#yearSelector").html(year);

        if (year == "all") {
            $("#yearSelector").html("Year");
        }

        searchRow();
    }
</script>
