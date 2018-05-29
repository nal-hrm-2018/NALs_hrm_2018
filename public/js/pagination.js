
$(document).ready(function () {
    var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
    var options = $("#select_length option");
    var select = $('#select_length');

    for(var i = 0 ; i< options.length ; i++){
        if(options[i].value=== old){
            select.val(old).change();
        }
    }
});