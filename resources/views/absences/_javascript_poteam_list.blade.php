<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<script type="text/javascript">
    $(function () {
        //cancel absence
        $('.btn.btn-primary.deny').click(function () {
            var idConfirm = $(this).data('confirm-id');
            var isDeny = $(this).data('is-deny');
            var textArea = $('textarea.form-control.id-'+idConfirm+'[name="reason"]').val();
            $.ajax({
                type: "POST",
                url: '{{ url('/deny-po-team')}}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "id": idConfirm,
                    "is_deny" : isDeny,
                    'reason' : textArea,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    console.log(msg.deny);
                    console.log(msg.html);
                    $('.close').click();
                    $('.div.confirm-status[data-confirm-id="' + msg.id + '"').remove();
                    $('.center.confirm-status[data-confirm-id="' + idConfirm + '"]').html(msg.html);
                    $('.notecss-confirm[data-confirm-id="' + idConfirm + '"]').html('-');
                    $('.reason-view[data-reason-view="'+idConfirm+'"]').html(textArea);
                }
            });
        });
        //accept absences or deny
        $('.btn.btn-danger.status-absence').click(function () {
            var idConfirm = $(this).data('confirm-id');
            var isDeny = $(this).data('is-deny');
            $.ajax({
                type: "POST",
                url: '{{ url('/done-confirm')}}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "id": idConfirm,
                    "is_deny" : isDeny,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    console.log(msg.absenceStatus);
                    console.log(msg.id);
                    $('.div.confirm-status[data-confirm-id="' + idConfirm + '"').remove();
                    $('.center.confirm-status[data-confirm-id="' + idConfirm + '"]').html(msg.absenceStatus);
                    $('.notecss-confirm[data-confirm-id="' + idConfirm + '"]').html(msg.html);
                }
            });
        });

    });
</script>
{{--DataTable--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#absence-po-list').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'borderCollapse':'collapse',
            "aaSorting": [
                [0, 'DESC']
            ]
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('.form_datetime').datetimepicker({
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1});
    });
    $("#btn_reset_absence_po_team").on("click", function () {
        $("#name_absence").val('');
        $("#email_absence").val('');
        $("#start_date_absence").val('');
        $('#end_date_absence').val('');
        $('#type').val('').change();
        $('#absence_status').val('').change();
    });
</script>