@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <h4 class="modal-title">{{  trans('common.path.absence') }}</h4>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}</a>
                </li>
                <li><a href="{{asset('/employee')}}">{{trans('common.path.absence')}}</a></li>
                <li class="active">{{trans('common.path.po_project')}}</li>
            </ol>

        </section>
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li>
                        <a id="tab-confirmation" href="#confirmation" data-toggle="tab">{{trans('common.path.confirmation')}}</a>
                    </li>
                    <li>
                        <a id="tab-statistic" href="#statistic" data-toggle="tab">{{trans('common.path.statistic')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="confirmation">
                        <div class="box-body">
                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                            <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
                        </button>
                        <div id="demo" class="collapse">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                                       value=""/>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.employee_name')}}</button>
                                                    </div>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.email')}}</button>
                                                    </div>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.project_name')}}</button>
                                                    </div>
                                                    <select name="role" id="role" class="form-control">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.type')}}</button>
                                                    </div>
                                                    <select name="project_status" id="project_status" class="form-control">
                                                        <option {{ !empty(request('project_status'))?'':'selected="selected"' }} value="">
                                                            {{  trans('employee.drop_box.placeholder-default') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.from')}}</button>
                                                    </div>
                                                </div>
                                                <div class="input-group margin">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn width-100">{{trans('absence.confirmation.to')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer center">
                                        <button id="btn_reset" type="button" class="btn btn-default"><span class="fa fa-refresh"></span> {{ trans('common.button.reset')}}
                                        </button>
                                        <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> {{ trans('common.button.search')  }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="project-list" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{trans('absence.confirmation.employee_name')}}</th>
                                <th>{{trans('absence.confirmation.email')}}</th>
                                <th>{{trans('absence.confirmation.project_name')}}</th>
                                <th>{{trans('absence.confirmation.from')}}</th>
                                <th>{{trans('absence.confirmation.to')}}</th>
                                <th>{{trans('absence.confirmation.type')}}</th>
                                <th>{{trans('absence.confirmation.cause')}}</th>
                                <th>{{trans('absence.confirmation.description')}}</th>
                                <th>{{trans('absence.confirmation.status')}}</th>
                                <th>{{trans('absence.confirmation.reject_cause')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Nguyễn Văn An</td>
                                <td>an@nal.com</td>
                                <td>PRO_0001</td>
                                <td>23/06/2018 08:00</td>
                                <td>23/06/2018 17:30</td>
                                <td>Nghỉ Phép</td>
                                <td>Đi Du Lịch</td>
                                <td>-</td>
                                <td>
                                    <div class="btn-group-vertical">
                                        <button class="btn btn-xs btn-primary accept">Đồng Ý</button>
                                        <button class="btn btn-xs btn-danger reject">Từ Chối</button>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nguyễn Văn An</td>
                                <td>an@nal.com</td>
                                <td>PRO_0001</td>
                                <td>23/06/2018 08:00</td>
                                <td>23/06/2018 17:30</td>
                                <td>Nghỉ Phép</td>
                                <td>Đi Du Lịch</td>
                                <td>-</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nguyễn Văn An</td>
                                <td>an@nal.com</td>
                                <td>PRO_0001</td>
                                <td>23/06/2018 08:00</td>
                                <td>23/06/2018 17:30</td>
                                <td>Nghỉ Phép</td>
                                <td>Đi Du Lịch</td>
                                <td>-</td>
                                <td>

                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nguyễn Văn An</td>
                                <td>an@nal.com</td>
                                <td>PRO_0001</td>
                                <td>23/06/2018 08:00</td>
                                <td>23/06/2018 17:30</td>
                                <td>Nghỉ Phép</td>
                                <td>Đi Du Lịch</td>
                                <td>-</td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="statistic">

                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- Main content -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery 3 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('admin/templates/js/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).ready(function () {
                $('#tab-confirmation').tab('show');
            });
        });
    </script>
@endsection