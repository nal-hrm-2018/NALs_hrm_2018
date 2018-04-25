<div class="box-body">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6">
        <div class="dataTables_length" id="project-list_length" style="float:right">
            <label>Show entries
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
            <th>ID</th>
            <th>Project</th>
            <th>Role</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>

        @foreach($processes as $process)
            <tr>
                <td>{{ isset($process->project)?$process->project->id:'' }}</td>
                <td>{{ isset($process->project)?$process->project->name:'' }}</td>
                <td>{{ isset($process->role)?$process->role->name:''}}</td>
                <td>{{date('d/m/Y', strtotime($process->start_date))}}</td>
                <td>{{date('d/m/Y', strtotime($process->end_date))}}</td>
                <td>{{isset($process->project)?getProjectStatus($process->project):''}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
