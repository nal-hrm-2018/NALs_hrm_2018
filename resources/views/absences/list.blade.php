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
                <small>NAL Solutions</small>
            </h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>--}}
                {{--<li><a href=""> Absance</a></li>--}}
                {{--<li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>--}}
                {{--<li><a href="{{asset('/absences')}}"> Absance</a></li>--}}
                {{--<li><a href="#">List</a></li>--}}
            {{--</ol>--}}
        </section>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default">
                    <a href="{{route('absences.create')}}"><i class="fa fa-user-plus"></i>{{trans('absence.add')}}</a>
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
                            <form  method="get" role="form" id="form_search_employee">
                                <div class="row" style="margin-left: 10px; ">
                                    <div class="form-group">
                                        <label>Chọn năm</label>
                                        <select class="form-control" style="width: 150px;"  name="year" id="year" onchange="myFunction()">
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
                                <input id="number_year" type="hidden" name="number_year"
                                       value="{{ isset($param['number_year'])?$param['number_year']:$startwork_date }}"/>
                            </form>
                            <script>
                                Số ngày phép năm nay   function myFunction() {
                                    var x = document.getElementById("year").value;
                                    console.log(x);
                                    $('#number_year').val(x);
                                    $('#form_search_employee').submit()
                                }
                            </script>
                            
                            <div class=" absence_head" style="display: flex; justify-content: space-evenly; flex-wrap: wrap;">
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày được nghỉ phép:
                                            <span id="soNgayDuocNghiPhep">{{$absences['soNgayDuocNghiPhep']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép năm nay: 
                                            <span id="soNgayNghiPhepCoDinh">{{$absences['soNgayNghiPhepCoDinh']}}</span>
                                        </span><br>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Số ngày phép năm trước: 

                                            <span id="soNgayPhepDu">{{$absences['soNgayPhepDu']}}</span>
                                        </span>
                                    </div><br />
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ không lương:
                                            <span id="soNgayNghiKhongLuong">{{$absences['soNgayNghiKhongLuong']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày đã nghỉ:
                                            <span id="soNgayDaNghi">{{$absences['soNgayDaNghi']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép năm nay: 
                                            <span id="truVaoPhepCoDinh">{{$absences['truVaoPhepCoDinh']}}</span>
                                        </span><br>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Trừ vào phép năm trước: 

                                            <span id="truVaoPhepDu">{{$absences['truVaoPhepDu']}}</span>
                                        </span>

                                    </div><br/>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ trừ lương:
                                            <span id="soNgayNghiTruLuong">{{$absences['soNgayNghiTruLuong']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày còn lại:
                                            <span id="soNgayConLai">{{$absences['soNgayConLai']}}</span>
                                        </p>
                                        <span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép năm nay: 

                                            <span id="phepCoDinh">{{$absences['phepCoDinh']}}</span>
                                        </span>
                                        <span><br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ Phép năm trước:
                                            <span id="phepDu">{{$absences['phepDu']}}</span>
                                        </span>
                                        <span id='hanphep'>
                                            @if($checkMonth == 1 && $absences['phepDu'] > 0)
                                                Đã hết hạn
                                            @endif
                                        </span>
                                        @if($checkMonth == 1 && $absences['phepDu'] > 0)
                                            <script type="text/javascript">
                                                $("#hanphep").addClass("label");
                                                $("#hanphep").addClass("label-danger");
                                            </script>
                                        @endif
                                    </div><br>
                                    <div class="style-box">
                                        <p>
                                            - Số ngày nghỉ chế độ bảo hiểm:
                                            <span id="soNgayNghiBaoHiem">{{$absences['soNgayNghiBaoHiem']}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $idWaiting = \App\Models\AbsenceStatus::where('name', '=',
                                config('settings.status_common.absence.waiting'))->first()->id;
                            $idReject = \App\Models\AbsenceStatus::where('name', '=',
                                config('settings.status_common.absence.rejected'))->first()->id;
                            $idAccept = \App\Models\AbsenceStatus::where('name', '=',
                                config('settings.status_common.absence.accepted'))->first()->id;
                            ?>
                            <table class="table table-bordered table-striped" id="absences-list" style="margin-top: 20px !important;">
                                <thead>
                                    <tr>
                                        <th>Nghỉ từ ngày</th>
                                        <th>Nghỉ đến ngày</th>
                                        <th>Loại nghỉ</th>
                                        <th>Lý do</th>
                                        <th>Ghi chú</th>
                                        <th>Trạng thái</th>
                                        <th>Lý do từ chối</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody class="context-menu" id="listAbsence">
                                    @foreach($listAbsence AS $obj)
                                        <tr>
                                            <td>{{$obj->from_date}}</td>
                                            <td>{{$obj->to_date}}</td>
                                            <td>
                                                @if(trans('absence_po.list_po.type.'.$obj->name_type) == trans('absence_po.list_po.type.salary_date'))
                                                    <span class="label label-primary">
                                                @elseif(trans('absence_po.list_po.type.'.$obj->name_type) == trans('absence_po.list_po.type.non_salary_date'))
                                                    <span class="label label-info">
                                                @elseif(trans('absence_po.list_po.type.'.$obj->name_type) == trans('absence_po.list_po.type.subtract_salary_date'))
                                                    <span class="label label-danger">
                                                @elseif(trans('absence_po.list_po.type.'.$obj->name_type) == trans('absence_po.list_po.type.insurance_date'))
                                                    <span class="label label-default">
                                                @else
                                                    <span>{{trans('absence_po.list_po.type.'.$obj->name_type)}}</span>
                                                @endif
                                            </td>
                                            <td>{{$obj->reason ? $obj->reason : "-"}}</td>
                                            <td>{{$obj->description ? $obj->description : "-"}}</td>

                                            <td class="td-absence-status" id="td-absence-status-{{$obj->id}}">
                                                @if($obj->is_deny == 0)
                                                    @if($obj->absence_status_id == $idWaiting)
                                                        <span class="label label-primary">{{trans('absence.employee_status.absence_waiting')}}</span>
                                                    @elseif($obj->absence_status_id == $idAccept)
                                                        <span class="label label-success">{{trans('absence.employee_status.absence_accept')}}</span>
                                                    @elseif($obj->absence_status_id == $idReject)
                                                        <span class="label label-default">{{trans('absence.employee_status.absence_reject')}}</span>
                                                    @endif
                                                @else
                                                    @if($obj->absence_status_id == $idWaiting)
                                                        <span class="label label-warning">{{trans('absence.employee_status.cancel_waiting')}}</span>
                                                    @elseif($obj->absence_status_id == $idAccept)
                                                        <span class="label label-info">{{trans('absence.employee_status.cancel_accept')}}</span>
                                                    @elseif($obj->absence_status_id == $idReject)
                                                        <span class="label label-danger">{{trans('absence.employee_status.cancel_reject')}}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>

                                                <?php
                                                    $count = 0;
                                                    $listConfirm = selectConfirm($obj->id);
                                                    if(count($listConfirm) > 0){
                                                        foreach ($listConfirm as $objConfirm){
                                                            if(sizeof($listConfirm)>0 && sizeof($listConfirm)<=2){
                                                                echo '<p>PO '.$objConfirm->nameEmployee.': '.$objConfirm->reasonAbsence.'</p>';
                                                            } else if(sizeof($listConfirm)>2){
                                                                echo '<p>PO '.$objConfirm->nameEmployee.': '.$objConfirm->reasonAbsence;
                                                                if($count == 1){
                                                                    echo '<a href="#" class="show-list-confirms"
                                                                id="show-list-confirms-'. $obj->id .'" data-toggle="modal"
                                                                data-target="#show-list-confirms" style="color: red"> [...]</a></p>';
                                                                    break;
                                                                }
                                                                $count++;
                                                            } else {
                                                                echo '-';
                                                            }
                                                        }
                                                    } else{
                                                        echo "-";
                                                    }

                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $i = 0;
                                                    foreach($obj->confirms as $confirm){
                                                        if($confirm->absence_status_id == $idWaiting && $obj->is_deny == 0){
                                                            $i++;
                                                        }
                                                    }
                                                    if($i == sizeof($obj->confirms)) {
                                                        echo '<div style="display: inline" id="div-edit-'. $obj->id .'">
                                                                <button class="btn btn-default btn-edit" id="btn-edit-'. $obj->id .'">
                                                                    <span><i class="fa fa-pencil"></i></span>
                                                                </button></div>';
                                                    } else {
                                                        echo '<div style="display: inline"><button class="btn btn-default disabled">
                                                                    <span><i class="fa fa-pencil"></i></span>
                                                                </button></div>';
                                                    }

                                                    if($obj->is_deny == 0 && $obj->absence_status_id != $idReject){
                                                        echo '<div style="display: inline" id="div-cancel-'. $obj->id .'">
                                                                <button class="btn btn-danger btn-cancel" id="btn-cancel-'. $obj->id .'">
                                                                    <span><i class="fa fa-times"></i></span>
                                                                </button></div>';
                                                    } else {
                                                        echo '<div style="display: inline"><button class="btn btn-danger disabled">
                                                                    <span><i class="fa fa-times"></i></span>
                                                                </button></div>';
                                                    }

                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="show-list-confirms" class="modal fade" role="dialog">
                            <div class="modal-dialog" style="width: 400px">
                                <!-- Modal content-->
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><th>Lý do từ chối: <span id="team_name_modal"></span></th></h4>
                                    </div>
                                    <div class="modal-body">
                                        <table id="member-list" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>PO</th>
                                                <th>Lý do</th>
                                            </tr>
                                            </thead>
                                            <tbody class="context-menu" id="table-list-confirms">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

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

            $('.btn-cancel').click(function () {
                var id_element = $(this).attr('id');
                var id_absence = id_element.split('-')[2];
                var id_td_absence_status = $(this).parent().parent().parent().find('td.td-absence-status').attr('id');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/absences') }}',
                    data: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'id_absence': id_absence,
                        '_method': 'POST',
                        _token: '{{csrf_token()}}',
                    },
                    success: function (msg) {
                        $('#div-cancel-' + id_absence).html('<button class="btn btn-default disabled"><span>' +
                            '<i class="fa fa-times"></i>Hủy</span></button>');
                        $('#div-edit-' + id_absence).html('<button class="btn btn-default disabled"><span>' +
                            '<i class="fa fa-edit"></i>Sửa</span></button>');
                        $('#' + id_td_absence_status).html("<span class=\"label label-warning\">{{trans('absence.employee_status.cancel_waiting')}}</span>");
                    }
                });
            });
            $('.btn-edit').click(function () {
                location.href='/#';
            });
        });
    </script>
    <script type="text/javascript">
        function sendRequestAjax() {
            year = document.getElementById("year").value;
            $.ajax({
                type: "POST",
                url: '{{ url('/absences') }}' + '/' + '{{ $objEmployee->id}}',
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
                    if(msg.aCheckMonth == 1 && msg.aAbsences['phepDu'] > 0){
                        $("#hanphep").addClass("label");
                        $("#hanphep").addClass("label-danger");
                        document.getElementById("hanphep").innerHTML = "Đã hết hạn";
                    }else{
                        if($("#hanphep").hasClass("label")){
                            $("#hanphep").removeClass("label");
                        }
                        if($("#hanphep").hasClass("label-danger")){
                            $("#hanphep").removeClass("label-danger");
                        }
                        document.getElementById("hanphep").innerHTML = "";
                    }

                    document.getElementById("soNgayNghiKhongLuong").innerHTML = msg.aAbsences['soNgayNghiKhongLuong'];
                    document.getElementById("soNgayNghiTruLuong").innerHTML = msg.aAbsences['soNgayNghiTruLuong'];
                    document.getElementById("soNgayNghiBaoHiem").innerHTML = msg.aAbsences['soNgayNghiBaoHiem'];

                    var listAbsence = "";
                    for (var key in msg.aListAbsence) {
                        listAbsence += "<tr>";
                        listAbsence += "<td>"+msg.aListAbsence[key].from_date+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].to_date+"</td>";
                        if( msg.aListAbsence[key].name_type == "{{trans('absence_po.list_po.type.salary_date')}}"){
                            class_type = "label label-primary";
                        }else if( msg.aListAbsence[key].name_type == "{{trans('absence_po.list_po.type.non_salary_date')}}"){
                            class_type = "label label-info";
                        }else if( msg.aListAbsence[key].name_type == "{{trans('absence_po.list_po.type.subtract_salary_date')}}"){
                            class_type = "label label-danger";
                        }else if( msg.aListAbsence[key].name_type == "{{trans('absence_po.list_po.type.insurance_date')}}"){
                            class_type = "label label-default";
                        }
                        listAbsence += "<td><span class=\""+class_type+"\">"+msg.aListAbsence[key].name_type+"</span></td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].reason+"</td>";
                        listAbsence += "<td>"+msg.aListAbsence[key].description+"</td>";
                        var class_status = ""
                        if( msg.aListAbsence[key].name_status == "{{trans('absence_po.list_po.status.waiting')}}"){
                            class_status = "label label-warning";
                        }else if( msg.aListAbsence[key].name_status == "{{trans('absence_po.list_po.status.accepted')}}"){
                            class_status = "label label-success";
                        }else if( msg.aListAbsence[key].name_status == "{{trans('absence_po.list_po.status.rejected')}}"){
                            class_status = "label label-danger";
                        }
                        listAbsence += "<td><span class=\""+class_status+"\">"+msg.aListAbsence[key].name_status+"</span></td>";

                        var count = 0;
                        var reason = "";
                        if(msg.listConfirm.length > 0){
                            for (var key1 in msg.listConfirm){
                                if(msg.listConfirm[key1].absence_id == msg.aListAbsence[key].idAbsence){
                                    count++;
                                }
                            }
                            var count1 = 0;
                            if(count > 0){
                                for (var key1 in msg.listConfirm){
                                    if(msg.listConfirm[key1].absence_id == msg.aListAbsence[key].idAbsence){
                                        if(count > 0 && count <= 2){
                                            reason += "<p>PO "+msg.listConfirm[key1].nameEmployee+": "+msg.listConfirm[key1].reasonAbsence+"</p>";
                                        }else if(count >2){
                                            reason += "<p>PO "+msg.listConfirm[key1].nameEmployee+": "+msg.listConfirm[key1].reasonAbsence;
                                            if(count1 == 1){
                                                reason += "<a href='' onclick='clickConfirm("+msg.aListAbsence[key].idAbsence+")' class='show-list-confirms'"+
                                                "id='show-list-confirms-"+ msg.aListAbsence[key].idAbsence +"'  data-toggle='modal'"+
                                                "data-target='#show-list-confirms' style='color: red'> [...]</a></p>";
                                                    break;
                                            }
                                            count1 ++;
                                        }else{
                                            reason = "-";
                                        }
                                    }
                                }
                            }else{
                                reason = "-";
                            }
                        }else{
                            reason = "-";
                        }

                        listAbsence += "<td>"+reason+"</td>";

                        listAbsence +="<td>";
                        if(msg.aListAbsence[key].name_status == "{{trans('absence_po.list_po.status.waiting')}}"){
                            listAbsence +="<button type=\"button\" class=\"btn btn-default\">"+
                                            "<a href=\"\"><i class=\"fa fa-edit\"></i>Sửa</a></button>"+
                                            "<button type=\"button\" class=\"btn btn-default\">"+
                                            "<a href=\"\"><i class=\"fa fa-times\"></i>Hủy</a></button>";
                        }else{
                            listAbsence +="<button type=\"button\" class=\"btn btn-default disabled\">"+
                                            "<a href=\"javascript:void(0)\"><i class=\"fa fa-edit\"></i>Sửa</a></button>"+
                                            "<button type=\"button\" class=\"btn btn-default disabled\">"+
                                            "<a href=\"javascript:void(0)\"><i class=\"fa fa-times\"></i>Hủy</a></button>";
                        }
                        listAbsence +="</td>";
                        listAbsence +="</tr>";
                    }
                    document.getElementById("listAbsence").innerHTML = listAbsence;
                }
            });
        }

    </script>
    <script>
        $('.show-list-confirms').click(function () {
            var id = $(this).attr('id');
            var id_absence = id.slice(19);
            <?php
                $listConfirm = selectConfirmByID();
            ?>
            var listReason = "";
            document.getElementById("table-list-confirms").innerHTML = "";
            @foreach($listConfirm as $obj)
                if("{{$obj->absence_id}}" == id_absence){
                    listReason += "<tr><td>{{$obj->nameEmployee}}</td>"
                                    + "<td>{{$obj->reasonAbsence}}</td></tr>";
                }
            @endforeach
            document.getElementById("table-list-confirms").innerHTML = listReason;
        });
    </script>
    <script>
        function clickConfirm(id) {
            var id_absence = id;
            <?php
                $listConfirm = selectConfirmByID();
            ?>
            var listReason = "";
            document.getElementById("table-list-confirms").innerHTML = "";
            @foreach($listConfirm as $obj)
                if("{{$obj->absence_id}}" == id_absence){
                    listReason += "<tr><td>{{$obj->nameEmployee}}</td>"
                                    + "<td>{{$obj->reasonAbsence}}</td></tr>";
                }
            @endforeach
            document.getElementById("table-list-confirms").innerHTML = listReason;
        };
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
        .absence_head p{
            font-weight: bold;
            font-size: 15px;
        }
        .fa {
            width: 20px;
        }
        .style-box {
            margin: 10px;
            padding: 10px;
            border-top: 3px solid #d2d6de;
            border-radius: 5px;
            border-right: 3px solid #d2d6de;
            min-width: 250px;
            color: white;
            background: cornflowerblue;
        }
    </style>
@endsection