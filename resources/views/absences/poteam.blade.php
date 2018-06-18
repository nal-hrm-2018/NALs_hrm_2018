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

        <section class="content-header">
            <div style="float:right; background-color: #ECF0F5; height: 50px;">
                <ol class="breadcrumb" style="background-color: #ECF0F5">
                    <button class="btn btn-default">EXPORT</button>
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
@endsection