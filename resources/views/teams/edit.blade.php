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
                    <?php
                    if (Session::get('msg_fail') != "") {
                        echo '<div>
                                <ul class=\'error_msg\'>
                                    <li>' . Session::get("msg_fail") . '</li>
                                </ul>
                            </div>';
                    }
                    ?>
                    {{Form::model($teamById,array('url' => ['/teams', $teamById['id']], 'method' => 'PUT'))}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <!-- /.col -->
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Team name</label>
                                <input type="text" class="form-control width80" id="team_name" placeholder="Team name"
                                       name="team_name"
                                       value="{!! old('name', isset($teamById["name"]) ? $teamById["name"] : null) !!}"
                                       @if(\Illuminate\Support\Facades\Auth::user()->role_id != $numberPoInRole)
                                       readonly="readonly"
                                        @endif>
                                <!-- /.input group -->
                            </div>
                            <div class="" id="name_error" style="color: red;">
                                <label style="color: red;">{{$errors->first('team_name')}}</label>
                            </div>
                            <div class="form-group">
                                <label>PO name</label><br/>
                                <select class="form-control select2 width80" id="select_po_name" name="po_name"
                                        onchange="choosePO()">
                                    @if(!empty($nameEmployee))
                                        <option selected="selected" {{'hidden'}}  value="{{$idEmployee}}" id="po_0">
                                            {{$nameEmployee}}
                                        </option>
                                    @else
                                        <option selected="selected"
                                                value="0" id="po_0">
                                            {{  trans('employee.drop_box.placeholder-default') }}
                                        </option>
                                    @endif
                                    @foreach($allEmployeeHasPOs as $allEmployeeHasPO)
                                        @if(\Illuminate\Support\Facades\Auth::user()->id == $allEmployeeHasPO->id )
                                            <option selected="selected" {{'hidden'}}  value="{{$idEmployee}}" id="po_0">
                                                {{$nameEmployee}}
                                            </option>
                                        @else
                                            <option value="{{ $allEmployeeHasPO['id']}}" id="po_{{ $allEmployeeHasPO['id']}}">
                                                {{ $allEmployeeHasPO -> name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="" style="color: red;">
                                <label style="color: red;">{{$errors->first('po_name')}}</label>
                            </div>
                            <div class="form-group">
                                <label>Member</label><br/>
                                <select class="form-control select2 width80" name="employees" id="member">
                                    <option value="0" id="member_0">{{ trans('employee.drop_box.placeholder-default') }}</option>
                                    @foreach($allEmployeeHasPOs as $allEmployeeHasPO)
                                        <option value="{{$allEmployeeHasPO["id"]}}"
                                                id="member_{{$allEmployeeHasPO["id"]}}">{{$allEmployeeHasPO["name"]}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-default buttonAdd">
                                    <a onclick="addFunction()"><i class="fa fa-user-plus"></i> ADD</a>
                                </button>
                            </div>
                            <div class="" style="color: red;">
                                <label style="color: red;">{{$errors->first('employees')}}</label>
                            </div>
                            <div class="form-group" id="listChoose" style="display: none;">
                                @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                                    <input type="text" hidden="hidden" name="employee[]" value="{{$allEmployeeInTeam->id}}">
                                @endforeach
                            </div>
                            <div class="form-group" id="contextMenuTeam">
                                <div class="box-body">
                                  <table id="employee-list" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>                                            
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Team</th>
                                            <th>Role</th>
                                            <th>Remove</th>
                                        </tr>
                                      </thead>
                                      <tbody class="context-menu">
                                        @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                                            <tr id="show_{{$allEmployeeInTeam->id}}">                                                
                                                <td>{{$allEmployeeInTeam->id}}</td>
                                                <td>{{isset($allEmployeeInTeam->team)?$allEmployeeInTeam->team:'---'}}</td>
                                                <td>{{isset($allEmployeeInTeam->role)?$allEmployeeInTeam->role:'---'}}</td>
                                                <td>{{$allEmployeeInTeam->name}}</td>
                                                <td>
                                                    <a class="btn-employee-remove" style="margin-left: 25px;">
                                                        <i class="fa fa-remove"
                                                       onclick="removeEmployee({{$allEmployeeInTeam->id}} , '{{$allEmployeeInTeam->name}}') "></i>
                                                   </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                      </tbody>
                                  </table>
                                </div>                                                                   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px; padding-bottom: 20px; ">
                    <div class="col-md-6" style="display: inline; ">
                        <div style="float: right;">
                            <input id="btn_reset_form_team" type="button" value="{{ trans('common.button.reset')}}"
                                   class="btn btn-default pull-left">
                        </div>
                    </div>
                    <div class="col-md-1" style="display: inline;">
                        <div style="float: right;">
                            <button type="submit" class="btn btn-info pull-left">Update</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                <script type="text/javascript"
                    src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                <script type="text/javascript">
                    $listEmployeeID = new Array();
                    $listEmployeeName = new Array();
                    $listEmployeeTeam = new Array();
                    $listEmployeeRole = new Array();
                    @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                        $listEmployeeID.push({{$allEmployeeInTeam->id}});
                        $listEmployeeName.push('{{$allEmployeeInTeam->name}}');
                        $listEmployeeTeam.push('{{isset($allEmployeeInTeam->team)?$allEmployeeInTeam->team:'---'}}');
                        $listEmployeeRole.push('{{isset($allEmployeeInTeam->role)?$allEmployeeInTeam->role:'---'}}');
                        
                        $('#member_{{$allEmployeeInTeam->id}}').prop('disabled', true);                        
                        $('#po_{{$allEmployeeInTeam->id}}').prop('disabled', true);                        
                    @endforeach
                    $idPO = document.getElementById("select_po_name").value;
                    $('#member_'+$idPO).prop('disabled', true);
                    
                    $dem = 0;
                </script>
                <script type="text/javascript">
                    function addFunction() {
                        $id = document.getElementById("member").value;
                        if ($id != 0) {
                            $dem ++;
                                                           
                            $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                            $listEmployeeName[$listEmployeeName.length] = $("#member_" + $id).text(); 
                            @foreach($allEmployees as $allEmployee)
                                if({{ $allEmployee -> id }} == $listEmployeeID[$listEmployeeID.length -1]){
                                    $listEmployeeTeam[$listEmployeeTeam.length] = '{{isset($allEmployee->team)?$allEmployee->team->name:'---'}}';
                                    $listEmployeeRole[$listEmployeeRole.length] = '{{isset($allEmployee->role)?$allEmployee->role->name:'---'}}';
                                }     
                            @endforeach

                            $listAdd = "";
                            for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                $listAdd += "<tr id=\"show_" + $listEmployeeID[$i] + "\">"+
                                        "<td>" + $listEmployeeID[$i]+"</td>"+
                                        "<td>"+$listEmployeeTeam[$i]+"</td>"+
                                        "<td>"+$listEmployeeRole[$i]+"</td>"+
                                        "<td>" + $listEmployeeName[$i]+ "</td>"+
                                        "<td><a class=\"btn-employee-remove\"  style=\"margin-left: 25px;\"><i class=\"fa fa-remove\"  onclick=\"removeEmployee(" + $listEmployeeID[$i] + ",\'" + $listEmployeeName[$i] + "\')\"></i></td></tr>";                              
                            }

                            $listAdd = "<div class=\"box-body\"><table id=\"employee-list\" class=\"table table-bordered table-striped\">"+
                                    "<thead><tr><th>ID</th><th>Team</th><th>Role</th><th>Name</th><th>Remove</th></tr></thead><tbody class=\"context-menu\">"+ $listAdd +
                                    "</tbody></table></div>";
                            $listChoose = "";
                            for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                $listChoose += "<input type=\"text\" name=\"employee[]\" id=\"employee\" value=\"" + $listEmployeeID[$i] + "\" class=\"form-control width80 input_" + $listEmployeeID[$i] + "\">";
                            }


                            document.getElementById("contextMenuTeam").innerHTML = $listAdd;
                            document.getElementById("listChoose").innerHTML = $listChoose;

                            $('#member_'+$id).prop('disabled', true);
                            $('#member').select2();

                            $('#po_'+$id).prop('disabled', true);
                            $('#select_po_name').select2();
                        }
                    }
                </script>
                <script type="text/javascript">
                    function removeEmployee($id, $name) {
                        $('tr').remove('#show_' + $id);
                        $('input').remove('.input_' + $id);
                        $listEmployeeID.splice($listEmployeeID.indexOf($id), 1);
                        $listEmployeeName.splice($listEmployeeName.indexOf($name), 1);

                        $('#member_'+$id).prop('disabled', false);
                        $('#member').select2();

                        $('#po_'+$id).prop('disabled', false);
                        $('#select_po_name').select2();
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

                var select_members = $("#member");
                select_members.val('0');
                $("#team_name").val('');

                var select_po = $('#select_po_name');
                select_po.val({{$idEmployee}}).change();


                $("#contextMenuTeam").innerHTML ="";
                $("#listChoose").innerHTML ="";

                for($i = $listEmployeeID.length - $dem; $i < $listEmployeeID.length; $i++){
                    $('#member_'+$listEmployeeID[$i]).prop('disabled', false);
                    $('#member').select2();

                    $('#po_'+$listEmployeeID[$i]).prop('disabled', false);
                    $('#select_po_name').select2();
                }

                $listEmployeeID = new Array();
                $listEmployeeName = new Array();
                $listEmployeeTeam = new Array();
                $listEmployeeRole = new Array();
                @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                    $listEmployeeID.push({{$allEmployeeInTeam->id}});
                    $listEmployeeName.push('{{$allEmployeeInTeam->name}}');
                    $listEmployeeTeam.push('{{isset($allEmployeeInTeam->team)?$allEmployeeInTeam->team:'---'}}');
                    $listEmployeeRole.push('{{isset($allEmployeeInTeam->role)?$allEmployeeInTeam->role:'---'}}'); 
                @endforeach
                $listAdd1 = "";

                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                    $listAdd1 += "<li  id=\"show_" + $listEmployeeID[$i] + "\"><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"  onclick=\"removeEmployee(" + $listEmployeeID[$i] + ",\'" + $listEmployeeName[$i] + "\')\"></i><label>ID:" + $listEmployeeID[$i] + "&emsp;</label><label>" + $listEmployeeTeam[$i] + "&emsp;</label><label>" + $listEmployeeRole[$i] + "&emsp;</label><label>" + $listEmployeeName[$i] + "</label></a></li>";
                }
                $listChoose1 = "";
                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                    $listChoose1 += "<input type=\"text\" name=\"employee[]\" id=\"employee\" value=\"" + $listEmployeeID[$i] + "\" class=\"form-control width80 input_" + $listEmployeeID[$i] + "\">";
                }
                document.getElementById("contextMenuTeam").innerHTML = $listAdd1;
                document.getElementById("listChoose").innerHTML = $listChoose1;
                $listEmployeeID1 = null; $listEmployeeName1 =null;
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