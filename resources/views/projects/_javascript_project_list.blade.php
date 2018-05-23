

<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<script>
    (function () {
        $('#select_length').change(function () {
            $("#number_record_per_page").val($(this).val());
            $('#form_search_process').submit()
        });
    })();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
        var options = $("#select_length option");
        var select = $('#select_length');

        for (var i = 0; i < options.length; i++) {
            if (options[i].value === old) {
                select.val(old).change();
            }
        }
    });
</script>

{{--javascript validation form search--}}
<script type="text/javascript">
    $(function () {
        $('#btn_reset_edit_password').click(function () {
            $('#error_number').empty();
            $('#error_project_date').empty();
            $('#error_project_date').empty();
        });
    })
    function validate(){
        var project_name = document.getElementById("project_name").value;
        var project_po_name = document.getElementById("project_po_name").value;
        var project_name_member = document.getElementById("project_name_member").value;

        var project_date_from = document.getElementById("project_number_from").value;
        var project_date_to = document.getElementById("project_name").value;
        var project_date_real_from = document.getElementById("project_date_real_from").value;
        var project_date_real_to = document.getElementById("project_date_real_to").value;

        var project_number_to = document.getElementById("project_number_to").value;
        var project_number_from = document.getElementById("project_number_from").value;

        var check = true;
        console.log(project_date_from);
        if (project_number_from > project_number_to){
            console.log('error'); console.log(project_number_from);
            document.getElementById("error_number").innerHTML = "Error. Number in member must be in ascending order.";
            check = false;
        }
        if (project_date_from > project_date_to){
            console.log('error'); console.log(project_number_from);
            document.getElementById("error_project_date").innerHTML = "Error. Date Project must be in ascending order.";
            check = false;
        }
        if (project_date_real_from > project_date_real_to){
            console.log('error'); console.log(project_number_from);
            document.getElementById("error_project_date").innerHTML = "Error. Date Real Project must be in ascending order.";
            check = false;
        }
        return check;
    }
</script>


{{--click right mouse--}}
<script type="text/javascript">
    $(function () {
        $('tr.employee-menu').on('contextmenu', function (event) {
            event.preventDefault();
            $('ul.contextMenu').fadeOut("fast");
            var eId = $(this).data('employee-id');
            $('ul.contextMenu[data-employee-id="' + eId + '"')
                .show()
                .css({top: event.pageY - 160, left: event.pageX - 250, 'z-index': 300});

        });
        $(document).click(function () {
            if ($('ul.contextMenu:hover').length === 0) {
                $('ul.contextMenu').fadeOut("fast");
            }
        });
    });

</script>
{{--click button remove--}}
<script type="text/javascript">
    $(function () {
        $('.btn-project-remove').click(function () {
            var elementRemove = $(this).data('employee-id');
            var nameRemove = $(this).data('employee-name');
            console.log(elementRemove);
            if (confirm('Do you want to delete employee has id: ' + elementRemove + '. Name: "' + nameRemove + '"?')) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('/projects') }}' + '/' + elementRemove,
                    data: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "id": elementRemove,
                        '_method': 'DELETE',
                        _token: '{{csrf_token()}}',
                    },
                    success: function (msg) {
                        alert("Remove " + msg.status);
                        var fade = "employee-id-" + msg.id;
                        $('ul.contextMenu[data-employee-id="' + msg.id + '"').hide()
                        var fadeElement = $('#' + fade);
                        console.log(fade);
                        fadeElement.fadeOut("fast");
                    }
                });
            }
        });
    });
</script>
<script>
    $('a.show-list-employee').click(function () {
        $('#table-list-members').html("");
        var id = $(this).attr('id');
        var id_team = id.slice(19);
        {{--$('#table-list-members').append(html_{{$project->name}});--}}

        <?php
            $allProjects = $projects;
            foreach ($allProjects as $project) {
                foreach ($project->processes as $all_process) {
                    if (isset($all_process->employee->role)) {
                        $classBtr = '';
                        if ($all_process->employee->role->name == 'PO') {
                            $classBtr = 'label label-primary';
                        } else if ($all_process->employee->role->name == 'Dev') {
                            $classBtr = 'label label-success';
                        } else if ($all_process->employee->role->name == 'BA') {
                            $classBtr = 'label label-info';
                        } else if ($all_process->employee->role->name == 'ScrumMaster') {
                            $classBtr = 'label label-warning';
                        }
                        echo ' var html_' . $all_process->id . '_' . $all_process->employee->id . ' = "<tr><td>' . $all_process->employee->id . '</td><td><a href=\"employee/' . $all_process->employee->id . '\">' . $all_process->employee->name . '</a></td><td><span class=\"' . $classBtr . '\">' . $all_process->role->name . '</span></td></tr>";';
                    } else {
                        echo ' var html_' . $all_process->id . '_' . $all_process->employee->id . ' = "<tr><td>' . $all_process->employee->id . '</td><td><a href=\"employee/' . $all_process->employee->id . '\">' . $all_process->employee->name . '</a></td><td>-</td></tr>";';
                    }
                    /*echo
                        ' var html_' . $all_process->id .
                        '= "<tr><td>' . $all_process->employee->name .
                        '</td></tr>";';*/
                }
            }
            ?>
                @foreach($allProjects as $project)
                @foreach($project->processes as $all_process)
        if (id_team == "{{$project->id}}") {
            console.log({{$all_process->id}});
            $('#table-list-members').append(html_{{$all_process->id}}_{{$all_process->employee->id}});
        }
        @endforeach
        @endforeach
    });
</script>
<script>
    $(document).ready(function () {
        $('#project-list').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'borderCollapse': 'collapse',
            "aaSorting": [[4, 'DESC'], [5, 'DESC']]
        });
    });
</script>
<style>
    th.project-date {
        width: 80px;
    }

    th.project-th-members {
        width: 315px;
    }

    th.project-td-po-name {
        width: 100px;
    }
</style>