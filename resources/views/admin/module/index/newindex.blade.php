@if(Auth::user()->hasRole('BO'))
                <section>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{trans('employee.chart.information')}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.common')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-350">
                                            <div class="child">
                                                <div id="donut-chart1" class="donut-chart"></div>
                                                <div class="width-310">
                                        <span class="text-legend width-150">
                                            <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                            {{trans('employee.type.official')}}
                                        </span>
                                                    <span class="text-legend width-150">
                                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                        {{trans('employee.type.probationary')}}
                                        </span><br>
                                                    <span class="text-legend width-150">
                                            <i class="fas fa-circle" style="color: #faa951;"></i>
                                                        {{trans('employee.type.internship')}}
                                        </span>
                                                    <span class="text-legend width-150">
                                            <i class="fas fa-circle" style="color: #00a65a;"></i>
                                                        {{trans('employee.type.part-time')}}
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger height-400">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.chart.contract')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-350">
                                            <div class="child">
                                                <div id="donut-chart2" class="donut-chart"></div>
                                                <div class="width-150">
                                            <span class="text-legend">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                {{trans('employee.status.active')}}
                                            </span><br>
                                                    <span class="text-legend">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                                        {{trans('employee.status.leaved')}}
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-danger height-400">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{trans('employee.employee')}}{{trans('employee.this_month')}}</h3>
                                            <div class="box-tools pull-right">
                                            </div>
                                        </div>
                                        <div class="box-body height-350">
                                            <div class="child">
                                                <div id="donut-chart3" class="donut-chart"></div>
                                                <div  class="width-310">
                                                    @if($new_PHP >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #53cbf2;"></i>
                                                PHP
                                            </span>
                                                    @endif
                                                    @if($new_DOTNET >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #abe02a;"></i>
                                               DOTNET
                                            </span>
                                                    @endif
                                                    @if($new_iOS >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #00a65a;"></i>
                                                IOS
                                            </span>
                                                    @endif
                                                    @if($new_Android >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #faa951;"></i>
                                                Android
                                            </span>
                                                    @endif
                                                    @if($new_Tester >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #e91d24;"></i>
                                                Tester
                                            </span>
                                                    @endif
                                                    @if($new_others >0)
                                                        <span class="text-legend width-100">
                                                <i class="fas fa-circle" style="color: #999;"></i>
                                               Others
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/data.js"></script>
                <script>
                    Highcharts.chart('donut-chart1', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
                            align: 'center',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 150,
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: false
                            }
                        },
                        series: [{
                            name: 'Values',
                            colorByPoint: true,
                            data: [{
                                name: '{{trans('employee.type.official')}}',
                                y: {{$sumFullTime}},
                                color:'#53cbf2'
                            }, {
                                name: '{{trans('employee.type.probationary')}}',
                                y: {{$sumProbationary}},
                                color:'#abe02a'
                            }, {
                                name: '{{trans('employee.type.internship')}}',
                                y: {{$sumInternship}},
                                color:'#faa951'
                            }, {
                                name: ' {{trans('employee.type.part-time')}}',
                                y: {{$sumPartTime}},
                                color:'#00a65a',
                            }  ]
                        }]
                    });
                    Highcharts.chart('donut-chart2', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
                            align: 'center',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 150,
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: false
                            }
                        },
                        series: [{
                            name: 'Values',
                            colorByPoint: true,
                            data: [{
                                name: '{{trans('employee.status.active')}}',
                                y: {{$sum}}-{{$sum_leaved}},
                                color:'#53cbf2'
                            }, {
                                name: '{{trans('employee.status.leaved')}}',
                                y: {{$sum_leaved}},
                                color:'#abe02a'
                            }
                            ]
                        }]
                    });
                    Highcharts.chart('donut-chart3', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text: '<span style="font-size: 45px; font-weight: bold;">{{$sum_new}}</span><br><span style="font-size: 20px;">{{trans('employee.employee')}}</span>',
                            align: 'center',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 150,
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: false
                            }
                        },
                        series: [{
                            name: 'Values',
                            colorByPoint: true,
                            data: [{
                                name: 'PHP',
                                y: {{$new_PHP}},
                                color:'#53cbf2'
                            }, {
                                name: 'DOTNET',
                                y: {{$new_DOTNET}},
                                color:'#abe02a'
                            }, {
                                name: 'IOS',
                                y: {{$new_iOS}},
                                color:'#00a65a'
                            }, {
                                name: 'Android',
                                y: {{$new_Android}},
                                color:'#faa951',
                            }
                                , {
                                    name: 'Tester',
                                    y: {{$new_Tester}},
                                    color:'#e91d24',
                                }
                                , {
                                    name: 'Others',
                                    y: {{$new_others}},
                                    color:'#999'
                                }
                            ]
                        }]
                    });
                </script>
            @endif
            {{--end code by Dung--}}
@extends('admin.template')
@section('content')
    <div class="content">
        <h6 class="title-content">Employees Information</h6>
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