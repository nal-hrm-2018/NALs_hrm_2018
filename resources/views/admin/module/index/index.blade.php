@extends('admin.template')
@section('content')
    <div class="content">
        <h6 class="title-content">Employees Information</h6>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Orders</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>PROJECT ID</th>
                            <th>NAME</th>
                            <th>ROLE</th>
                            <th>START DATE</th>
                            <th>END DATE</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        ?>
                        <tr>
                            <td><a href="pages/examples/invoice.html">OR9842</a></td>
                            <td>Call of Duty IV</td>
                            <td><span class="label label-success">PO</span></td>
                            <td>2018-02-04</td>
                            <td>2018-06-04</td>
                            <td><span class="label label-success">in-progress</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <div class="container-donut-chart">
            <div class="child">
                    <span class="font-size-20">
                        <strong class="font-size-28">100%</strong><img src="{!! asset('admin/templates/images/dist/img/chart1.png') !!}"><br>
                        on last year
                    </span>
                <div id="donut-chart1" class="donut-chart"></div>
                <div>
                        <span class="text-legend">
                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                            Man
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                            Woman
                        </span>
                </div>
            </div>
            <div class="child">
                    <span class="font-size-20">
                        <strong class="font-size-28">150</strong><img src="{!! asset('admin/templates/images/dist/img/chart2.png') !!}"><br>
                        young company
                    </span>
                <div id="donut-chart2" class="donut-chart"></div>
                <div>
                        <span class="text-legend">
                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                            18 - 25
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                            36 - 45
                        </span><br>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                            26 - 35
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #faa951;"></i>
                            46 - More
                        </span>
                </div>
            </div>
            <div class="child">
                    <span class="font-size-20">
                        <strong class="font-size-28">70%</strong><img src="{!! asset('admin/templates/images/dist/img/chart3.png') !!}"><br>
                        experienced
                    </span>
                <div id="donut-chart3" class="donut-chart"></div>
                <div>
                        <span class="text-legend">
                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                            25% PO
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                            25% TEST
                        </span><br>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                            25% DEV
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #faa951;"></i>
                            25% INTER
                        </span>
                </div>
            </div>
            <div class="child">
                    <span class="font-size-20">
                        <strong class="font-size-28">70%</strong><img src="{!! asset('admin/templates/images/dist/img/chart4.png') !!}"><br>
                        experienced
                    </span>
                <div id="donut-chart4" class="donut-chart"></div>
                <div>
                        <span class="text-legend">
                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                            10% PO
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                            30% TEST
                        </span><br>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                            40% DEV
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #faa951;"></i>
                            20% INTER
                        </span>
                </div>
            </div>
            <div class="child">
                    <span class="font-size-20">
                        <strong class="font-size-28">70%</strong><img src="{!! asset('admin/templates/images/dist/img/chart5.png') !!}"><br>
                        experienced
                    </span>
                <div id="donut-chart5" class="donut-chart"></div>
                <div>
                        <span class="text-legend">
                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                            10% PO
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                            30% TEST
                        </span><br>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #e91d24;"></i>
                            40% DEV
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #faa951;"></i>
                            20% INTER
                        </span>
                </div>
            </div>
        </div>
        <div class="">
            <div class="list-column-chart">
                <div id="container" class="column-chart"></div>
                <div id="container1" class="column-chart"></div>
                <div id="container2" class="column-chart"></div>
                <div id="container3" class="column-chart"></div>
                <div id="container4" class="column-chart"></div>
            </div>
            <table id="datatable" class="display-none">
                <thead>
                <tr>
                    <th></th>
                    <th>Alpha</th>
                    <th>Beta</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Jan</th>
                    <td>15</td>
                    <td>18</td>
                </tr>
                <tr>
                    <th>Feb</th>
                    <td>17</td>
                    <td>20</td>
                </tr>
                <tr>
                    <th>Mar</th>
                    <td>19</td>
                    <td>25</td>
                </tr>
                <tr>
                    <th>Apr</th>
                    <td>17</td>
                    <td>17</td>
                </tr>
                <tr>
                    <th>May</th>
                    <td>22</td>
                    <td>30</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
@endsection