<script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
<div class="box-body">
    <!-- <div class="col-sm-6">
    </div> -->
    <div>
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
            <span class="fa fa-search"></span>&nbsp;Search
        </button>
        @include('employee._model_search_process')
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
    </div> 
    <table id="project-list" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>{{trans('project.id')}}</th>
            <th>{{trans('project.name')}}</th>
            <th>{{trans('project.role')}}</th>
            <th class="text-center">{{trans('project.process_start_date')}}</th>
            <th class="text-center">{{trans('project.process_end_date')}}</th>
            <th>{{trans('project.status')}}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($processes as $process)
            <tr>
                <td>{{ isset($process->project)?$process->project->id:'-' }}</td>
                <td>{{ isset($process->project)?$process->project->name:'-' }}</td>
                <td>
                    <?php
                    if(isset($process->role)){
                        if($process->role->name == "PO"){
                            echo "<span class='label label-primary'>". $process->role->name ."</span>";
                        } else if($process->role->name == "Dev"){
                            echo "<span class='label label-success'>". $process->role->name ."</span>";
                        } else if($process->role->name == "BA"){
                            echo "<span class='label label-info'>". $process->role->name ."</span>";
                        } else if($process->role->name == "ScrumMaster"){
                            echo "<span class='label label-warning'>". $process->role->name ."</span>";
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td class="text-center">{{isset($process->start_date)?date('d/m/Y', strtotime($process->start_date)):'-'}}</td>
                <td class="text-center">{{isset($process->end_date)?date('d/m/Y', strtotime($process->end_date)):'-'}}</td>
                <td>
                    <?php
                    if(isset($process->project)){
                        if(getProjectStatus($process->project) == "kick off"){
                            echo "<span class='label label-primary'>". getProjectStatus($process->project) ."</span>";
                        } else if(getProjectStatus($process->project) == "pending"){
                            echo "<span class='label label-danger'>". getProjectStatus($process->project) ."</span>";
                        } else if(getProjectStatus($process->project) == "in-progress"){
                            echo "<span class='label label-info'>". getProjectStatus($process->project) ."</span>";
                        } else if(getProjectStatus($process->project) == "releasing"){
                            echo "<span class='label label-warning'>". getProjectStatus($process->project) ."</span>";
                        } else if(getProjectStatus($process->project) == "complete"){
                            echo "<span class='label label-success'>". getProjectStatus($process->project) ."</span>";
                        } else if(getProjectStatus($process->project) == "planning"){
                            echo "<span class='label label-default'>". getProjectStatus($process->project) ."</span>";
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>

            </tr>
        @endforeach
    </table>
    @if($processes->hasPages())
        <div class="col-sm-5">
            <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                {{getInformationDataTable($processes)}}
            </div>
        </div>
        <div class="col-sm-7">
            {{  $processes->appends($param)->render('vendor.pagination.custom') }}
        </div>
    @endif
</div>
<script>
    (function () {
        $('#select_length').change(function () {
            $("#number_record_per_page").val($(this).val());
            $('#form_search_process').submit()
        });
    })();

    $(document).ready(function (){
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "extract-date-pre": function (value) {
                var date = value;
                date = date.split('/');
                return Date.parse(date[1] + '/' + date[0] + '/' + date[2])
            },
            "extract-date-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "extract-date-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        $('#project-list').dataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'borderCollapse': 'collapse',
            "aaSorting": [
                [3, 'desc'],[4, 'desc']
            ],
            columnDefs: [{
                type: 'extract-date',
                targets: [3,4]
            }
            ]
        });
    });
</script>
