function formatDate(date,pattern) {
    var dateObj = null;
    var arr = date.split("/", 3);
    if(arr.length==1){
        arr = date.split("-", 3);
    }
    switch (pattern){
        // from standand to d/m/y
        case 'd/m/Y':
            dateObj = arr[2] +"/"+ arr[1]+"/"+arr[0];
            break;
        // from d/m/y to standand
        case 'Y/m/d':
            dateObj = arr[2] +"/"+ arr[1]+"/"+arr[0];
            break;
    }
    return dateObj;
}


function getEstimateCost(date1, date2, man_power) {
    var salary = 10000000;
    var t1 = new Date(date1);
    var t2 = new Date(date2);
    var dif = t2.getTime() - t1.getTime();
    dif = Math.abs(dif / (1000*3600*24));
    return dif * man_power * salary;
}

function calculateEstimateCost() {
    var manpowers = $('.man_power').map(function()
    {
        return $(this).text();
    });
    var start_date_processes = $('.start_date_process').map(function(){
        return $(this).text();
    });
    var end_date_processes = $('.end_date_process').map(function(){
        return $(this).text();
    });
    var total_cost=0;
    for(var i = 0 ; i<manpowers.length ; i++ ){
        total_cost = total_cost+ getEstimateCost(formatDate(end_date_processes[i],'Y/m/d'),formatDate(start_date_processes[i],'Y/m/d'),manpowers[i]);
    }
    return total_cost;
}


function requestAjax(url, token) {
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
                $(document).scrollTop($("#list_error").offset().top);
                var errors = '';
                console.log(json);
                $('#list_error').html('');
                checkDuplicateEmployee(employee_id);
                checkDuplicateRole(role);
                $.each(json[0], function (key, value) {
                    if (value && value.length && value[0] !== '') {
                        errors += "<strong>Error!</strong> " + value + "<br>";
                    }
                });
                if (json['available_processes'] && json['available_processes'].length) {
                    var string_available_processes = '';
                    $.each(json['available_processes'], function (key, value) {
                        string_available_processes +=
                            " project_id : " + value['project_id'] +
                            " man_power : " + value['man_power'] +
                            " start_date : " + formatDate(value['start_date'],'d/m/Y') +
                            " end_date : " + formatDate(value['end_date'],'d/m/Y') + "<br>";
                    });
                    var string_total = "You can view suggest information of this employee : <br>" + string_available_processes;
                    $('#list_error').prepend(string_total);
                }
                $('#list_error').css('display', 'block');
                $('#list_error').prepend(errors);
            }

            if (json.hasOwnProperty('msg_success')) {
                $('#list_error').html('');
                $('#list_error').css('display', 'none');
                alert(json['msg_success']);
                var id_member = $('#employee_id :selected').val();
                var element =
                    "<tr id=\"member_" + id_member + " \">" +
                    "<td style=\"width: 17%;\" >" + employee_name + "</td>" +
                    "<td class=\"man_power\" style=\"width: 17%;\" >" + man_power + "</td>" +
                    "<td style=\"width: 17%;\" >" + role_name + "</td>" +
                    "<td class=\"start_date_process\" style=\"width: 27%;\" >" + formatDate(start_date_process,'d/m/Y') + "</td>" +
                    "<td class=\"end_date_process\" >" + formatDate(end_date_process,'d/m/Y') + "</td>" +
                    "<td> <a>" +
                    "<i name=\"" + employee_name + "\" id=\"" + id_member + "\" class=\"fa fa-remove removeajax\"></i>" +
                    "</a> </td>" +
                    "</tr>";
                $('#table_add').css('display', 'block');
                $('#list_add').prepend(element);
                $('#estimate_cost').val(calculateEstimateCost());
                $('#member_' + id_member).prop('disabled', true);
                $('#employee_id').select2();
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

// function removeAjax(id, target, url, token) {
//     var object_this = target;
//     $.ajax({
//         url: url,
//         type: 'POST',
//         data: {
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             _token: token,
//             id: id,
//         },
//         success: function (json) {
//             if (json.hasOwnProperty('msg_success')) {
//                 alert(json['msg_success']);
//                 object_this.remove();
//                 $('#estimate_cost').val(calculateEstimateCost());
//                 $('#member_' + id).prop('disabled', false);
//                 $('#employee_id').select2();
//             }
//             if (json.hasOwnProperty('msg_fail')) {
//                 alert(json['msg_fail'])
//             }
//
//         },
//         error: function (json) {
//             if (json.status === 422) {
//                 var errors = json.responseJSON;
//                 $.each(json.responseJSON, function (key, value) {
//                     $('#list_error').html(value);
//                 });
//             } else {
//                 // Error
//                 // Incorrect credentials
//                 // alert('Incorrect credentials. Please try again.')
//             }
//         }
//     });
// }

function resetFormAddProject() {
    $("#list_error").empty();
    $("#list_error").css('display', 'none');
    $("#id").val('');
    $("#name").val('');
    $("#estimate_start_date").val('');
    $("#estimate_end_date").val('');
    $("#start_date_project").val('');
    $("#end_date_project").val('');
    $("#employee_id").val('').change();
    $("#man_power").val('').change();
    $("#role").val('').change();
    $("#start_date_process").val('').change();
    $("#end_date_process").val('').change();
    $("#income").val('');
    $("#estimate_cost").val('');
    $("#real_cost").val('');
    $("#description").val('');
    $("#status").val('').change();
    $(document).scrollTop($("#list_error").offset().top);
}

function removeEmployee(employee_id, target) {
    var object_this = target;
    object_this.remove();
    $('#estimate_cost').val(calculateEstimateCost());
    $('#member_' + employee_id).prop('disabled', false);
    $('#employee_id').select2();
}

function checkDuplicateEmployee(employee_id){
    var listCurrentEmployee = [];
    var i = 0;
    var arr = [];
    var item = "";
    $('#list_add tr').each(function() {
        item = $(this).closest("tr").attr('id');
        arr = item.split("_", 3);
        listCurrentEmployee[i++] = arr[1];
    });
    if(checkExist(listCurrentEmployee, employee_id)){
        $("#list_error").append("<strong>Error!</strong> Member in process can't duplicate.<br />");
        $("#list_error").css('display', 'block');
    }
}

function checkExist(listCurrentEmployee, current_id) {
    for (var i = 0; i < listCurrentEmployee.length; i++){
        if (current_id == listCurrentEmployee[i]){
            return true;
        }
    }
    return false;
}

function checkDuplicateRole(role_id){
    var listCurrentEmployee = [];
    var i = 0;
    var arr = [];
    var item = "";
    $('#list_add tr').each(function() {
        item = $(this).closest("tr").attr('id');
        arr = item.split("_", 3);
        listCurrentEmployee[i++] = arr[2];
    });
    if(checkExist(listCurrentEmployee, role_id)){
        $("#list_error").append("<strong>Error!</strong> Project can't has over one PO .<br />");
        $("#list_error").css('display', 'block');
    }
}

