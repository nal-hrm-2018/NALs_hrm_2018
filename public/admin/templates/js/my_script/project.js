function formatDate(date) {
    dateObj = new Date(date);
    dateObj = dateObj.getDate() + "/" + dateObj.getMonth() + "/" + dateObj.getFullYear();
    return dateObj;
}

function requestAjax(url,token) {
    var employee_id = $('#employee_id :selected').val();
    var employee_name = $('#employee_id :selected').text();
    var estimate_start_date = $('#estimate_start_date').val();
    var estimate_end_date = $('#estimate_end_date').val();
    var start_date_project = $('#start_date_project').val();
    var end_date_project = $('#end_date_project').val();
    var end_date_process = $('#end_date_process').val();
    var start_date_process = $('#start_date_process').val();
    var man_power = $('#man_power').val();
    var role = $('#role').val();
    var role_name = $('#role :selected').text();

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            employee_id: employee_id,
            estimate_start_date: estimate_start_date,
            estimate_end_date: estimate_end_date,
            start_date_project: start_date_project,
            end_date_project: end_date_project,
            end_date_process: end_date_process,
            start_date_process: start_date_process,
            man_power: man_power,
            role: role,
            _token: token,

        },
        success: function (json) {
            if (json.hasOwnProperty('available_processes')) {
                $(document).scrollTop( $("#list_error").offset().top );
                var errors = '';
                console.log(json);
                $('#list_error').html('');
                $.each(json[0], function (key, value) {
                    if (value && value.length && value[0] !== '') {
                        errors += "<strong>Error!</strong> " + value + "<br>"
                    }
                    ;
                });
                if (json['available_processes'] && json['available_processes'].length) {
                    var string_available_processes = '';
                    var startdateObj;
                    var enddateObj;
                    $.each(json['available_processes'], function (key, value) {
                        startdateObj = new Date(value['start_date']);
                        enddateObj = new Date(value['end_date']);
                        startdateObj = startdateObj.getDate() + "/" + startdateObj.getMonth() + "/" + startdateObj.getFullYear();
                        enddateObj = enddateObj.getDate() + "/" + enddateObj.getMonth() + "/" + enddateObj.getFullYear();
                        string_available_processes +=
                            " project_id : " + value['project_id'] +
                            " man_power : " + value['man_power'] +
                            " start_date : " + startdateObj +
                            " end_date : " + enddateObj + "<br>";
                    });
                    var string_total = "You can view suggest information of this employee : <br>" + string_available_processes;
                    $('#list_error').prepend(string_total);
                }
                $('#list_error').css('display', 'block');
                $('#list_error').prepend(errors);
            }

            if (json.hasOwnProperty('msg_success')) {
                $(document).scrollTop( $("#process_box").offset().top );
                $('#list_error').html('');
                $('#list_error').css('display', 'none');
                alert(json['msg_success'])
                var id_member = $('#employee_id :selected').val();
                var element =
                    "<tr id=\"member_" + id_member + " \">" +
                    "<td>" + employee_name + "</td>" +
                    "<td>" + man_power + "</td>" +
                    "<td>" + role_name + "</td>" +
                    "<td>" + formatDate(start_date_process) + "</td>" +
                    "<td>" + formatDate(end_date_process) + "</td>" +
                    "<td> <a>" +
                    "<i name=\"" + employee_name + "\" id=\"" + id_member + "\" class=\"fa fa-remove removeajax\"></i>" +
                    "</a> </td>" +
                    "</tr>"
                $('#table_add').css('display', 'block');
                $('#list_add').prepend(element);
            }
            if (json.hasOwnProperty('msg_fail')) {
                alert(json['msg_fail'])
            }
        },
        error: function (json) {
            if (json.status === 422) {
                var errors = json.responseJSON;
                $.each(json.responseJSON, function (key, value) {
                    $('#list_error').html(value);

                });
            } else {
                // Error
                // Incorrect credentials
                // alert('Incorrect credentials. Please try again.')
            }
        }
    });
}

function removeAjax(id, target ,url,token) {
    var object_this = target;
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            _token: token,
            id: id,
        },
        success: function (json) {
            if (json.hasOwnProperty('msg_success')) {
                alert(json['msg_success']);
                object_this.remove();
            }
            if (json.hasOwnProperty('msg_fail')) {
                alert(json['msg_fail'])
            }

        },
        error: function (json) {
            if (json.status === 422) {
                var errors = json.responseJSON;
                $.each(json.responseJSON, function (key, value) {
                    $('#list_error').html(value);
                });
            } else {
                // Error
                // Incorrect credentials
                // alert('Incorrect credentials. Please try again.')
            }
        }
    });
}