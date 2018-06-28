function message_confirm(action, attr, id, name){
    var language = $('#language_active').attr('lang');
    if(language == 'en'){
        if(id == "" || name == ""){
            return 'Do you want to '+ action +' this ' + attr + '?';
        } else {
            return 'Do you want to '+ action +' this ' + attr + ' has ID: ' + id + ', Name: ' + name + ' ?';
        }
    } else if(language == 'vn'){
        if(id == "" || name == ""){
            return 'Bạn có muốn ' + action + ' ' + attr + ' này không?';
        } else {
            return 'Bạn có muốn ' + action + ' ' + attr + ' có ID: ' + id + ', Tên: ' + name + ' không?';
        }
    }
}
function message_confirm_add(action, attr, name) {
    var language = $('#language_active').attr('lang');
    if(language == 'en'){
        if(name == ""){
            return 'Do you want to '+ action +' this ' + attr + '?';
        } else {
            return 'Do you want to '+ action +' this ' + attr + ' has Name: ' + name + ' ?';
        }
    } else if(language == 'vn'){
        if(name == ""){
            return 'Bạn có muốn ' + action + ' ' + attr + ' này không?';
        } else {
            return 'Bạn có muốn ' + action + ' ' + attr + ' có Tên: ' + name + ' không?';
        }
    }
}

function message_confirm_project(action, attr, id, name){
    if(id == "" || name == ""){
        return lang.getString('confirm_add_project_2_param',[action,attr]);

    } else {
        return lang.getString('confirm_add_project_4_param',[action,attr,id,name]);
    }
}

