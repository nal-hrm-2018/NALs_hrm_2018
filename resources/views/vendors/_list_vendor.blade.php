<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <table id="employee-list" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>{{trans('vendor.profile_info.id')}}</th>
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
                    <td>{{ isset($vendor->id )? $vendor->id : "--.--"}}</td>
                    <td>{{ isset($vendor->name)? $vendor->name: "--.--" }}</td>
                    <td>{{ isset($vendor->company)? $vendor->company: "--.--"}}</td>
                    <td>{{ isset($vendor->processes)?(isset($vendor->roles)?getRoleofVendor($vendor):"--.--" ):"--.--" }}</td>
                    <td>
                        @if($vendor->work_status == 0) {{ trans('vendor.profile_info.work_status.active') }}
                        @elseif($vendor->work_status == 1) {{ trans('vendor.profile_info.work_status.unactive') }}
                        @endif
                    </td>

                    <ul class="contextMenu" data-employee-id="{{$vendor->id}}" hidden>

                        <li><a href={{route('vendors.show',$vendor->id)}}><i
                                        class="fa fa-id-card"></i> {{trans('common.action.view')}}
                            </a></li>
                        <li><a href={{ route('vendors.edit',$vendor->id)}}><i
                                        class="fa fa-edit"></i>
                                {{trans('common.action.edit')}}</a></li>
                        <li><a class="btn-employee-remove" data-employee-id="{{$vendor->id}}"><i
                                        class="fa fa-remove"></i> {{trans('common.action.remove')}}
                            </a></li>
                    </ul>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>