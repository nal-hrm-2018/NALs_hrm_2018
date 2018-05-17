@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Edit team
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/team">Teams</a></li>
                <li class="active">Add team</li>
            </ol>
        </section>
        <section class="content">
            <div class="form-group">
                <select class="form-control" id="multi_form" name="employees[]">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </section>
    </div>
@endsection