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
                Employee List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/employee')}}"> Employee</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>

    </div>
@endsection