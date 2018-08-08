$("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
                });

$(document).ready(function(){
            $(".btn-search").click(function() {
                var form = $(this).closest('.form-search');
                $('#myModal')
                    .modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    .one('click', '.btn-search-confirm', function() {
                        form.submit();
                    })
            }); 
        });
