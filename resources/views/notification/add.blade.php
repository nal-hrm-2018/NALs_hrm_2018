@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('leftbar.nav.add.notification')}}
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
                    {{--<SCRIPT LANGUAGE="JavaScript">--}}
                        {{--function confirmAction() {--}}
                            {{--var name = $('#name').val();--}}
                            {{--var id = $('#id_employee').val();--}}
                            {{--return confirm(message_confirm('create', 'notification', id, name));--}}
                        {{--}--}}
                    {{--</SCRIPT>--}}
                    <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
                    <div class="row">
                        <form action="{{asset('notification')}}" method="post" class="form-horizontal" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>{{trans('notification.title')}}<strong style="color: red">(*)</strong></label>
                                        <input type="text" class="form-control" placeholder="" name="title" id="title" value="{{ old('title') }}" />
                                        <label id="lb_error_title" style="color: red; ">{{$errors->first('title')}}</label>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('notification.content')}}<strong style="color: red">(*)</strong></label>
                                        <textarea id="content" name="content" value="" placeholder="">{{ old('content') }}</textarea>
                                        <label id="lb_error_content" style="color: red; ">{{$errors->first('content')}}</label>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('notification.notification_id')}}<strong style="color: red">(*)</strong></label>
                                        <select class="form-control select2" value="{{ old('notification_type_id') }}" style="width: 100%;"  name="notification_type_id" id="notification_type_id">
                                            <option value="">---{{trans('employee.drop_box.placeholder-default')}}---</option>
                                            <?php
                                            foreach ($dataTeam as $val) {
                                            $selected = "";
                                            if ($val["id"] == old('notification_type_id')) {
                                                $selected = "selected";
                                            }
                                            ?>
                                            <option value="{{ $val->id }}" <?php echo $selected; ?>>{{$val->name}}</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label id="lb_error_type_id" style="color: red; ">{{$errors->first('notification_type_id')}}</label>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                                <div class="col-md-3"></div>

                            </div>
                            <div class="row">
                                <div class="col-md-6" style="display: inline;">
                                    <div style="float: right;">
                                        <button onclick="return confirm_reset();" type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                                            {{ trans('common.button.reset')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: inline;">
                                    <div style="float: right;">
                                        <button onclick="return confirm_add();" type="submit" class="btn btn-info">
                                            {{ trans('common.button.add')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--{{ Form::close() }}--}}
                        </form>

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
                        if(confirmAction('{{trans('common.reset')}}'))
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
    <script>
        function confirm_add(){
            return confirm(message_confirm('{{trans('common.action.add')}}','{{trans('notification.notification')}}',''));
        }
    </script>

@endsection