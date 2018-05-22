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
                Vendor List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Vendor</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default">
                    @if($listError == null && $colError == null)
                        <a href="{{ asset('vendors/importVendor?urlFile='.$urlFile)}}"><i class="fa fa-user-plus"></i> IMPORT</a>
                    @endif
                    @if($listError != null || $colError != null)
                        <a href="{{ asset('vendors')}}"><i class="fa fa-user-plus"></i> BACK</a>
                    @endif
                </button>
            </div>
            <br />
        </section>
        
        @if($listError != null)
            <div class="content" style="height:200px; overflow: auto;">
                <?php
                    echo '<div>
                        <ul class=\'error_msg1\'>
                            <li><h4>Sorry. CSV file you are error. Please correct the errors below in the CSV file. Then upload the file again.</h4></li>
                        '
                        .$listError.'</ul>
                    </div>';
                ?>
                <div class="row note" style="margin-left: 1px; margin-right: 1px;">
                    <h4>NOTE:</h4>
                    <div class="col-xs-4">
                        <h5>There are the following roles:</h5>
                        <ul>
                            @foreach($dataRoles as $dataRoles)
                                <li>
                                    {{ $dataRoles["name"] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-xs-4">
                        <h5>There are the following employee type:</h5>
                        <ul>
                            @foreach($dataEmployeeTypes as $dataEmployeeTypes)
                                <li>
                                    {{ $dataEmployeeTypes["name"] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <?php
            if (strlen($colError) > 0) {
                echo '<div class="content" style="height:500px; overflow: auto;">
                    <ul class=\'error_msg1\'>
                        <li><h4>Sorry. CSV file you are error. Please correct the errors below in the CSV file. Then upload the file again.</h4></li>
                    '
                    .$colError.'</ul>
                </div>';
            }
        ?>
        @if($colError == null)
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body" style=" overflow: auto">
                            <table id="employee-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    @for($j=0; $j < $num; $j++)
                                    <th>{{ $dataVendor[$j] }}</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody class="context-menu">
                                    @for($k=1; $k < $row; $k++)
                                        <tr>
                                            <td>{{ $k }}</td>
                                            @for($i=$k*$num; $i < $num*($k+1); $i++)
                                                
                                                <td>{{ $dataVendor[$i] }}</td>
                                            @endfor

                                        </tr>
                                    @endfor
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
        @endif
    </div>
@endsection