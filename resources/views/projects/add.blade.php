@extends('admin.template')
@section('content')

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add project
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>
                <li><a href="{{route('projects.index')}}">{{trans('project.title')}}</a></li>
                <li class="active">{{trans('common.path.add_project')}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row>">
                <!-- SELECT2 EXAMPLE -->
                <div class="box box-primary">
                    <div id="msg">
                    </div>
                    <div class="box-body">
                        @include('projects._form_add_project');
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <style>
        button.btn.btn-info.pull-left {
            float: left;
            width: 115px;
        }
    </style>
@endsection