<div class="box">
    <!-- /.box-header -->
    <script src="{!! asset('admin/templates/js/search/search.js') !!}"></script>
    <div class="box-body">
        <div>
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" id="clickCollapse">
                <span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;<span id="iconSearch" class="glyphicon"></span>
            </button>
            <div id="demo" class="collapse" role="dialog">
                <div class="modal-dialog">
                    {!! Form::open(
                        [
                        'method'=>'GET',
                        'id'=>'form_search_absence_po'
                    ]) !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                        </div>
                        @include('absences.poteam_search_absence')
                        <div class="modal-footer center">
                            <button id="btn_reset_absence_po_team" type="button" class="btn btn-default"><span
                                        class="fa fa-refresh"></span>
                                {{trans('common.button.reset')}}
                            </button>
                            <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                        class="fa fa-search"></span>
                                {{trans('common.button.search')}}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
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
                    $('#form_search_absence_po').submit()
                });
            })();
        </script>
        <table id="absence-po-list" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th hidden="hidden"></th>
                <th>{{trans('vendor.profile_info.name')}}</th>
                <th>{{trans('vendor.profile_info.email')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.start_date')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.end_date')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.type')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.reason')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.note')}}</th>
                <th class="center">{{trans('absence_po.list_po.profile_info.status')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.note_po')}}</th>
            </tr>
            </thead>
            <style type="text/css">
                .list-project tr td {
                    vertical-align: middle !important;
                }
            </style>
            <tbody class="context-menu list-project">
            @foreach($getAllAbsenceInConfirm as $element)
                <tr class="employee-menu">
                    <td hidden="hidden">{{$element->absence['id']}}</td>
                    <td>
                        <div class="absence-center">
                            {{$element->absence->employee['name']}}
                        </div>
                    </td>
                    <td>
                        <div class="absence-center-email">
                            {{$element->absence->employee['email']}}
                        </div>
                    </td>

                    <td>
                        <div class="absence-center">
                            {{date('H:i:s d/m/Y ',strtotime($element->absence['from_date']))}}
                        </div>
                    </td>
                    <td>
                        <div class="absence-center">
                            {{date('H:i:s d/m/Y ',strtotime($element->absence['to_date']))}}
                        </div>
                    </td>
                    <td>
                        <div class="absence-center">
                            <span
                                @if($element->absence->absenceType->name === config('settings.status_common.absence_type.salary_date'))
                                    class="label label-success"
                                @elseif($element->absence->absenceType->name === config('settings.status_common.absence_type.insurance_date'))
                                    class="label label-primary"
                                @elseif($element->absence->absenceType->name === config('settings.status_common.absence_type.non_salary_date'))
                                    class="label label-warning"
                                @else
                                    class="label label-danger"
                                @endif
                            >
                            {{trans('absence_po.list_po.type.'.$element->absence->absenceType['name'])}}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="absence-center-reason">{{$element->absence->reason}}</div>
                    </td>
                    @if($element->absence->absenceStatus['name'] == config('settings.status_common.absence.waiting') && ($element->absenceStatus['name'] == config('settings.status_common.absence.waiting')))
                        @if($element->absence['is_deny'] == 0 )
                            <td class="notecss-confirm"
                                data-confirm-id="{{$element->id}}">
                                <div class="absence-center-reason">{{trans('absence_po.list_po.note.absence_new')}}</div>
                            </td>
                        @elseif($element->absence['is_deny'] == 1 )
                            <td class="notecss-confirm"
                                data-confirm-id="{{$element->id}}">
                                <div class="absence-center-reason">{{trans('absence_po.list_po.note.absence_deny')}}</div>
                            </td>
                        @else
                            <td class="notecss-confirm" data-confirm-id="{{$element->id}}">
                                <div class="absence-center-reason">-</div>
                            </td>
                        @endif
                    @else
                        <td class="notecss-confirm" data-confirm-id="{{$element->id}}">
                            <div class="absence-center-reason">-</div>
                        </td>
                    @endif

                    @if($element['is_process'] != 0 )
                        <td><span class="label label-danger">{{trans('absence_po.list_po.status.just_watching')}}</span> </td>
                    @else
                        @if($element->absenceStatus['name'] == config('settings.status_common.absence.waiting'))
                            <td class="center confirm-status" data-confirm-id="{{$element->id}}">
                                <div class="div confirm-status" data-confirm-id="{{$element->id}}">
                                    <input id="value-confirm" value="{{$element['id']}}" hidden="hidden"/>
                                    <a class="btn btn-danger status-absence" id="done-absence"
                                       data-confirm-id="{{$element->id}}"
                                       data-is-deny="{{$element->absence['is_deny']}}">
                                        {{trans('absence_po.list_po.modal.done')}}
                                    </a><br>
                                    <a class="btn btn-primary status-absence" data-toggle="modal"
                                       data-target="#modal-default-{{$element->id}}">
                                        {{trans('absence_po.list_po.modal.cancel')}}</a>
                                </div>
                            </td>
                        @elseif($element->absenceStatus['name'] == config('settings.status_common.absence.accepted'))
                            @if($element->absence['is_deny'] == 0)
                                <td class="center">
                                    <div class="absence-center-status">
                                        <span class="label label-success">{{trans('absence_po.list_po.status.accepted_done')}}</span></div>
                                </td>
                            @elseif($element->absence['is_deny'] == 1)
                                <td class="center">
                                    <div class="absence-center-status">
                                        <span class="label label-default">{{trans('absence_po.list_po.status.no_accepted_done')}}</span>
                                    </div>
                                </td>
                            @else
                                <td class="center">
                                    <div class="absence-center-reason">-</div>
                                </td>
                            @endif
                        @elseif($element->absenceStatus['name'] == config('settings.status_common.absence.rejected'))
                            @if($element->absence['is_deny'] == 0)
                                <td class="center">
                                    <div class="absence-center-status">{{trans('absence_po.list_po.status.no_accepted_done')}}</div>
                                </td>
                            @elseif($element->absence['is_deny'] == 1)
                                <td class="center">
                                    <div class="absence-center-status">{{trans('absence_po.list_po.status.accepted_done')}}</div>
                                </td>
                            @else
                                <td class="center">
                                    <div class="absence-center-status">-</div>
                                </td>
                            @endif
                        @else
                            <td>
                                <div class="absence-center-status">-</div>
                            </td>
                        @endif
                    @endif
                    <td class="reason-view" data-reason-view="{{$element->id}}">
                        <div class="absence-center">{{!empty($element->reason)?$element->reason:'-'}}
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="modal-default-{{$element->id}}">
                    <div class="modal-dialog" style="width: 400px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">{{trans('absence_po.list_po.modal.reason')}}</h4>
                            </div>
                            <input class="hidden is_deny id-{{$element->id}}" value="{{$element->absence['is_deny']}}"
                                   name="is_deny" hidden="hidden"/>
                            <input hidden="hidden" name="id_confirm" value="{{$element->id}}"/>
                            <div class="modal-body">
                                <textarea class="form-control id-{{$element->id}}" name="reason" rows="3"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">{{trans('absence_po.list_po.modal.close')}}</button>
                                <button type="button"
                                        class="btn btn-primary deny" data-confirm-id="{{$element->id}}"
                                        data-is-deny="{{$element->absence['is_deny']}}">{{trans('absence_po.list_po.modal.send')}}</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<div class="abc"></div>
<style>
    .btn.btn-danger.status-absence {
        font-size: 12px;
        line-height: 1.5;
        padding: 1px 6px;
        margin-bottom: 2px;
    }

    .btn.btn-primary.status-absence {
        font-size: 12px;
        line-height: 1.5;
        padding: 1px 5px;
    }

    .center {
        text-align: center;
    }
</style>
{{--<style>


    .btn.btn-danger.status-absence-deny {
        font-size: 12px;
        line-height: 1.5;
        padding: 1px 6px;
        margin-bottom: 2px;
    }

    .btn.btn-primary.status-absence-deny {
        font-size: 12px;
        line-height: 1.5;
        padding: 1px 5px;
    }

    .center {
        text-align: center;
    }
    .absence-center {
        margin-top: 13%;
        padding-bottom: 10%;
    }
    .absence-center-email{
        margin-top: 17%;
        padding-bottom: 10%;
    }
    .absence-center-reason {
        margin-top: 25%;
    }
    .absence-center-status {
         margin-top: 16%;
     }
</style>--}}
@include('absences._javascript_poteam_list')

