{!! Form::open(
    ['url' =>route('teams.store'),
    'method'=>'Post',
    'id'=>'form_add_team'
]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3">
    </div>
    <!-- /.col -->
    <div class="col-md-7">
        <div class="form-group">
            <label>Team name</label>
        {{ Form::text('team_name', old('team_name'),
          ['class' => 'form-control width80',
          'id' => 'team_name',
          'autofocus' => true,
          'placeholder'=>'Team name'
          ])
      }}
        <!-- /.input group -->
            <label id="lb_error_team_name" style="color: red; ">{{$errors->first('team_name')}}</label>
        </div>
        <div class="form-group">
            <label>PO name</label><br/>
            <select class="form-control select2 width80" name="id_po" id="id_po">
                <option {{ !empty(old('id_po'))?'':'selected="selected"' }} value="">
                    {{  trans('employee.drop_box.placeholder-default') }}
                </option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ (string)$employee->id===old('id_po')?'selected="selected"':'' }}>
                        {{ $employee->name }}
                        {{ ' '.isset($employee->team)?'|team '.$employee->team->name:'' }}
                    </option>
                @endforeach
            </select>
            <label id="lb_error_id_po" style="color: red; ">{{$errors->first('id_po')}}</label>
        </div>
        <div class="form-group">
            <label>Member</label><br/>
            <select class="form-control select2 width80" name="members" id="members">
                <option {{ !empty(old('members'))?'':'selected="selected"' }} value="">
                    {{  trans('employee.drop_box.placeholder-default') }}
                </option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ (string)$employee->id===old('members')?'selected="selected"':'' }}>
                        {{ $employee->name }}
                        {{ ' '.isset($employee->team)?'|team '.$employee->team->name:'' }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="members[]" value="42"/>
            <input type="hidden" name="members[]" value="42"/>
            <button type="button" class="btn btn-default buttonAdd">
                <a onclick="addFunction()"><i class="fa fa-user-plus"></i> {{ trans('common.button.add')}}</a>
            </button>
            <label id="lb_error_members" style="color: red; ">{{$errors->first('members')}}</label>
        </div>
        <div class="form-group" id="listChoose" style="display: none;">

        </div>
        <div class="form-group">
            <ul class="contextMenuTeam" id="contextMenuTeam">
            </ul>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
    <div class="col-md-6" style="display: inline; ">
        <div style="float: right;">
            <input id="btn_reset_form_team" type="button" value="{{ trans('common.button.reset')}}"
                   class="btn btn-info pull-left">
        </div>
    </div>
    <div class="col-md-1" style="display: inline;">
        <div style="float: right;">
            <button type="submit" class="btn btn-info pull-left">{{trans('common.button.save')}}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(function () {
        $("#btn_reset_form_team").bind("click", function () {
            $("#lb_error_team_name").empty();
            $("#lb_error_id_po").empty();
            $("#lb_error_members").empty();
            var select_po = $('#id_po');
            select_po.val('').change();
            var select_members = $("#members");
            select_members.val('').change();
            $("#team_name").val('');
        });
        

    });
</script>

