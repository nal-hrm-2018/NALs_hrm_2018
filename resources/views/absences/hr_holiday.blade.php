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
        <form action="{{asset('holiday')}}" method="post" class="form-horizontal"
              onSubmit="return confirmAction()">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{--<input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>--}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên ngày nghỉ<strong style="color: red">(*)</strong></label>
                    <input type="text" class="form-control" placeholder="Tên ngày nghỉ" name="name" id="name" value="{{ old('name') }}"/>
                    <label id="lb_error_name" style="color: red; ">{{$errors->first('name')}}</label>
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
                               value="{{ old('holiday_date') }}">
                    </div>
                    <label id="lb_error_holiday_date" style="color: red; ">{{$errors->first('holiday_date')}}</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Loại nghỉ phép<strong style="color: red">(*)</strong></label>
                <select class="form-control select2" style="width: 100%;"  name="holiday_type_id" id="holiday_type_id">
                    <option value="" >---Chọn---</option>
                <?php
                    foreach ($holiday_type as $val) {
                    echo '<option value='.$val['id'].'>' . $val['name'] . '</option>';
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
                            </div>
                            @include('absences._list_holiday_hr',[$list_holiday])
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
    <!-- Attachment Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="attachment-body-content">
                    <form id="edit-form" class="form-horizontal" method="POST" action="{{asset('holiday')}}">
                        @csrf
                        <input name="_method" value="PUT" type="hidden">
                        <div class="card text-white bg-dark mb-0">
                            <div class="card-header">
                                <h2 class="m-0">Edit</h2>
                            </div>
                            <div class="card-body">
                                <!-- id -->
                                <div class="form-group">
                                    <input type="hidden" name="modal-input-id" class="form-control" id="modal-input-id" readonly required autofocus>
                                </div>
                                <!-- /id -->
                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Tên ngày nghi</label>
                                    <input type="text" name="modal-input-name" class="form-control" id="modal-input-name" required autofocus>
                                </div>
                                <!-- /name -->
                                <!-- year -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Năm</label>
                                    <input type="text" name="modal-input-year" class="form-control" id="modal-input-year" required autofocus>
                                </div>
                                <!-- /year -->
                                <!-- month -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Tháng</label>
                                    <input type="text" name="modal-input-month" class="form-control" id="modal-input-month" required autofocus>
                                </div>
                                <!-- /month -->
                                <!-- day -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Ngày</label>
                                    <input type="text" name="modal-input-day" class="form-control" id="modal-input-day" required autofocus>
                                </div>
                                <!-- /day -->
                                <!-- type -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Loại nghỉ</label>
                                    {{--<input type="text" name="modal-input-type" class="form-control" id="modal-input-type" required autofocus>--}}
                                    <select class="form-control select2" style="width: 100%;"  name="modal-input-type" id="modal-input-type">
                                        <?php
                                        foreach ($holiday_type as $val) {
                                            echo '<option value='.$val['id'].'>' . $val['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- /type -->
                                <!-- description -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Ghi chú</label>
                                    <input type="text" name="modal-input-description" class="form-control" id="modal-input-description" required>
                                </div>
                                <!-- /description -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target='#edit-modal'>Done</button>--}}
                            {!! Form::submit('Update',['class'=> 'btn btn-primary form-control']) !!}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Attachment Modal -->
    <script>
        $(".holiday-delete").on("submit", function(){
            return confirm("Are you sure?");
        });
        $(document).ready(function() {
            /**
             * for showing edit item popup
             */

            $(document).on('click', "#edit-item", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

                var options = {
                    'backdrop': 'static'
                };
                $('#edit-modal').modal(options)
            })

            // on modal show
            $('#edit-modal').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");

                // get the data
                var id = row.children('.id-holiday').text();
                var name = row.children(".name-holiday").text();
                var year = row.children(".year-holiday").text();
                var month = row.children(".month-holiday").text();
                var day = row.children(".day-holiday").text();
                var type = row.children(".type-holiday-id").text();
                var description = row.children(".description-holiday").text();

                // fill the data in the input fields
                $("#modal-input-id").val(id);
                $("#modal-input-name").val(name);
                $("#modal-input-year").val(year);
                $("#modal-input-month").val(month);
                $("#modal-input-day").val(day);
                $("#modal-input-type").val(type);
                $("#modal-input-description").val(description);
            })



            // on modal hide
            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })
        })
    </script>
@endsection