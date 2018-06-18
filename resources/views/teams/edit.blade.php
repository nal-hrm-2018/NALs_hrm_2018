@extends('admin.template')
@section('content')

    <style type="text/css">
        .width80 {
            width: 80%;
        }

        .buttonAdd {
            margin-left: 10px;
        }
    </style>
    <style type="text/css">
        ul.contextMenuTeam * {
            transition: color .4s, background .4s;
        }

        li {
            list-style-type: none;
        }

        ul.contextMenuTeam li {
            min-width: 100px;
            max-width: 350px;
            overflow: hidden;
            white-space: nowrap;
            margin-left: 130px;
            padding: 6px 6px;
            background-color: #fff;
            border-bottom: 1px solid #ecf0f1;
        }

        ul.contextMenuTeam li a {
            color: #333;
            text-decoration: none;
        }

        ul.contextMenuTeam li:hover {
            background-color: #ecf0f1;
        }

        ul.contextMenuTeam li:first-child {
            border-radius: 5px 5px 0 0;
        }

        ul.contextMenuTeam li:last-child {
            border-bottom: 0;
            border-radius: 0 0 5px 5px
        }

        ul.contextMenuTeam li:last-child a {
            width: 26%;
        }

        ul.contextMenuTeam li:last-child:hover a {
            color: #2c3e50
        }

        ul.contextMenuTeam li:last-child:hover a:hover {
            color: #2980b9
        }
    </style>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit team
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> {{trans("common.path.home")}}</a></li>
                <li><a href="{{route('teams.index')}}">{{trans("common.path.team")}}</a></li>
                <li class="active">Edit team</li>
            </ol>
        </section>
            <SCRIPT LANGUAGE="JavaScript">
                function confirmTeam() {
                    var name = $('#team_name').val();
                    var id = $('#id_team').val();
                    return confirm(message_confirm('edit', 'team', id, name));
                }
            </SCRIPT>

        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-body">
                    <div id="msg">
                    </div>

                    {{Form::model($team,array('url' => ['/teams', $team->id], 'method' => 'PUT', 'id' => 'form_edit_team'))}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id_team" value="{{ $team->id }}">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <!-- /.col -->
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Team name<strong style="color: red">(*)</strong></label>
                                <input type="text" class="form-control width80" id="team_name" placeholder="Team name"
                                       name="team_name"
                                       value="{!! old('team_name', isset($team->name) ? $team->name : null) !!}"
                                       >
                                <!-- /.input group -->
                            </div>
                            <div class="" id="name_error" style="color: red;">
                                <label id="lb_error_team_name" style="color: red; ">{{$errors->first('team_name')}}</label>
                            </div>
                            <div class="form-group">
                                <label>PO name</label><br/>
                                <select class="form-control select2 width80" id="select_po_name" name="po_name"
                                        onchange="choosePO()">
                                    <option value="0" id="po_0">{{ trans('employee.drop_box.placeholder-default') }}
                                    @foreach($listEmployee as $obj)
                                        {{$selected = ""}}
                                        @if(isset($poOfteam))
                                            @if( $obj->is_manager == '1')
                                                {{$selected = "selected"}}
                                            @endif
                                        @endif
                                        <option value="{{ $obj->id}}" id="po_{{ $obj->id}}" {{$selected}}>
                                            {{ $obj -> name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="" style="color: red;">
                                <label id="lb_error_po_name" style="color: red;">{{$errors->first('po_name')}}</label>
                            </div>
                            <div class="form-group">
                                <label>Member</label><br/>
                                <select class="form-control select2 width80" name="employees" id="member">
                                    <option value="0" id="member_0">{{ trans('employee.drop_box.placeholder-default') }}</option>
                                    @foreach($listEmployee as $obj)
                                        <option value="{{$obj->id}}"
                                                id="member_{{$obj->id}}">{{$obj->name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-default buttonAdd">
                                    <a onclick="addFunction()"><i class="fa fa-user-plus"></i> ADD</a>
                                </button>
                            </div>
                            <div class="" style="color: red;">
                                <label id="lb_error_employees" style="color: red;">{{$errors->first('employees')}}</label>
                            </div>
                            <div class="form-group" id="listChoose" style="display: none;">
                                @foreach($listEmployeeOfTeam as $obj)
                                    <input type="text" hidden="hidden" class="input_{{$obj->id}}" name="employee[]" id="" value="{{$obj->id}}">
                                @endforeach
                            </div>
                            <div class="form-group" id="contextMenuTeam">
                                <div class="box-body">
                                    @if(!($listEmployeeOfTeam->isEmpty()))
                                  <table id="employee-list" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>                                            
                                            <th>ID</th>
                                            <th>Team</th>
                                            <th>Role</th>
                                            <th>Name</th>
                                            <th>Remove</th>
                                        </tr>
                                      </thead>
                                      <tbody class="context-menu">
                                        @foreach($listEmployeeOfTeam as $obj)
                                            <tr id="show_{{$obj->id}}">                                                
                                                <td>{{$obj->id}}</td>
                                                <td>{{isset($obj->team)?$obj->team:'-'}}</td>
                                                <td>
                                                    <?php
                                                    if(isset($obj->role)){
                                                        if($obj->role == "PO"){
                                                            echo "<span class='label label-primary'>". $obj->role ."</span>";
                                                        } else if($obj->role == "Dev"){
                                                            echo "<span class='label label-success'>". $obj->role ."</span>";
                                                        } else if($obj->role == "BA"){
                                                            echo "<span class='label label-info'>". $obj->role ."</span>";
                                                        } else if($obj->role == "ScrumMaster"){
                                                            echo "<span class='label label-warning'>". $obj->role ."</span>";
                                                        }
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                </td>
                                                <td>{{$obj->name}}</td>
                                                <td>
                                                    <a class="btn-employee-remove" style="margin-left: 25px;">
                                                        <i class="fa fa-remove"
                                                       onclick='removeEmployeeTeam({{$obj->id}}) '></i>
                                                   </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                      </tbody>
                                  </table>
                                  @endif
                                </div>                                                                   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                    <div class="col-md-6" style="display: inline; ">
                        <div style="float: right;">
                            <input id="btn_reset_form_team" type="button" value="{{ trans('common.button.reset')}}"
                                   class="btn btn-default pull-left" />
                        </div>
                    </div>
                    <div class="col-md-1" style="display: inline;">
                        <div style="float: right;">
                            <button type="submit" id="button-edit-team" class="btn btn-info pull-left">SAVE</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                <script type="text/javascript">
                    $(document).ready(function (){
                        $("#form_edit_team").submit( function(){
                            return confirmTeam();
                        });
                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function (){
                        $listEmployeeID = new Array();
                        $listEmployeeName = new Array();
                        $listEmployeeTeam = new Array();
                        $listEmployeeRole = new Array();
                        @foreach($listEmployeeOfTeam as $obj)
                            $listEmployeeID.push('{{$obj->id}}');
                            $listEmployeeName.push('{{$obj->name}}');
                            $listEmployeeTeam.push('{{isset($obj->team)?$obj->team:'-'}}');
                            $listEmployeeRole.push('{{isset($obj->role)?$obj->role:'-'}}');
                            
                            $('#member_{{$obj->id}}').prop('disabled', true);
                            $('#member').select2();
                            $('#po_{{$obj->id}}').prop('disabled', true);
                            $('#select_po_name').select2();
                        @endforeach
                        $idPO = document.getElementById("select_po_name").value;
                        $('#member_'+$idPO).prop('disabled', true);
                        $('#member').select2();
                        $dem = 0;
                    })
                </script>
                <script type="text/javascript">
                    function addFunction() {
                        $id = document.getElementById("member").value;
                        $idPo = document.getElementById("select_po_name").value;
                        if($id == document.getElementById("select_po_name").value){
                            alert("Member matches with PO, Please select another member !!!");
                        }else{
                            $check = true;
                            for ($i = 0; $i < $listEmployeeID.length; $i++) {
                              if($id == $listEmployeeID[$i]){
                                $check = false;
                                alert("Error!!! Member already exist !!!");
                                break;
                              }
                            }
                            if($id != 0 && $check == true) {
                                $dem++;
                                $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                                $listEmployeeName[$listEmployeeName.length] = $("#member_" + $id).text();
                                @foreach($listEmployee as $obj)
                                    if ({{ $obj -> id }} == $listEmployeeID[$listEmployeeID.length - 1])
                                    {
                                        $listEmployeeTeam[$listEmployeeTeam.length] = '{{isset($obj->team)?$obj->team->name:'-'}}';
                                        $listEmployeeRole[$listEmployeeRole.length] = '{{isset($obj->role)?$obj->role->name:'-'}}';
                                    }
                                @endforeach

                                $listAdd = "";
                                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                    $classBtr = '';
                                    if($listEmployeeRole[$i] == 'PO'){
                                        $classBtr = 'label label-primary';
                                    } else if($listEmployeeRole[$i] == 'Dev'){
                                        $classBtr = 'label label-success';
                                    } else if($listEmployeeRole[$i] == 'BA'){
                                        $classBtr = 'label label-info';
                                    } else if($listEmployeeRole[$i] == 'ScrumMaster'){
                                        $classBtr = 'label label-warning';
                                    }
                                    $listAdd += "<tr id=\"show_" + $listEmployeeID[$i] + "\">" +
                                        "<td>" + $listEmployeeID[$i] + "</td>" +
                                        "<td>" + $listEmployeeTeam[$i] + "</td>" +
                                        "<td><span class=\""+ $classBtr +"\">" + $listEmployeeRole[$i] + "</span></td>" +
                                        "<td>" + $listEmployeeName[$i] + "</td>" +
                                        "<td><a class=\"btn-employee-remove\"  style=\"margin-left: 25px;\"><i class=\"fa fa-remove\"  onclick=\"removeEmployeeTeam(" + $listEmployeeID[$i] + ")\"></i></td></tr>";
                                }

                                $listAdd = "<div class=\"box-body\"><table id=\"employee-list\" class=\"table table-bordered table-striped\">" +
                                    "<thead><tr><th>ID</th><th>Team</th><th>Role</th><th>Name</th><th>Remove</th></tr></thead><tbody class=\"context-menu\">" + $listAdd +
                                    "</tbody></table></div>";
                                $listChoose = "";
                                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                    $listChoose += "<input type=\"text\" name=\"employee[]\" id=\"employee\" value=\"" + $listEmployeeID[$i] + "\" class=\"form-control width80 input_" + $listEmployeeID[$i] + "\">";
                                    if ($listEmployeeID[$i] == $idPo) {
                                        $('#po_'+$idPo).prop('disabled', true);
                                        $('#select_po_name').select2();
                                    }
                                }


                                document.getElementById("contextMenuTeam").innerHTML = $listAdd;
                                document.getElementById("listChoose").innerHTML = $listChoose;

                                $('#member_' + $id).prop('disabled', true);
                                $('#member').select2();

                                $('#po_' + $id).prop('disabled', true);
                                $('#select_po_name').select2();
                            }
                        }
                    }
                </script>
                <script type="text/javascript">
                    function removeEmployeeTeam($id) {
                        $('tr').remove('#show_' + $id);
                        $('input').remove('.input_' + $id);
                        $listEmployeeName.splice($listEmployeeID.indexOf(""+$id), 1);
                        $listEmployeeID.splice($listEmployeeID.indexOf(""+$id), 1);
                        
                        $('#member_'+$id).prop('disabled', false);
                        $('#member').select2();

                        $('#po_'+$id).prop('disabled', false);
                        $('#select_po_name').select2();

                        if($listEmployeeID.length == 0){
                            document.getElementById("contextMenuTeam").innerHTML = "";
                        }
                    }
                </script>
                <script type="text/javascript">
                    function choosePO() {
                        if ($idPO != 0) {
                            $('#member_'+$idPO).prop('disabled', false);
                            $('#member').select2();

                        }
                        $idPO = document.getElementById("select_po_name").value;
                        $('#member_'+$idPO).prop('disabled', true);
                        $('#member').select2();
                    }
                </script>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>

    <script>
        $(function () {
            $("#btn_reset_form_team").bind("click", function () {
				if(confirmAction('Do you want to reset?'))
                location.reload();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#team_name").blur(function () {
                var name = $(this).val();
                $.get("/checkTeamNameEdit", {name: name}, function (data) {
                    console.log(data);
                    $("#name_error").html(data);
                });
            });
        });
    </script>
@endsection