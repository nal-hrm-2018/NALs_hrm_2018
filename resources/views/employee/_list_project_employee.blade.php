<div class="box-body">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6">
        <div class="dataTables_length" id="project-list_length" style="float:right">
            <label>Show entries
                <select name="project-list_length"
                        aria-controls="project-list"
                        class="form-control input-sm"
                        id="record-in-page">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>
        </div>
    </div>

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
                <td>{{isset($process->project)?$process->project->status:''}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
