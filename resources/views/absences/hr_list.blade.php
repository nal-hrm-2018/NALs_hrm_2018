<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:00 AM
 */ ?>

@extends('admin.template')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('common.title_header.absence_list')}}
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>
                <li><a href="{{route('absences-hr')}}"> {{trans('common.path.absences')}}</a></li>
                <li><a href="#">{{trans('common.title_header.absence_list')}}</a></li>
            </ol>
        </section>
        {{--table data project--}}
        <div id="msg"></div>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                        <div class="box-body">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch"
                                                                                              class="glyphicon"></span>
                                </button>
                                {!! Form::open(
                                [
                                'url' =>route('absences-hr'),
                                'method'=>'get',
                                'id'=>'form_search_hr',
                                'role'=>'form'
                                ]) !!}
                                @include("absences._form_search_hr")
                                <div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>
                                <div class="form-row">
                                @include('absences._form_filter_hr')
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-12" style="width: 100% ; margin-bottom: 1em"></div>
                            @include('absences._list_absences_hr')
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
            var options = $("#select_length option");
            var select = $('#select_length');

            for (var i = 0; i < options.length; i++) {
                if (options[i].value === old) {
                    select.val(old).change();
                }
            }

            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_hr').submit()
            });

            $('#btn_reset_form_search_hr').on('click',function (event) {
                resetFormSearchHr();
            });

            $('#hr-absence-list').dataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                'borderCollapse': 'collapse',
                "aaSorting": [
                    [0, 'DESC'],
                ],
            });

        });
    </script>
@endsection