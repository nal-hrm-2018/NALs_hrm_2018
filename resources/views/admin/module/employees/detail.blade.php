@extends('admin.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee Profile
        </h1>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
        </ol>


    </section>
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#basic" data-toggle="tab">Basic</a></li>
                <li><a href="#project" data-toggle="tab">Project</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="basic">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="{!! asset('admin/templates/images/dist/img/user2-160x160.jpg') !!}" alt="User profile picture">

                                    <h3 class="profile-username text-center">Nina Mcintire</h3>

                                    <p class="text-muted text-center">PO</p>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="box box-primary">
                                <div>
                                    <p>Name: <strong>Tran Cong Phuc</strong></p>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="sel1">Select Chart:</label>
                                            <select class="form-control" id="sel1">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <i class="fa fa-bar-chart-o"></i>

                                                <h3 class="box-title">Resource Chart - 2018</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div id="bar-chart" style="height: 235px;"></div>
                                            </div>
                                            <!-- /.box-body-->
                                        </div>
                                        <!-- /.box -->

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.post -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="project">
                    <div>
                        <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal">SEARCH</button>

                        <!-- Modal -->
                        <div id="myModal" class="modal fade">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Search form</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Employee ID</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Name</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Team</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Email</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Role</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">Status</button>
                                                    </div>
                                                    <input type="text" class="form-control">
                                                    wrapper      </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer center">
                                        <button type="button" class="btn btn-default"><span class="fa fa-refresh"></span> RESET</button>
                                        <button type="button" class="btn btn-primary"><span class="fa fa-search"></span> SEARCH</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- The project -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Project</th>
                                <th>Role</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr><tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-pane -->


                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </section>
    <!-- Main content -->
    <section class="content">


        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- jQuery 3 -->
<script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script type="text/javascript">
    $(function () {
        var bar_data = {
            data : [['Jan', 10], ['Feb', 8], ['Mar', 4], ['Apr', 13], ['May', 17], ['Jun', 9], ['Aug', 9], ['Sept', 2], ['Oct', 4], ['Nov', 5], ['Dec', 9]],
            color: '#3c8dbc'
        }
        $.plot('#bar-chart', [bar_data], {
            grid  : {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor  : '#f3f3f3'
            },
            series: {
                bars: {
                    show    : true,
                    barWidth: 0.75,
                    align   : 'center'
                }
            },
            xaxis : {
                mode      : 'categories',
                tickLength: 0
            }
        })
    })
</script>

@endsection