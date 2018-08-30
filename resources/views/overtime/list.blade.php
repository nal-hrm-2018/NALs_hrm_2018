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
		<section class="content-header">
            <h1>
                My overtime
                <small>NAL Solutions</small>
            </h1>
        </section>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" style="color: blue;">
                    <i class="glyphicon glyphicon-plus"></i>&nbsp;Add OT
                </button>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 50%;">
                        <div class="modal-content">
                            <form id="form-add-overtime" action="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add overtime</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group col-md-12">
                                        <label for="exdate">Date</label>
                                        <input type="date" class="form-control" id="exdate">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exfromtime">From time</label>
                                        <input type="time" name="fromtime" id="exfromtime" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="extotime">To time</label>
                                        <input type="time" name="totime" id="extotime" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exnumbertime">Number time</label>
                                        <input type="text" class="form-control" id="exnumbertime"> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exreason">Reason</label>
                                        <input type="text" name="reason" id="exreason" class="form-control">
                                     </div>
                                    <div class="form-group col-md-12">
                                        <label for="extypeday"></label>
                                        <select id="extypeday" class="form-control">
                                            <option selected>Select date type</option>
                                            <option>Normal day</option>
                                            <option>Day off</option>
                                            <option>Holiday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info btn-confirm-add-overtime">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>From time</th>
                                        <th>To time</th>
                                        <th>Number time</th>
                                        <th>Date type</th>
                                        <th>Status</th>
                                        <th>Verify number</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>02/08/2018</td>
                                        <td>thích</td>
                                        <td>17h30</td>
                                        <td>20h00</td>
                                        <td><span class="label label-success">2.5 hours<span></td>
                                        <td><span class="label" style="background: #76a4ef;">Normal day</span></td>
                                        <td><span class="label label-danger">Reject</span></td>
                                        <td><span class="label label-success">1.5 hours</span></td>
                                        <td>
                                            <button type="button" class="btn btn-default width-90" data-toggle="modal" data-target="#myModal1" style="color: blue;">
                                                <i class="glyphicon glyphicon-edit"></i>&nbsp;Edit
                                            </button>
                                            <button type="button" class="btn btn-default width-90">
                                                <a href=""><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</a>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" rowspan="3"></td>
                                        <td rowspan="3">Total</td>
                                        <td>Normal day</td>
                                        <td><span class="label label-success">6 hours</span></td>
                                    </tr>
                                    <tr>
                                        <td>Day off</td>
                                        <td><span class="label label-success">6 hours</span></td>
                                    </tr>
                                    <tr>
                                        <td>Holiday</td>
                                        <td><span class="label label-success">6 hours</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document" style="width: 50%;">
                                    <div class="modal-content">
                                        <form>
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group col-md-12">
                                                    <label for="exdate">Date</label>
                                                    <input type="date" class="form-control" id="exdate">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="exfromtime">From time</label>
                                                    <input type="time" name="fromtime" id="exfromtime" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="extotime">To time</label>
                                                    <input type="time" name="totime" id="extotime" class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exnumbertime">Number time</label>
                                                    <input type="text" class="form-control" id="exnumbertime"> 
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exreason">Reason</label>
                                                    <input type="text" name="reason" id="exreason" class="form-control">
                                                 </div>
                                                <div class="form-group col-md-12">
                                                    <label for="extypeday"></label>
                                                    <select id="extypeday" class="form-control">
                                                        <option selected>Select date type</option>
                                                        <option>Normal day</option>
                                                        <option>Day off</option>
                                                        <option>Holiday</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
    <style type="text/css">
        .table tbody tr td {
            vertical-align: middle;
        }
        .table thead tr th {
            vertical-align: middle;
        }
        .width-90 {
            width: 90px;
        }
    </style>
@endsection