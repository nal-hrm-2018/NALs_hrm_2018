$(document).ready(function(){ 
    document.oncontextmenu = function() {return false;};

    $('tbody>tr').mousedown(function(e){ 
        if( e.button == 2 ) { 
            $('.custom-menu')
                .css({"left": e.pageX + 'px', "top": e.pageY + 'px'})
                .show();
            return false; 
        } 
        return true; 
  }); 
});

$(document).bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        // Hide it
        $(".custom-menu").hide(100);
    }
});

$(".custom-menu li").click(function(){
    $(".custom-menu").hide(100);
});

$(document).ready(function(){
    $(".btn-search").click(function(){
        $(".form-search").toggle('1000');
    });
});
