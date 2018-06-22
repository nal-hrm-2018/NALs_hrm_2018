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
                Absence List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/absences')}}"> Absance</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default">
                    <a href=""><i class="fa fa-user-plus"></i>Đăng ký vắng nghỉ</a>
                </button>

            </div>
            
        </section>
        

        <div id="msg">
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                       value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>      
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row absence_head">
                                <div class="col-md-6">
                                    <div>
                                        <p>- Số ngày được nghỉ phép: {{$absences['1']}}</p>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép cố định: {{$absences['2']}}</span>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép dư: {{$absences['3']}}</span>
                                    </div>
                                    <div>
                                        <p>- Số ngày đã nghỉ: {{$absences['4']}}</p>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép cố định: {{$absences['5']}}</span>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép dư: {{$absences['6']}}</span>
                                        
                                    </div>
                                    <div>
                                        <p>- Số ngày còn lại: {{$absences['9']}}</p>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép cố định: {{$absences['7']}}</span>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép dư: {{$absences['8']}}</span>
                                        @if($checkMonth == 1 && $absences['8'] > 0)
                                            <strong class="label label-danger">
                                                Đã hết hạn
                                            </strong>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <p>- Số ngày nghỉ trừ lương: {{$absences['10']}}</p>
                                    </div>
                                    <div class="row">
                                        <p>- Số ngày nghỉ chế độ bảo hiểm: {{$absences['11']}}</p>
                                    </div>
                                </div>
                            </div>
                            <script>
                                (function () {
                                    $('#select_length').change(function () {
                                        $("#number_record_per_page").val($(this).val());
                                        $('#form_search_employee').submit()
                                    });
                                })();

                            </script>
                            <table id="employee-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Nghỉ từ ngày</th>
                                    <th>Nghỉ đến ngày</th>
                                    <th>Loại nghỉ</th>
                                    <th>Lý do</th>
                                    <th>Ghi chú</th>
                                    <th>Trạng thái</th>
                                    <th>Lý do từ chối</th>
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                    @foreach($listAbsence AS $obj)
                                        <tr>
                                            <td>{{$obj->from_date}}</td>
                                            <td>{{$obj->to_date}}</td>
                                            <td>{{trans('absence_po.list_po.type.'.$obj->name_type)}}</td>
                                            <td>{{$obj->reason}}</td>
                                            <td>{{$obj->description}}</td>
                                            <td>{{trans('absence_po.list_po.status.'.$obj->name_status)}}</td>
                                            <td>

                                                <?php 
                                                    if($obj->name_status == "rejected"){
                                                        echo selectConfirm($obj->id)->reason;
                                                    }
                                                    
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script>
        (function () {
            $('#select_length').change(function () {
                $("#number_record_per_page").val($(this).val());
                $('#form_search_process').submit()
            });
        })();
    </script>
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
                if (confirm(message_confirm('delete', 'employee', elementRemove, nameRemove))) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/employee') }}' + '/' + elementRemove,
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
                'borderCollapse':'collapse'
            });
//            $('#employee-list').css(borderCollapse, collapse);
        });
    </script>
    {{--<script type="text/javascript">
        document.getElementById("employee-list").style.borderCollapse = "collapse";
    </script>--}}
    <script type="text/javascript">
        $(function () {
            $("#btn_reset_employee").on("click", function () {
                $("#nameEmployee").val('');
                $("#employeeId").val('');
                $("#emailEmployee").val('');
                $("#role_employee").val('').change();
                $("#team_employee").val('').change();
                $("#status").val('').change();
            });
        });
    </script>
    <script>
        $('#btn-search').click(function (e) {
            $('#form_search_employee').trigger("reset");
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
    {{--<script type="text/javascript">
        $(document).ready(function (){
            var ctx = document.getElementById('my_canvas').getContext('2d');
            var al = 0;
            var start = 4.72;
            var cw = ctx.canvas.width;
            var ch = ctx.canvas.height;
            var diff;
            function runTime() {
                diff = ((al / 100) * Math.PI*0.2*10).toFixed(2);
                ctx.clearRect(0, 0, cw, ch);
                ctx.lineWidth = 3;
                ctx.fillStyle = '#09F';
                ctx.strokeStyle = "#09F";
                ctx.textAlign = 'center';
//                ctx.fillText(al+'%', cw*.5, ch*.5+2, cw);
                ctx.beginPath();
                ctx.arc(10, 10, 5, start, diff/1+start, false);
                ctx.stroke();
                if (al >= 100) {
                    clearTimeout(sim);
                    sim = null;
                    al=0;
                    $("#contain-canvas").css("visibility","hidden")
                    // Add scripting here that will run when progress completes
                }
                al++;
            }
            var sim = null;
            $("#click-here").click(function () {
                $("i.fa fa-vcard").css("visibility","hidden")
                $("#contain-canvas").css("visibility","visible")
                sim = setInterval(runTime, 15 );
            });
        });

    </script>--}}
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
    <style type="text/css">
        .absence_head .col-md-6 div p{
            font-weight: bold;
            font-size: 15px;
        }
    </style>
@endsection