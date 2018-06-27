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
                {{trans('common.title_header.absence_detail')}}
                <small>{{trans('common.title_header.nal_solution')}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}
                    </a></li>
                <li><a href="{{route('vendors.index')}}">{{trans('common.path.absence')}}</a></li>
                <li class="active"><a href="javascript:void(0)">{{trans('absence_po.list_po.path')}}</a></li>
            </ol>
        </section>
        <?php
        $exportId = null; $exportName = null; $exportEmail = null;  $exportStartDate = null;$exportNotePoTeam = null;
        $exportEndDate = null;  $exportType = null; $exportReason = null; $exportNote = null; $exportAbsenceStatus = null;
        $exportPage = null;
        $requestArrays[] = $_GET;
        foreach ($requestArrays as $key => $value){
            if (!empty($value['name'])){
                $exportName = $value['name'];
            }
            if (!empty($value['email'])){
                $exportEmail = $value['email'];
            }
            if (!empty($value['type'])){
                $exportType = $value['type'];
            }
            if (!empty($value['start_date'])){
                $exportStartDate = $value['start_date'];
            }
            if (!empty($value['end_date'])){
                $exportEndDate = $value['end_date'];
            }
            if (!empty($value['absence_status'])){
                $exportAbsenceStatus = $value['absence_status'];
            }
            if (!empty($value['number_record_per_page'])){
                $exportPage = $value['number_record_per_page'];
            }
        }
        ?>


        <SCRIPT LANGUAGE="JavaScript">
            function confirmExport(msg) {
                $check = confirm(msg);
                if($check == true){
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
                        $("i.fa fa-vcard").css("visibility","hidden")
                        $("#contain-canvas").css("visibility","visible")
                        sim = setInterval(runTime, 15 );

                    });
                }
                return $check;
            }
        </SCRIPT>
        <section class="content-header">
            <div style="float:right; background-color: #ECF0F5; height: 50px;">
                <ol class="breadcrumb" style="background-color: #ECF0F5">

                    <button  type="button" class="btn btn-default export-employee" id="click-here" onclick="return confirmExport('{{trans('absence_po.list_po.msg.confirm_export')}}')">
                    <a id="export" href="{{route('absence-po-team').'?'.'number_record_per_page='.$exportPage.'&name='.$exportName.'&email='.$exportEmail.'&type='.$exportType.'&start_date='.$exportStartDate.'&end_date='.$exportEndDate.'&absence_status='.$exportAbsenceStatus}}">
                        <i class="fa fa-cloud-download"></i>
                        <span id="contain-canvas" style="">
                                <canvas id="my_canvas" width="16" height="16" style=""></canvas>
                            </span>{{trans('common.button.export')}}</a>
                    </button>
                </ol>
            </div>
        </section>

        <div id="msg"></div>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                @include('absences.poteam_list')
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
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