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
                        ['url' =>route('vendors.index'),
                        'method'=>'GET',
                        'id'=>'form_search_vendor'
                    ]) !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                        </div>
                        @include('absences.poteam_search_absence')
                        <div class="modal-footer center">
                            <button id="btn_reset_vendor" type="button" class="btn btn-default"><span
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
            {{--<div class="dataTables_length" id="project-list_length" style="float:right">
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
            </div>--}}
        </div>
        <table id="employee-list" class="table table-bordered table-striped">
            <thead>
            <tr>
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
            <tbody class="context-menu">
            @foreach($allEmployeeNotNull as $element)
                <tr>
                    <td>{{$element['name']}}</td>
                    <td>{{$element['email']}}</td>
                    <td>{{date('h:i:s d/m/Y ',strtotime($element->absences[0]->from_date))}}</td>
                    <td>{{date('h:i:s d/m/Y ',strtotime($element->absences[0]->to_date))}}</td>
                    <td>{{trans('absence_po.list_po.status.'.$element->absences[0]->absencestatus['name'])}}</td>
                    <td>{{$element->absences[0]->reason}}</td>
                    <td>{{trans('absence_po.list_po.type.'.$element->absences[0]->absencestypes['name'])}}</td>
                    <td class="center">
                        <a class="btn btn-danger status-absence">{{trans('absence_po.list_po.modal.done')}}</a><br>
                        <a class="btn btn-primary status-absence" data-toggle="modal" data-target="#modal-default">
                            {{trans('absence_po.list_po.modal.cancel')}}</a>
                    </td>
                    <td>{{$element->absences[0]->description}}</td>
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog" style="width: 400px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">{{trans('absence_po.list_po.modal.reason')}}</h4>
                                </div>
                                {!! Form::open(
                                    ['url' =>route('deny-po-team'),
                                    'method'=>'GET',
                                    'id'=>'form_deny_absence',
                                    'role'=>'form',
                                ]) !!}
                                <div class="modal-body">
                                    {{ Form::textarea('reason', old('reason'),
                                        ['class' => 'form-control',
                                        'id'=>'exampleFormControlTextarea1',
                                        'row'=>3])
                                    }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">{{trans('absence_po.list_po.modal.close')}}</button>
                                    <button type="submit"
                                            class="btn btn-primary">{{trans('absence_po.list_po.modal.send')}}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </tr>
            @endforeach
            <?php
            foreach ($allEmployeeNotNull as $element) {
                echo "<tr>";
                echo "<td>" . $element['name'] . "</td>";
                echo "<td>" . $element['email'] . "</td>";
                echo "<td>" . date('h:i:s d/m/Y ', strtotime($element->absences[0]->from_date)) . "</td>";
                echo "<td>" . date('h:i:s d/m/Y ', strtotime($element->absences[0]->to_date)) . "</td>";
                echo "<td>" . trans('absence_po.list_po.status.' . $element->absences[0]->absencestatus['name']) . "</td>";
                echo "<td>" . $element->absences[0]->reason . "</td>";
                echo "<td>" . trans('absence_po.list_po.type.' . $element->absences[0]->absencestypes['name']) . "</td>";
                echo "<td class='center'>
                        <a class='btn btn-danger status-absence'>" . trans('absence_po.list_po.modal.done') . "</a><br>
                        <a class='btn btn-primary status-absence'  data-toggle='modal' data-target='#modal-default'>
                        " . trans('absence_po.list_po.modal.cancel') . "
</a>
                      </td>";
                echo "<td>" . $element->absences[0]->description . "</td>";
                echo "</tr>";
                echo "";
            }
            ?>
            <?php

            ?>
            </tbody>
        </table>

    </div>
    <!-- /.box-body -->
</div>

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