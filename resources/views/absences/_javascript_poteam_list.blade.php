<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<script type="text/javascript">
    $(function () {
        $('.btn.btn-danger.status-absence').click(function () {
            var idConfirm = $(this).data('confirm-id');
            console.log(idConfirm);
            $.ajax({
                type: "POST",
                url: '{{ url('/done-confirm')}}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "id": idConfirm,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    $('.div.confirm-status[data-confirm-id="' + msg.id + '"').remove();
                    $('.center.confirm-status[data-confirm-id="' + idConfirm + '"]').html("{{trans('absence_po.list_po.status.accepted_done')}}");
                    $('.notecss-confirm[data-confirm-id="' + idConfirm + '"]').html(msg.html);
                }
            });
        });
        //deny done
        $('.btn.btn-danger.status-absence-deny').click(function () {
            var idConfirm = $(this).data('confirm-id');
            console.log(idConfirm);
            $.ajax({
                type: "POST",
                url: '{{ url('/done-confirm-deny')}}',
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "id": idConfirm,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    $('.div.confirm-status.deny[data-confirm-id="' + msg.id + '"').remove();
                    $('.center.confirm-status-deny[data-confirm-id="' + idConfirm + '"]').html("{{trans('absence_po.list_po.status.accepted_deny')}}");
                    $('.notecss-confirm[data-confirm-id="' + idConfirm + '"]').html(msg.html);
                }
            });
        });
        //cancel absence
        $('.btn.btn-primary.deny').click(function () {
            var idConfirm = $(this).data('confirm-id');
            var isDeny = $(this).data('is-deny');
            var textArea = $('textarea.form-control.id-'+idConfirm+'[name="reason"]').val();
            console.log(textArea);
            console.log(idConfirm);
            console.log(isDeny);
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
                    $('.close').click();
                    $('.div.confirm-status[data-confirm-id="' + msg.id + '"').remove();
                    $('.center.confirm-status[data-confirm-id="' + idConfirm + '"]').html(msg.html);
                    $('.notecss-confirm[data-confirm-id="' + idConfirm + '"]').html('-');
                    $('.reason-view[data-reason-view="'+idConfirm+'"]').html(textArea);
                }
            });
        });
    });
</script>