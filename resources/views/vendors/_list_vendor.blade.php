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
                    'id'=>'form_search_vendor',
                    'role'=>'form',
                ]) !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                        </div>
                        @include('vendors._form_search_vendor')
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
                    $('#form_search_vendor').submit()
                });
            })();

        </script>
        <table id="employee-list" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th  class="small-row-id text-center">{{trans('vendor.profile_info.id')}}</th>
                <th>{{trans('vendor.profile_info.name')}}</th>
                <th>{{trans('vendor.profile_info.company')}}</th>
                <th>{{trans('vendor.profile_info.role')}}</th>
                <th>{{trans('vendor.profile_info.status')}}</th>
            </tr>
            </thead>
            <tbody class="context-menu">
            @foreach($vendors as $vendor)
                <tr class="employee-menu" id="employee-id-{{$vendor->id}}"
                    data-employee-id="{{$vendor->id}}">
                    <td class="text-center">{{ isset($vendor->id )? $vendor->id : "-"}}</td>
                    <td>{{ isset($vendor->name)? $vendor->name: "-" }}</td>
                    <td>{{ isset($vendor->company)? $vendor->company: "-"}}</td>
                    <td>
                        <?php
                        if(isset($vendor->role)){
                            if($vendor->role->name == "PO"){
                                echo "<span class='label label-primary'>". $vendor->role->name ."</span>";
                            } else if($vendor->role->name == "Dev"){
                                echo "<span class='label label-success'>". $vendor->role->name ."</span>";
                            } else if($vendor->role->name == "BA"){
                                echo "<span class='label label-info'>". $vendor->role->name ."</span>";
                            } else if($vendor->role->name == "ScrumMaster"){
                                echo "<span class='label label-warning'>". $vendor->role->name ."</span>";
                            }
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td>
                        @if($vendor->work_status == 0)
                            @if(strtotime($vendor->endwork_date) >= strtotime(date('Y-m-d')))
                                <span class="label label-primary">Active</span>
                            @else
                                <span class="label label-danger">Expired</span>
                            @endif
                        @else
                            <span class="label label-default">Quited</span>
                        @endif
                    </td>

                    <ul class="contextMenu" data-employee-id="{{$vendor->id}}" hidden>

                        <li><a href={{route('vendors.show',$vendor->id)}}><i
                                        class="fa fa-id-card"></i> {{trans('common.action.view')}}
                            </a></li>
                        <li><a href={{ route('vendors.edit',$vendor->id)}}><i
                                        class="fa fa-edit"></i>
                                {{trans('common.action.edit')}}</a></li>
                        <li><a href="javascript:void(0)" class="btn-employee-remove" data-employee-id="{{$vendor->id}}"
                               data-employee-name="{{$vendor->name}}"><i class="fa fa-remove"></i> {{trans('common.action.remove')}}
                            </a></li>
                    </ul>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($vendors->hasPages())
            <div class="col-sm-5">
                <div class="dataTables_info" style="float:left" id="example2_info" role="status" aria-live="polite">
                    {{getInformationDataTable($vendors)}}
                </div>
            </div>
        <div class="col-sm-7">
            {{  $vendors->appends($param)->render('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
    <!-- /.box-body -->
</div>