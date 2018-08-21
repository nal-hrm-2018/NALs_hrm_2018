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
                            35% PO
                        </span>
                    <span class="text-legend">
                            <i class="fas fa-circle" style="color: #abe02a;"></i>
                            15% TEST
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
        </div>
    </div>

<script src="https://code.highcharts.com/highcharts.js"></script>
@endsection