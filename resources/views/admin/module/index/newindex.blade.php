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


<script type="text/javascript" src="{!! asset('admin/templates/js/my_script/dashboard.js') !!}"> </script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
@endsection