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
                {{trans('common.title_header.vendor_list')}}
                <small>{{trans('common.title_header.nal_solution')}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}
                    </a></li>
                <li><a href="{{route('vendors.index')}}">{{trans('common.path.vendors')}}</a></li>
                <li class="active"><a href="javascript:void(0)">{{trans('common.path.list')}}</a></li>
            </ol>
        </section>

        <section class="content-header">
            <div>
                <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal" id="btn-search">
                    {{trans('common.button.search')}}
                </button>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                    {!! Form::open(
                        ['url' =>route('vendors.index'),
                        'method'=>'GET',
                        'id'=>'form_search_vendor',
                        'role'=>'form',
                    ]) !!}
                    <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                            </div>
                            @include('vendors._form_search_vendor')
                            <div class="modal-footer center">
                                <button id="btn_reset_vendor" type="button" class="btn btn-default"><span
                                            class="fa fa-refresh"></span>
                                    {{trans('common.button.reset')}}
                                </button>
                                <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                            class="fa fa-search"></span>
                                    {{trans('common.button.search')}}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <ol class="breadcrumb">
                <button type="button" class="btn btn-default">
                    <a href="{{ route('vendors.create')}}"><i
                                class="fa fa-user-plus"></i> {{trans('common.button.add')}}</a>
                </button>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#import" id="btn-import">
                    <a><i class="fa fa-users"></i> IMPORT</a>
                </button>
                <div id="import" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <form method="post" action="{{ asset('vendors/postFile')}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">IMPORT VENDOR</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="input-group margin">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn width-100">Select file csv</button>
                                            </div>
                                            <input type="file" id="myfile" name="myFile" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer center">
                                    <button type="submit" id="i_submit" class="btn btn-primary"><span
                                                class="glyphicon glyphicon-upload"></span>
                                        IMPORT
                                    </button>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $('#myfile').bind('change', function() {
                                if(this.files[0].size > 5242880){
                                    alert("The selected file is too large. Maximum size is 5MB.");
                                    document.getElementById('myfile').value = "";
                                }
                                var value = $('#myfile')[0].files[0];
                                if(value != null){
                                    $('#i_submit').removeClass('disabled');
                                }
                            });
                        </script>
                    </div>
                </div>
                <button type="button" class="btn btn-default" onclick="return confirmAction('{{trans('vendor.msg_content.msg_download_template')}}')">
                    <a href="{{ asset('/download-template-vendor')}}"><i class="fa fa-cloud-download"></i> TEMPLATE</a>
                </button>

                @include("vendors._export_vendor")
            </ol>
        </section>

        <!-- Main content -->

        <div id="msg"></div>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                @include('vendors._list_vendor')
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>


    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script type="text/javascript">
        $(function () {

            $('tr.employee-menu').on('contextmenu', function (event) {
                event.preventDefault();
                $('ul.contextMenu').fadeOut("fast");
                var eId = $(this).data('employee-id');
                $('ul.contextMenu[data-employee-id="' + eId + '"')
                    .show()
                    .css({top: event.pageY - 170, left: event.pageX - 250, 'z-index': 300});

            });
            $(document).click(function () {
                if ($('ul.contextMenu:hover').length === 0) {
                    $('ul.contextMenu').fadeOut("fast");
                }
            });
        });

    </script>

    <script type="text/javascript">
        $(function () {
            $('.btn-employee-remove').click(function () {
                var elementRemove = $(this).data('employee-id');
                var nameRemove = $(this).data('employee-name');
                console.log(elementRemove);
                if (confirm(message_confirm('delete', 'vendor', elementRemove, nameRemove))) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/vendors') }}' + '/' + elementRemove,
                        data: {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            "id": elementRemove,
                            '_method': 'DELETE',
                            _token: '{{csrf_token()}}',
                        },
                        success: function (msg) {
                            alert("Remove " + msg.status);
                            var fade = "employee-id-" + msg.id;
                            $('ul.contextMenu[data-employee-id="' + msg.id + '"').hide()
                            var fadeElement = $('#' + fade);
                            console.log(fade);
                            fadeElement.fadeOut("fast");
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#employee-list').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
            var options = $("#select_length option");
            var select = $('#select_length');
            for(var i = 0 ; i< options.length ; i++){
                if(options[i].value=== old){
                    select.val(old).change();
                }
            }
        });
        $(function () {
            $("#btn_reset_vendor").on("click", function () {
                $("#employeeId").val('');
                $("#employeeName").val('');
                $("#employeeCompany").val('');
                $("#employeeEmail").val('');
                $("#role").val('').change()
                $("#status").val('').change()
            });
        });
    </script>
    <script>
        $('#btn-search').click(function () {
            $('#form_search_vendor').trigger("reset");
        });
    </script>
    <script>
        $('#btn-import').click(function (e) {
            var value = $('#myfile')[0].files[0];
            if(value == null){
                $('#i_submit').addClass('disabled');
            }
        });

    </script>
    <style>
        #contain-canvas{
            visibility:hidden;
        }
        span#contain-canvas{
            position: relative;
            left: 27px;
            margin-left: -20px;
        }
    </style>

@endsection