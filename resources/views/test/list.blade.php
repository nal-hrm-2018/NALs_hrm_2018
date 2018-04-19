<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./resource/css/css_bootrap.css"/>
    <title>css_bootrap</title>
</head>
<body>
<div class="container" style="margin-top:60px">
    <div class="row">
        <table class="table table-bordered">

            <tbody>
            @foreach ($processes as $processe)
                <tr>
                    <td>
                        <p>
                            {{ $processe->project()->first()->name }}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{ $processe->role()->first()->name }}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{ $processe->start_date }}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{ $processe->end_date }}
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ var_dump($param) }}
        {{ $processes->appends($param)->render() }}
    </div>
    <hr>
</div>
</body>
</html>