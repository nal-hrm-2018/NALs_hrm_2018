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
                {{trans('common.title_header.absence_list_holiday')}}
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>
                <li><a href="{{route('absences-hr')}}"> {{trans('common.path.absences')}}</a></li>
                <li><a href="#">{{trans('common.title_header.absence_list_holiday')}}</a></li>
            </ol>

        </section>
        {{--<section class="content-header">--}}
            {{--<div style="float:right; background-color: #ECF0F5; height: 50px;">--}}
                {{--<ol class="breadcrumb" style="background-color: #ECF0F5">--}}
                {{--@include("absences._export_hr_absence")--}}
            {{--</ol>--}}
            {{--</div>--}}
        {{--</section>--}}
        <form action="{{asset('absences/holiday')}}" method="post" class="form-horizontal"
              onSubmit="return confirmAction()">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{--<input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>--}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên ngày nghỉ<strong style="color: red">(*)</strong></label>
                    <input type="text" class="form-control" placeholder="Tên ngày nghỉ" name="name" id="name" value=""/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ngày<strong style="color: red">(*)</strong></label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <input type="date" class="form-control pull-right" id="holiday_date"
                               name="holiday_date"
                               value="">
                    </div>
                    <label id="lb_error_holiday_date" style="color: red; ">{{$errors->first('holiday_date')}}</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Loại nghỉ phép<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;"  name="holiday_type_id" id="holiday_type_id">
                    <option value="" >---Chọn---</option>
                <?php
                    $Holiday_type = ['Nghỉ lễ', 'Nghỉ abc', 'Nghỉ xyz'];
                    foreach ($Holiday_type as $val) {
                    echo '<option value="">' . $val . '</option>';
                    }
                ?>
                </select>
                <label id="lb_error_holiday_type_id" style="color: red; ">{{$errors->first('holiday_type_id')}}</label>
            </div>
            <div class="form-group col-md-6">
                <label>Ghi chú</label>
                <input type="text" class="form-control" placeholder="Câu trả lời của bạn"{!! old('ghi_chu') !!}  name="ghi_chu" id="ghi_chu">
                <!-- /.input group -->
            </div>
            <div class="row">
                {{--<div class="col-md-3" style="margin-left: 100px;">--}}
                    {{--<button type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>--}}
                        {{--RESET--}}
                    {{--</button>--}}
                {{--</div>--}}
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
            </div>
        </form>
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
                                {{--{!! Form::open(--}}
                                {{--[--}}
                                {{--'url' =>route('absences-hr'),--}}
                                {{--'method'=>'get',--}}
                                {{--'id'=>'form_search_hr',--}}
                                {{--'role'=>'form'--}}
                                {{--]) !!}--}}

                                {{--@include("absences._form_search_hr")--}}
                                {{--<div class="col-md-12" style="width: 100% ; margin-bottom: 2em"></div>--}}
                                {{--<div class="form-row">--}}
                                    {{--@include('absences._form_filter_hr')--}}
                                {{--</div>--}}
                                {{--{!! Form::close() !!}--}}
                            </div>
                            {{--<div class="col-md-12" style="width: 100% ; margin-bottom: 1em"></div>--}}
                            @php

                            @endphp

                            {{--{!! Form::open(--}}
                                {{--[--}}
                                {{--'url' =>route('export-absences-hr'),--}}
                                {{--'method'=>'post',--}}
                                {{--'id'=>'form_list_absences',--}}
                                {{--'role'=>'form'--}}
                                {{--]) !!}--}}
                            @include('absences._list_holiday_hr',[$list_holiday])
                            {{--@include('absences._list_holiday_hr')--}}
                            {!! Form::close() !!}
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
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--var language = $('#language_active').attr('lang');--}}
            {{--lang.init("absence", language, function () {--}}
                {{--$('#export_absence_hr').on('click', function (event) {--}}
                    {{--if(confirmExportHR(lang.getString('confirm_export_absence_hr'))){--}}
                        {{--$('#form_list_absences').submit();--}}
                    {{--}else{--}}
                        {{--return false;--}}
                    {{--}--}}
                {{--});--}}

                {{--var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';--}}
                {{--var options = $("#select_length option");--}}
                {{--var select = $('#select_length');--}}

                {{--for (var i = 0; i < options.length; i++) {--}}
                    {{--if (options[i].value === old) {--}}
                        {{--select.val(old).change();--}}
                    {{--}--}}
                {{--}--}}

                {{--$('#select_length').change(function () {--}}
                    {{--$("#number_record_per_page").val($(this).val());--}}
                    {{--$('#form_search_hr').submit()--}}
                {{--});--}}

                {{--$('#btn_reset_form_search_hr').on('click', function (event) {--}}
                    {{--resetFormSearchHr();--}}
                {{--});--}}

                {{--//-----------}}
                {{--$('tr.employee-menu').on('contextmenu', function (event) {--}}
                    {{--event.preventDefault();--}}
                    {{--$('ul.contextMenu').fadeOut("fast");--}}
                    {{--var eId = $(this).data('employee-id');--}}
                    {{--$('ul.contextMenu[data-employee-id="' + eId + '"')--}}
                        {{--.show()--}}
                        {{--.css({top: event.pageY - 180, left: event.pageX - 250, 'z-index': 300});--}}

                {{--});--}}
                {{--$(document).click(function () {--}}
                    {{--if ($('ul.contextMenu:hover').length === 0) {--}}
                        {{--$('ul.contextMenu').fadeOut("fast");--}}
                    {{--}--}}
                {{--});--}}
                {{--//-----------------}}
                {{--$('#hr-absence-list').dataTable({--}}
                    {{--'paging': false,--}}
                    {{--'lengthChange': false,--}}
                    {{--'searching': false,--}}
                    {{--'ordering': true,--}}
                    {{--'info': false,--}}
                    {{--'autoWidth': false,--}}
                    {{--'borderCollapse': 'collapse',--}}
                    {{--"aaSorting": [--}}
                        {{--[0, 'DESC'],--}}
                    {{--],--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
@endsection