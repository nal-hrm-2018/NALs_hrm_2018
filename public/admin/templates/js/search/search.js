
$(document).ready(function () {
    if(window.location.href.indexOf("?")== -1){
        $("#iconSearch").addClass("glyphicon-chevron-down");
    }
    if(window.location.href.indexOf("?")!= -1){
        $("#iconSearch").addClass("glyphicon-chevron-up");
        $("#demo").addClass("in");
    }
});
$(function () {
    $('#clickCollapse').click(function () {
        if($("#iconSearch").hasClass("glyphicon-chevron-up")){
            $("#iconSearch").removeClass("glyphicon-chevron-up");
            $("#iconSearch").addClass("glyphicon-chevron-down");
        }else{
            $("#iconSearch").removeClass("glyphicon-chevron-down");
            $("#iconSearch").addClass("glyphicon-chevron-up");
        }
    });
});
