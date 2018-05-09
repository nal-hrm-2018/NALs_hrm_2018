@extends('admin.template')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add team
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/team">Teams</a></li>
      <li class="active">Add team</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
      <div class="box-body">
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
                    'id' => 'team_name_id',
                    'autofocus' => true,
                    'placeholder'=>'Team name'
                    ])
                }}
                <!-- /.input group -->
                  <label style="color: red; ">{{$errors->first('team_name')}}</label>
              </div>
              <div class="form-group">
                <label>PO name</label><br />
                <select class="form-control select2 width80" name="id_po" onchange="choosePO()" id="id_po">
                  <option {{ !empty(request('id_po'))?'':'selected="selected"' }} value="0" id="po_0">
                    {{  trans('employee.drop_box.placeholder-default') }}
                  </option>
                  @foreach($employees as $key=>$value)
                    <option value="{{ $key }}" {{ (string)$key===request('id_po')?'selected="selected"':'' }} id="po_{{$key}}">{{ $value }}</ption>
                  @endforeach
                </select>
                  <label style="color: red; ">{{$errors->first('id_po')}}</label>
              </div>
              <div class="form-group">
                <label>Member</label><br />
                <select class="form-control select2 width80" name="members" id="member">
                  <option selected="selected" value="0" id="member_0">
                    {{  trans('employee.drop_box.placeholder-default') }}
                  </option>
                  @foreach($employees as $key=>$value)
                    <option value="{{ $key }}" id="member_{{ $key }}">{{$value}}</option>
                  @endforeach
                </select>
                  {{--<input type="hidden" name="members[]" value="42"/>--}}
                  {{--<input type="hidden" name="members[]" value="42"/>--}}
                <button type="button" class="btn btn-default buttonAdd">
                    <a onclick="addFunction()"><i class="fa fa-user-plus"></i> {{ trans('common.button.add')}}</a>
                </button>
                  <label style="color: red; ">{{$errors->first('members')}}</label>
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
              <div style="float: right;" >
                <input type="reset" value="{{ trans('common.button.reset')}}" class="btn btn-info pull-left">
              </div>
            </div>
            <div class="col-md-1" style="display: inline;">
              <div style="float: right;">
                  <button type="submit" class="btn btn-info pull-left">{{trans('common.button.save')}}</button>
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        <script type="text/javascript">
          $listEmployeeID = new Array();
          $listEmployeeName = new Array();
          $idPO = "";
          $namePO = "";
        </script>
        <script type="text/javascript">
          function addFunction(){
            $id = document.getElementById("member").value;
            if($id != 0){
              if($listEmployeeID == null){
                $listEmployeeID[0] = document.getElementById("member").value;
                $listEmployeeName[0] = $("#member_"+$id).text();
              }else{
                $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                $listEmployeeName[$listEmployeeName.length] = $("#member_"+$id).text();
              }
              $listAdd = "";
              for($i = 0; $i < $listEmployeeID.length; $i++){
                $listAdd += "<li  id=\"show_"+$listEmployeeID[$i]+"\"><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"  onclick=\"removeEmployee("+$listEmployeeID[$i]+",\'"+$listEmployeeName[$i]+"\')\"></i><label>ID:"+$listEmployeeID[$i]+"</label><label>"+$listEmployeeName[$i]+"</label></a></li>";
              }
              $listChoose = "";
              for($i = 0; $i < $listEmployeeID.length; $i++){
                $listChoose += "<input type=\"text\" name=\"employee\" id=\"employee\" value=\""+$listEmployeeID[$i]+"\" class=\"form-control width80 input_"+$listEmployeeID[$i]+"\">";
              }
              document.getElementById("contextMenuTeam").innerHTML = $listAdd;
              document.getElementById("listChoose").innerHTML = $listChoose;
              $('option').remove('#member_'+$id);
            }
          }
        </script>
        <script type="text/javascript">
          function removeEmployee($id, $name){
            $('li').remove('#show_'+$id);
            $('input').remove('.input_'+$id);
            $listEmployeeID.splice($listEmployeeID.indexOf($id),1);
            $listEmployeeName.splice($listEmployeeName.indexOf($id),1);
            $option = document.createElement("option");
            $option.value = $id;
            $option.text = $name;
            $option.id = "member_"+$id;
            $select = document.getElementById('member');
            $select.appendChild($option);
          }
        </script>
        <script type="text/javascript">
          function choosePO(){
            if($idPO == ""){
              $idPO = document.getElementById("id_po").value;
              $namePO = $("#po_"+$idPO).text();
            }else{
              $option = document.createElement("option");
              if($idPO != 0){
                $option.value = $idPO;
                $option.text = $namePO;
                $option.id = "member_"+$idPO;
                $select = document.getElementById('member');
                $select.appendChild($option);
              }
              $idPO = document.getElementById("id_po").value;
              $namePO = $("#po_"+$idPO).text();
            }
            $id = document.getElementById("id_po").value;
            $('option').remove('#member_'+$id);
          }
        </script>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
    .width80{
      width: 80%;
    }
    .buttonAdd{
      margin-left: 10px;
    }
  </style>
  <style type="text/css">
    ul.contextMenuTeam *{
        transition:color .4s, background .4s;
    }

    ul.contextMenuTeam li{
        min-width:100px;
        max-width:250px;
        overflow: hidden;
        white-space: nowrap;
        margin-left: 150px;
        padding: 6px 6px;
        background-color: #fff;
        border-bottom:1px solid #ecf0f1;
    }

    ul.contextMenuTeam li a{
        color:#333;
        text-decoration:none;
    }

    ul.contextMenuTeam li:hover{
        background-color: #ecf0f1;
    }

    ul.contextMenuTeam li:first-child{
        border-radius: 5px 5px 0 0;
    }

    ul.contextMenuTeam li:last-child{
        border-bottom:0;
        border-radius: 0 0 5px 5px
    }

    ul.contextMenuTeam li:last-child a{width:26%;}
    ul.contextMenuTeam li:last-child:hover a{color:#2c3e50}
    ul.contextMenuTeam li:last-child:hover a:hover{color:#2980b9}
  </style>
@endsection