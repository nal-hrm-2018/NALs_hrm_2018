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
                Project Detail
                <small>Nal solution</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/projects')}}"> Projects</a></li>
                <li><a href="#">Detail</a></li>
            </ol>
        </section>

        <!-- Main content -->
      <div id="msg"></div>
        <section class="content">
           <div class="row">
              <div class="box">
                 <!-- /.box-header -->
                <div class="col-xs-12">
                    <h2>Project ID: <strong>{{$project->id}}</strong></h2>
                    <p>Project Name:
                        <strong>{{$project->name}}</strong>
                    </p>
                    <p>Income:
                        <strong>{{number_format($project->income). ' VNĐ'}}</strong>
                    </p>

                    <p>Estimate Cost:
                        <strong>
                            <?php
                                $estimate_cost=0;
                                foreach ($member as $process){
                                    $salary = 10000000;
                                    $first_date = strtotime($process->start_date);
                                    $second_date = strtotime($process->end_date);
                                    $datediff = abs($first_date - $second_date);
                                    $time = floor($datediff / (60*60*24));
                                    $cs =$process->man_power;
                                    $estimate_cost_mem = $salary*$cs*$time;
                                    $estimate_cost += $estimate_cost_mem;
                                }   echo number_format($estimate_cost). ' VNĐ';
                            ?>

                        </strong>
                    </p>

                    <p>Real Cost:
                        <strong>{{number_format($project->real_cost). ' VNĐ'}}</strong>
                    </p>

                    <p>Status:
                        @if($project->status_name == "kick off")
                            <span class="label label-primary">Kick Off</span>
                        @elseif($project->status_name == "pending")
                            <span class="label label-danger">Pending</span>
                        @elseif($project->status_name == "in-progress")
                            <span class="label label-warning">In-Progress</span>
                        @elseif($project->status_name == "releasing")
                            <span class="label label-info">Releasing</span>
                        @elseif($project->status_name == "complete")
                            <span class="label label-success">Complete</span>
                        @elseif($project->status_name == "planning")
                            <span class="label label-success">Planning</span>
                        @endif
                    </p>

                    <p>Estimate Date:
                        <strong>

                            <strong>
                                @if($project->estimate_start_date)
                                    {{date('d/m/Y', strtotime($project->estimate_start_date))}}
                                @else
                                    <span class='label label-default' style="font-size: small">Unknown</span>
                                @endif
                                -
                                @if($project->estimate_end_date)
                                    {{date('d/m/Y', strtotime($project->estimate_end_date))}}
                                @else
                                    <span class='label label-default' style="font-size: small">Unknown</span>
                                @endif
                            </strong>
                        </strong>
                    </p>

                    <p>Real Date:
                        <strong>{{date('d/m/Y', strtotime($project->start_date))}}
                            -
                            @if($project->end_date)
                               {{date('d/m/Y', strtotime($project->end_date))}}
                            @else
                              <span class='label label-default' style="font-size: small">Unknown</span>
                            @endif
                        </strong>
                    </p>
                    <br>
                </div>

                    <div class="box-body">
                        {!! Form::open(
                        ['url' =>route('projects.show',$project->id),
                        'method'=>'GET',
                        'id'=>'form_view_project',
                         ]) !!}
                        <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                               value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                        {!! Form::close() !!}
                        <div>
                            <div class="dataTables_length" id="project-list_length" style="float:right">
                                <label>{{trans('pagination.show.number_record_per_page')}}
                                    {!! Form::select(
                                        'select_length',
                                        getArraySelectOption() ,
                                        null ,
                                        [
                                        'id'=>'select_length',
                                        'class' => 'form-control input-sm',
                                        'aria-controls'=>"project-list"
                                        ]
                                        )
                                     !!}
                                </label>
                            </div>
                        </div>

                        <script>
                            (function () {
                                $('#select_length').change(function () {
                                    $("#number_record_per_page").val($(this).val());
                                    $('#form_view_project').submit()
                                });
                            })();

                        </script>
                        <table id="member-list" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">CV</th>
                                <th class="text-center">Performance</th>
                            </tr>
                            </thead>
                            <tbody class="context-menu">
                            {{--{{var_dump($project)}}--}}
                            @foreach($member as $employee)

                                <tr class="project-menu" id="employee-id-{{$employee->employee_id}}"
                                    data-employee-id="{{$employee->employee_id}}">
                                    <td>
                                        <p class="fix-center-employee">
                                            @if($employee->is_employee==1)
                                            <a href="{!! asset('employee/'.$employee->employee_id)!!}">
                                                {{ isset($employee->name)? $employee->name: "-" }}
                                            </a>
                                            @else
                                                <a href="{!! asset('vendors/'.$employee->employee_id)!!}">
                                                    {{ isset($employee->name)? $employee->name: "-" }}
                                                </a>
                                            @endif
                                        </p>
                                    </td>
                                    <td >
                                        <p class="fix-center-employee">
                                            <?php
                                                if($employee->role_name == "Dev"){
                                                    echo "<span class='label label-success'>Dev</span>";
                                                } if($employee->role_name == "BA"){
                                                    echo "<span class='label label-info'>BA</span>";
                                                } if($employee->role_name == "ScrumMaster"){
                                                    echo "<span class='label label-warning'>ScrumMaster</span>";
                                                } if($employee->role_name == "PO"){
                                                    echo "<span class='label label-primary'>PO</span>";
                                                }
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="fix-center-employee">
                                            @if($employee->is_employee==1)
                                                <a href="{!! asset('employee/'.$employee->employee_id)!!}">
                                                    {{ isset($employee->email)? $employee->email: "-" }}
                                                </a>
                                            @else
                                                <a href="{!! asset('vendors/'.$employee->employee_id)!!}">
                                                    {{ isset($employee->email)? $employee->email: "-" }}
                                                </a>
                                            @endif
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <p class="fix-center-employee">
                                            {{ isset($employee->mobile)? $employee->mobile: "-" }}
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <p class="fix-center-employee">
                                            {{isset($employee->start_date)? date('d/m/Y',strtotime($employee->start_date)): "-"}}
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <p class="fix-center-employee">
                                            {{isset($employee->end_date)? date('d/m/Y',strtotime($employee->end_date)): "-"}}
                                        </p>
                                    </td>

                                    <td style="text-align: center;width: 50px;">
                                        <button type="button" class="btn btn-default cv-button">
                                            <a href="javascript:void(0)"><i class="fa fa-cloud-download"></i> CV</a>
                                        </button>
                                    </td>

                                    <td style="text-align: center;width: 160px;">
                                        <button type="button" class="btn btn-default input-button">
                                            <a href="javascript:void(0)"><i class="	fa fa-plus-square"></i> Input</a>
                                        </button>

                                        <button type="button" class="btn btn-default view-button">
                                            <a href="javascript:void(0)"><i class="fa fa-search-plus"></i> View</a>
                                        </button>
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                        @if($member->hasPages())
                            <div class="col-sm-5">
                                <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                                    {{getInformationDataTable($member)}}
                                </div>
                            </div>
                            <div class="col-sm-7">
                                {{  $member->appends($param)->render('vendor.pagination.custom') }}
                            </div>
                        @endif
                    </div>
                        <!-- /.box-body -->
                </div>
                    <!-- /.box -->
            </div>  
                <!-- /.col -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script>
        $(document).ready(function (){
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "extract-date-pre": function (value) {
                    var date = $(value).text();
                    date = date.split('/');
                    return Date.parse(date[1] + '/' + date[0] + '/' + date[2])
                },
                "extract-date-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "extract-date-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
            $('#member-list').dataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                'borderCollapse': 'collapse',
                "aaSorting": [
                    [4, 'desc'],[5, 'desc']
                ],
                columnDefs: [{
                    type: 'extract-date',
                    targets: [4,5]
                }
                ]
            });
        });
        $(document).ready(function () {
            var old = '{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:'' }}';
            var options = $("#select_length option");
            var select = $('#select_length');
            for(var i = 0 ; i< options.length ; i++){
                if(options[i].value=== old){
                    select.val(old).change();
                }
            }
        });
    </script>
@endsection