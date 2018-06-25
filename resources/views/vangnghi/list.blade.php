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
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row" style="margin-left: 10px; ">
                                <div class="form-group">
                                    <label>Chọn năm</label>
                                    <select class="form-control" style="width: 30%;"  name="year" id="year" onchange="sendRequestAjax()">
                                        @if($startwork_date == $endwork_date)
                                            <option value="{{$startwork_date}}">{{$startwork_date}}</option>
                                        @endif
                                        @if($startwork_date < $endwork_date)
                                            @for($i=$endwork_date; $i>=$startwork_date; $i--)
                                                <option value="{{$i}}" >{{$i}}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row absence_head">
                                <div class="col-md-6">
                                    <div>
                                        <p>
                                            - Số ngày được nghỉ phép: 
                                            <span id="soNgayDuocNghiPhep">{{$absences['soNgayDuocNghiPhep']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép cố định: 
                                            <span id="soNgayNghiPhepCoDinh">{{$absences['soNgayNghiPhepCoDinh']}}</span>
                                        </span>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép dư: 
                                            <span id="soNgayPhepDu">{{$absences['soNgayPhepDu']}}</span>
                                        </span>
                                    </div>
                                    <div>
                                        <p>
                                            - Số ngày đã nghỉ: 
                                            <span id="soNgayDaNghi">{{$absences['soNgayDaNghi']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép cố định: 
                                            <span id="truVaoPhepCoDinh">{{$absences['truVaoPhepCoDinh']}}</span>
                                        </span>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép dư: 
                                            <span id="truVaoPhepDu">{{$absences['truVaoPhepDu']}}</span>
                                        </span>
                                        
                                    </div>
                                    <div>
                                        <p>
                                            - Số ngày còn lại:
                                            <span id="soNgayConLai">{{$absences['soNgayConLai']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép cố định: 
                                            <span id="phepCoDinh">{{$absences['phepCoDinh']}}</span>
                                        </span>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép dư:
                                            <span id="phepDu">{{$absences['phepDu']}}</span>
                                        </span>
                                        @if($checkMonth == 1 && $absences['phepDu'] > 0)
                                            <strong class="label label-danger">
                                                Đã hết hạn
                                            </strong>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <p>
                                            - Số ngày nghỉ trừ lương: 
                                            <span id="soNgayNghiTruLuong">{{$absences['soNgayNghiTruLuong']}}</span>
                                        </p>
                                    </div>
                                    <div class="row">
                                        <p>
                                            - Số ngày nghỉ chế độ bảo hiểm: 
                                            <span id="soNgayNghiBaoHiem">{{$absences['soNgayNghiBaoHiem']}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped" id="absences-list">
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
                                <tbody class="context-menu" id="listAbsence">
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
                                                    }else{
                                                        echo "-";
                                                    }
                                                    
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script>
        $(document).ready(function () {
            $('#absences-list').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                'borderCollapse':'collapse'
            });
        });
    </script>
    <script type="text/javascript">
        function sendRequestAjax() {
            year = document.getElementById("year").value;
            $.ajax({
                type: "POST",
                url: '{{ url('/absences') }}' + '/' + {{ $objEmployee->id}},
                data: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'year': year,
                    '_method': 'POST',
                    _token: '{{csrf_token()}}',
                },
                success: function (msg) {
                    document.getElementById("soNgayDuocNghiPhep").innerHTML = msg.aAbsences['soNgayDuocNghiPhep'];
                    document.getElementById("soNgayNghiPhepCoDinh").innerHTML = msg.aAbsences['soNgayNghiPhepCoDinh'];
                    document.getElementById("soNgayPhepDu").innerHTML = msg.aAbsences['soNgayPhepDu'];

                    document.getElementById("soNgayDaNghi").innerHTML = msg.aAbsences['soNgayDaNghi'];
                    document.getElementById("truVaoPhepCoDinh").innerHTML = msg.aAbsences['truVaoPhepCoDinh'];
                    document.getElementById("truVaoPhepDu").innerHTML = msg.aAbsences['truVaoPhepDu'];
                    
                    document.getElementById("soNgayConLai").innerHTML = msg.aAbsences['soNgayConLai'];
                    document.getElementById("phepCoDinh").innerHTML = msg.aAbsences['phepCoDinh'];
                    document.getElementById("phepDu").innerHTML = msg.aAbsences['phepDu'];

                    document.getElementById("soNgayNghiTruLuong").innerHTML = msg.aAbsences['soNgayNghiTruLuong'];
                    document.getElementById("soNgayNghiBaoHiem").innerHTML = msg.aAbsences['soNgayNghiBaoHiem'];

                    var listAbsence = "";
                    for (var key in msg.aListAbsence) {
                        listAbsence += "<tr>";
                        listAbsence += "<td>"+msg.aListAbsence[key].from_date+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].to_date+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].name_type+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].reason+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].description+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].name_status+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].confirm+"</td>";
                        listAbsence +="</tr>";
                    }                    
                    document.getElementById("listAbsence").innerHTML = listAbsence;
                }
            });
        } 

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
    <style type="text/css">
        .absence_head .col-md-6 div p{
            font-weight: bold;
            font-size: 15px;
        }
    </style>
@endsection