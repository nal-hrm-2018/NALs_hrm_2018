<!doctype html>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        id: <input type="text" name="id" id="id"> <br><br>
        name: <input type="text" name="name", id="name"> <br><br>
        <button id="add">Add</button>
        <script>
            $('#add').click(function () {
                var id = $('#id').val();
                var name = $('#name').val();
                $.ajax({
                    type: "POST",
                    url: 'phuc_test',
                    data: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'id': id,
                        'name': name,
                        '_method': 'POST',
                        _token: '{{csrf_token()}}',
                    },
                    success: function (msg) {
                        alert('gui thanh cong' + msg);
                    }
                });

            })
        </script>
    </body>
</html>