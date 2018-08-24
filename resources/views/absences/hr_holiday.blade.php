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
                <small>NAL Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>--}}
                {{--<li><a href="{{route('absences-hr')}}"> {{trans('common.path.absences')}}</a></li>--}}
                {{--<li><a href="#">{{trans('common.title_header.absence_list_holiday')}}</a></li>--}}
            {{--</ol>--}}

        </section>
        {{--<section class="content-header">--}}
            {{--<div style="float:right; background-color: #ECF0F5; height: 50px;">--}}
                {{--<ol class="breadcrumb" style="background-color: #ECF0F5">--}}
                {{--@include("absences._export_hr_absence")--}}
            {{--</ol>--}}
            {{--</div>--}}
        {{--</section>--}}
        <script>
            function confirmHoliday() {
                var name = $('#name').val();
                return confirm('{{trans("holiday.add-question")}}' +name+ '{{trans("holiday.add-question-end")}}');
            }
        </script>
        
        <form action="{{asset('holiday')}}" method="post" class="form-horizontal col-md-12"
              onSubmit="return confirmHoliday()"
              style="margin: 15px; padding: 20px;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{--<input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>--}}
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-4 add-holiday-input">
                    <div class="form-group">
                        <label>{{trans('holiday.name')}}<strong class="text-danger">(*)</strong></label>
                        <input type="text" class="form-control" placeholder="{{trans('holiday.name')}}" name="name" id="name" value="{{ old('name') }}"/>
                        <label id="lb_error_name" class="text-danger">{{$errors->first('name')}}</label>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4 add-holiday-input">
                    <div class="form-group">
                        <label>{{trans('holiday.date')}}<strong class="text-danger">(*)</strong></label>
                        <div class="input-group date" style="width: 100%;">
                            <input type="date" class="form-control" id="holiday_date"
                                   name="holiday_date"
                                   value="{{ old('holiday_date') }}"
                                   style="width: 100%;">
                        </div>
                        <label id="lb_error_holiday_date" class="text-danger">{{$errors->first('holiday_date')}}</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-4 add-holiday-input">
                    <div class="form-group"">
                        <label>{{trans('holiday.type')}}<strong class="text-danger">(*)</strong></label><br>
                        <select class="form-control select2" class="text-danger"  name="holiday_type_id" id="holiday_type_id">
                            <option value="" >{{trans('holiday.select')}}</option>
                        <?php
                            foreach ($holiday_type as $val) {
                            echo '<option value='.$val['id'].'>' . $val['name'] . '</option>';
                            }
                        ?>
                        </select>
                        <label id="lb_error_holiday_type_id" class="text-danger">{{$errors->first('holiday_type_id')}}</label>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4 add-holiday-input">
                    <div class="form-group">
                        <label>{{trans('holiday.description')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('holiday.answer')}}"{!! old('ghi_chu') !!}  name="ghi_chu" id="ghi_chu">
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="display: flex; justify-content: center; margin-bottom: 20px;">
                <button type="submit" class="btn btn-info col-md-5 center-item" style="width: fit-content;">{{trans('holiday.add')}}</button>
            </div>
        </form>

        {{--table data project--}}
        <div id="msg"></div>
        <section class="content">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            @include('absences._list_holiday_hr',[$list_holiday_default,$list_holiday, $year_now, $min_year, $max_year])
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

    <!-- Attachment Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document" style="width: 50%;">
            <div class="modal-content">
                <div class="modal-body" id="attachment-body-content">
                    <form id="edit-form" class="form-horizontal" method="POST" action="{{asset('holiday')}}">
                        @csrf
                        <input name="_method" value="PUT" type="hidden">
                        <div class="card text-white bg-dark mb-0" style="margin: 20px;">
                            <div class="card-header">
                                <h2 class="m-0">{{trans('holiday.edit')}}</h2>
                            </div>
                            <div class="card-body">
                                <!-- id -->
                                <div class="form-group">
                                    <input type="hidden" name="modal-input-id" class="form-control" id="modal-input-id" readonly required autofocus>
                                </div>
                                <!-- /id -->
                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">{{trans('holiday.name')}}</label>
                                    <input type="text" name="modal-input-name" class="form-control" id="modal-input-name" required autofocus>
                                </div>
                                <!-- /name -->
                                <!-- year -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">{{trans('holiday.year')}}</label>
                                    <input type="text" name="modal-input-year" class="form-control" id="modal-input-year" required autofocus>
                                </div>
                                <!-- /year -->
                                <!-- month -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">{{trans('holiday.month')}}</label>
                                    <input type="text" name="modal-input-month" class="form-control" id="modal-input-month" required autofocus>
                                </div>
                                <!-- /month -->
                                <!-- day -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">{{trans('holiday.day')}}</label>
                                    <input type="text" name="modal-input-day" class="form-control" id="modal-input-day" required autofocus>
                                </div>
                                <!-- /day -->
                                <!-- type -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">{{trans('holiday.type')}}</label>
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
                                    <label class="col-form-label" for="modal-input-description">{{trans('holiday.description')}}</label>
                                    <input type="text" name="modal-input-description" class="form-control" id="modal-input-description">
                                </div>
                                <!-- /description -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit(trans('holiday.update'),
                            ['class'=> 'btn btn-info form-control submit-modal']) !!}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('holiday.close')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .submit-modal {
            width: fit-content;
        }
    </style>
    <!-- /Attachment Modal -->
    <script>
        $(".holiday-delete").on("submit", function(){
            return confirm("Are you sure you want to delete this holiday?");
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
            $('#edit-modal').on("show.bs.modal", function() {
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
    <style type="text/css">
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection