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

    <hr>
    <div class="row">
        <div class="col-md-12 col-sm-12" style="border: 1px">
            {!! Form::open(
            ['url' =>route('search-process'),
            'class' => 'form-inline',
            'method'=>'GET'
            ]) !!}
            @include('test.form')
            <div class="form-group">
                <div class="col-md-2 col-md-offset-5">
                    {{ Form::reset(trans('common.button.reset'), ['class' => 'btn  btn-primary btn-flat']) }}
                    {{ Form::submit(trans('common.button.insert'), ['class' => 'btn  btn-secondary btn-flat']) }}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</body>
</html>