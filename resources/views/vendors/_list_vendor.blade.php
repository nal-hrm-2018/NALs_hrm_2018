<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
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
                            <span class="label label-primary">Active</span>
                        @else
                            <span class="label label-danger">Inactive</span>
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
        @if(isset($param))
            {{  $vendors->appends($param)->render('vendor.pagination.custom') }}
        @endif
    </div>
    <!-- /.box-body -->
</div>