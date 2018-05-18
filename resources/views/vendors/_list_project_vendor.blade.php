<div class="box-body">
    <div class="col-sm-6">
    </div>
    <div>
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

    <script>
        (function () {
            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_process').submit()
            });
        })();

    </script>

    <table id="project-list" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>{{trans('project.id')}}</th>
            <th>{{trans('project.name')}}</th>
            <th>{{trans('project.role')}}</th>
            <th>{{trans('project.start_date')}}</th>
            <th>{{trans('project.end_date')}}</th>
            <th>{{trans('project.status')}}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($processes as $process)
            <tr>
                <td>{{ isset($process->project)?$process->project->id:'-' }}</td>
                <td>{{ isset($process->project)?$process->project->name:'-' }}</td>
                <td>{{ isset($process->role)?$process->role->name:'-'}}</td>
                <td>{{isset($process->start_date)?date('d/m/Y', strtotime($process->start_date)):'-'}}</td>
                <td>{{isset($process->end_date)?date('d/m/Y', strtotime($process->end_date)):'-'}}</td>
                <td>{{isset($process->project)?getProjectStatus($process->project):'-'}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
