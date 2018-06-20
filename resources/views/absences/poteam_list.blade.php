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
                <th>{{trans('absence_po.list_po.profile_info.status')}}</th>
                <th>{{trans('absence_po.list_po.profile_info.note_po')}}</th>
            </tr>
            </thead>
            <tbody class="context-menu">
            <?php
            foreach ($allEmployeeNotNull as $element) {
                echo "<tr>";
                echo "<td>" . $element['name'] . "</td>";
                echo "<td>" . $element['email'] . "</td>";
                echo "<td>" .date('d/m/Y h:i:s',strtotime($element->absences[0]->from_date)) . "</td>";
                echo "<td>" .date('d/m/Y h:i:s',strtotime($element->absences[0]->to_date)) . "</td>";
//                echo "<td>" . $element->absences[0]->from_date . "</td>";
//                echo "<td>" . $element->absences[0]->to_date . "</td>";
                echo "<td>" . $element->absences[0]->absence_type_id . "</td>";
                echo "<td>" . $element->absences[0]->reason . "</td>";
                echo "<td>" . $element->absences[0]->description . "</td>";
                echo "<td>
<button class='btn btn-success'>Đồng ý</button>
<button class='btn btn-default'>Từ chối</button>
</td>";
                echo "<td></td>";
                echo "</tr>";
            }
            ?>
            <?php

            ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>