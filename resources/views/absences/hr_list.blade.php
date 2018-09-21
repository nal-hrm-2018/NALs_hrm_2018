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
                {{trans('leftbar.nav.absence_management')}}
                <small>NAL Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a></li>--}}
                {{--<li><a href="{{route('absences-hr')}}"> {{trans('common.path.absences')}}</a></li>--}}
                {{--<li><a href="#">{{trans('common.title_header.absence_list')}}</a></li>--}}
            {{--</ol>--}}

        {{-- </section>

        <section class="content-header">
            <div style="float:right; background-color: #ECF0F5; height: 50px;">
                <ol class="breadcrumb" style="background-color: #ECF0F5">
                    @include("absences._export_hr_absence")
                </ol>
            </div>
        </section> --}}
        {{--table data project--}}
        <div id="msg">
            <br><br><br>
        </div>
        <section class="content">
            <div class="row fullwidth">
                <div class="col-xs-12">
                        @if(Auth::user()->hasRoleHR())
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#import" id="btn-import">
                            <a ><i class="glyphicon glyphicon-import"></i> {{trans('common.button.import')}}</a>
                        </button>
                        <div id="import" class="modal fade" role="dialog">
                                <div class="modal-dialog" style="width: 50%">
                                    <form method="post" action="{{ asset('absence/postFile')}}" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">NHẬP DANH SÁCH NGHỈ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="input-group margin">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-info width-100">{{trans('employee.select_csv_file')}}</button>
                                                        </div>
                                                        <label class="file-upload">
                                                            <input type="file" id="myfile" name="myFile" class="form-control" style="display: none;">
                                                            <i class="fa fa-cloud-upload"></i>
                                                            <span id="file_name">Choose file</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer center">
                                                <button type="submit" id="i_submit" class="btn btn-primary"><span
                                                            class="glyphicon glyphicon-upload"></span>
                                                    {{trans('common.button.import')}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $('#myfile').bind('change', function(e) {
                                            if(this.files[0].size > 5242880){
                                                alert("{{trans('employee.valid5mb')}}");
                                                document.getElementById('myfile').value = "";
                                            }
                                            var value = $('#myfile')[0].files[0];
                                            if(value != null){
                                                $('#file_name').text(value.name);
                                                $('#i_submit').removeClass('disabled');
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        @endif
                    <div class="box">
                        <!-- /.box-header -->
                        <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
                        <div class="box-body">
                            <div>
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#demo" id="clickCollapse">
                                    <span class="fa fa-search"></span>&nbsp;Search
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
                                {{--<div class="form-row">--}}
                                {{--@include('absences._form_filter_hr')--}}
                                {{--</div>--}}
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-12" style="width: 100% ; margin-bottom: 1em"></div>
                            @php
                                // $list_absences = getJsonObjectAbsenceHrList($employees,$absenceService);
                                $list_absences = getAbsenceHrList($employees,$absenceService);
                                view()->share('list_absences',$list_absences);
                            @endphp
                            {!! Form::open(
                                [
                                'url' =>route('export-absences-hr'),
                                'method'=>'post',
                                'id'=>'form_list_absences',
                                'role'=>'form'
                                ]) !!}
                            @include('absences._list_absences_hr',[$list_absences])
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
    <script type="text/javascript">
        $(document).ready(function () {
            var language = $('#language_active').attr('lang');
            lang.init("absence", language, function () {
                $('#export_absence_hr').on('click', function (event) {
                    if(confirmExportHR(lang.getString('confirm_export_absence_hr'))){
                        $('#form_list_absences').submit();
                    }else{
                        return false;
                    }
                });

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

                $('#btn_reset_form_search_hr').on('click', function (event) {
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
        });
    </script>
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script type="text/javascript">
        $(function () {
            $('tr.employee-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                var eId = $(this).data('employee-id');
                $('ul.contextMenu[data-employee-id="' + eId + '"]')
                    .show()
                    .css({top: event.pageY - 160, left: event.pageX - 250, 'z-index': 300});

            });
            $(document).click(function () {
                if ($('ul.contextMenu:hover').length === 0) {
                    $('ul.contextMenu').fadeOut("fast");
                }
            });
        });

    </script>
@endsection