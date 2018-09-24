@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('leftbar.nav.edit.notification')}}
                <small>NAL Solutions</small>
            </h1>
        </section>
        <style type="text/css">
            .form-horizontal .form-group {
                margin-right: 0px;
            }
        </style>
        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-body">

                    <div id="msg">
                    </div>
                    <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
                    <div class="row">
                        {{--<form action="" method="post" class="form-horizontal"--}}
                              {{--onSubmit="return confirmAction()">--}}
                        {{Form::model($notification,array('url' => ['/notification', $notification->id], 'method'=>isset($notification["id"])?'PUT':'POST', 'id' => 'form_edit_notification',))}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>{{trans('notification.title')}}<strong style="color: red">(*)</strong></label>
                                        <input type="text" class="form-control" placeholder="" name="title" id="title" value="<?php echo isset($notification->title)?$notification->title:' ' ?>" />
                                        <label id="lb_error_title" style="color: red; ">{{$errors->first('title')}}</label>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('notification.content')}}<strong style="color: red">(*)</strong></label>
                                        <textarea id="content" rows="4" name="content" value="<?php echo isset($notification->content)?$notification->content:' ' ?>" placeholder="Nhập Nội Dung"><?php echo isset($notification->content)?$notification->content:' ' ?></textarea>
                                        <label id="lb_error_content" style="color: red; ">{{$errors->first('content')}}</label>
                                    </div>
                                    {{-- @php
                                    <div class="form-group">
                                        <label>{{trans('notification.notification_id')}}<strong style="color: red">(*)</strong></label>
                                        <select class="form-control select2" style="width: 100%;"  name="notification_type_id" id="notification_type_id">
                                            <option value="" >---Chọn---</option>
                                            <?php
                                            foreach ($notificationType as $val) {
                                            ?>
                                            <option value="{{$val->id}}" <?php if($val->id == $notification->notification_type_id){ echo 'selected';}?>>{{$val->name}}</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label id="lb_error_type_id" style="color: red; ">{{$errors->first('notification_type_id')}}</label>
                                    </div>
                                    @endphp --}}
                                    <div class="form-group" style="margin-bottom:0;">
                                            <label for="date">{{trans('notification.end_date')}}<strong style="color: red">(*)</strong></label>
                                        </div>
                                        <div class="form-group input-group">
                                            
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($notification->end_date)?date('Y-m-d', strtotime($notification->end_date)):' ' ?>">
                                        </div>
                                        <label id="lb_error_date" style="color: red; ">{{$errors->first('date')}}</label> 
                                </div>
                                <!-- /.form-group -->
                                <div class="col-md-3"></div>

                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6" style="display: inline;">
                                    <div style="float: right;">
                                        <button type="button" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                                            RESET
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: inline;">
                                    <div style="float: right;">
                                        <button type="submit" class="btn btn-info">
                                            SAVE
                                        </button>
                                    </div>
                                </div>
                            </div>
                         {{ Form::close() }}
                        {{--</form>--}}

                    </div>
                    <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <script type="text/javascript"
                    src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script>
                $(function () {
                    $("#btn_reset_form_employee").bind("click", function () {
                        if(confirmAction("{{trans('common.confirm_reset')}}"))
                            location.reload();
                    });
                });
            </script>

            <script type="text/javascript">
                $(function () {
                    $('.form_datetime').datetimepicker({
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        forceParse: 0,
                        showMeridian: 1});
                });
            </script>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>


@endsection