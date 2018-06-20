function message_confirm(action, attr, id, name){
    if(id == "" || name == ""){
        return 'Do you want to '+ action +' this ' + attr + '?';
    } else {
        return 'Do you want to '+ action +' this ' + attr + ' has ID: ' + id + ', Name: ' + name + ' ?';
    }
}
function message_confirm_add(action, attr, name) {
    if(name == ""){
        return 'Do you want to '+ action +' this ' + attr + '?';
    } else {
        return 'Do you want to '+ action +' this ' + attr + ' has Name: ' + name + ' ?';
    }
}

function message_confirm_project(action, attr, id, name){
    if(id == "" || name == ""){
        return lang.getString('confirm_add_project_2_param',[action,attr]);

    } else {
        return lang.getString('confirm_add_project_4_param',[action,attr,id,name]);
    }
}
