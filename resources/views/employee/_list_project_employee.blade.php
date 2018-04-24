<div class="box-body">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6">
        <div class="dataTables_length" id="project-list_length" style="float:right">
            <label>Show entries
                <select id="select_length" name="project-list_length"
                        aria-controls="project-list"
                        class="form-control input-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>
        </div>
    </div>

    <script>
        (function () {
            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_process').submit()
                // var val = $(this).val();
                // alert(val);
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
                <td>{{isset($process->project)?getProjectStatus($process->project):''}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
