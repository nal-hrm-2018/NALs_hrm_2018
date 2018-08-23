@extends('admin.template')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if($role=='PO')
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Project</h3>

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
                                    <th>START DATE</th>
                                    <th>ESTIMATE END DATE</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{$project->id}}</td>
                                        <td>{{$project['name']}}</td>
                                        <td>{{$project['start_date']->format('d-m-Y')}}</td>
                                        @if($project['estimate_end_date']!=null)
                                            <td>{{$project['estimate_end_date']->format('d-m-Y')}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if($project['status']['name']=='kick off')
                                            <td><span class="label label-primary">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='pending')
                                            <td><span class="label label-success">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='in-progress')
                                            <td><span class="label label-info">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='releasing')
                                            <td><span class="label label-warning">{{$project['status']['name']}}</span></td>
                                        @elseif($project['status']['name']=='planning')
                                            <td><span class="label label-danger">{{$project['status']['name']}}</span></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                {{--<div class="box-footer clearfix">--}}
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Project</a>--}}
                {{--</div>--}}
                <!-- /.box-footer -->
                </div>
            </section>
            <section class="">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Processes</h3>

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
                                    <th>ESTIMATE END DATE</th>
                                    <th>STATUS</th>
                                    <th>MEMBER</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                ?>
                                @foreach($processes as $process)
                                    <tr>
                                        <td>{{$process['project_id']}}</td>
                                        <td>{{$process['project']['name']}}</td>
                                        @if($process['role']['name']=='Dev')
                                            <td><span class="label label-success">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='ACCOUNTANT')
                                            <td><span class="label label-danger">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='SM')
                                            <td><span class="label label-info">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='PO')
                                            <td><span class="label label-primary">{{$process['role']['name']}}</span></td>
                                        @elseif($process['role']['name']=='HR')
                                            <td><span class="label label-warnings">{{$process['role']['name']}}</span></td>
                                        @endif
                                        <td>{{$process['project']['start_date']->format('d-m-Y')}}</td>
                                        @if($process['project']['estimate_end_date']!=null)
                                            <td>{{$process['project']['estimate_end_date']->format('d-m-Y')}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if($process['project']['status']['name']=='kick off')
                                            <td><span class="label label-primary">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='pending')
                                            <td><span class="label label-success">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='in-progress')
                                            <td><span class="label label-info">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='releasing')
                                            <td><span class="label label-warning">{{$process['project']['status']['name']}}</span></td>
                                        @elseif($process['project']['status']['name']=='planning')
                                            <td><span class="label label-danger">{{$process['project']['status']['name']}}</span></td>
                                        @endif
                                        <td>
                                            @foreach($projects_emp[$i] as $member)
                                                @if($member->role->name =='Dev')
                                                    <span class="label label-success">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='ACCOUNTANT')
                                                    <span class="label label-danger">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='SM')
                                                    <span class="label label-info">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='PO')
                                                    <span class="label label-primary">{{$member->employee->name}}</span>
                                                @elseif($member->role->name =='HR')
                                                    <span class="label label-warning">{{$member->employee->name}}</span>
                                                @else
                                                    <span class="label label-default">{{$member->employee->name}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                {{--<div class="box-footer clearfix">--}}
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Processes</a>--}}
                {{--</div>--}}
                <!-- /.box-footer -->
                </div>
            </section>
        @endif
        <!-- code from trinhhunganh -->
        @if(Auth::user()->hasRole('Dev'))
            <section>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Project Developer</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">{{trans('dashboard.stt')}}</th>
                            <th>{{trans('dashboard.name.project')}}</th>
                            <th>{{trans('dashboard.position')}}</th>
                            <th>{{trans('dashboard.start_date')}}</th>
                            <th>{{trans('dashboard.end_date')}}</th>
                            <th>{{trans('dashboard.po_name')}}</th>
                            <th>{{trans('dashboard.status')}}</th>
                        </tr>
                        @foreach($objmEmployee->processes as $key => $process)
                            @php
                                $idPO=\App\Models\Role::where('name','PO')->first();
                                $project=\App\Models\Project::find($process->project_id);
                                $status=\App\Models\Status::find($project->status)->first();
                                $idEmpPo=\App\Models\Process::select('employee_id')
                                                            ->where('project_id',$process->project_id)
                                                            ->where('role_id',$idPO->id)
                                                            ->first();
                                if(isset($idEmpPo->employee_id)){
                                    $name_po=\App\Models\Employee::find($idEmpPo->employee_id);
                                }
                            @endphp
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$project->name}}</td>
                                <td>{{$objmEmployee->role->name}}</td>
                                <td><span class="">{{$process->start_date->format('d-m-Y')}}</span></td>
                                <td><span class="">{{$process->end_date->format('d-m-Y')}}</span></td>
                                <td><span class="">{{isset($name_po)?$name_po->name:'-'}}</span></td>
                                <td>
                                @if($status->name=='kick off')
                                    <span class="label label-primary">{{$status->name}}</span>
                                @elseif($status->name=='pending')
                                    <span class="label label-success">{{$status->name}}</span>
                                @elseif($status->name=='in-progress')
                                    <span class="label label-info">{{$status->name}}</span>
                                @elseif($status->name=='releasing')
                                    <span class="label label-warning">{{$status->name}}</span>
                                @elseif($status->name=='planning')
                                    <span class="label label-danger">{{$status->name}}</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
        @endif <!-- endcode from trinhhunganh . -->
    </div>
@endsection
