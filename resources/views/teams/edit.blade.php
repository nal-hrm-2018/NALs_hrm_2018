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
            max-width: 250px;
            overflow: hidden;
            white-space: nowrap;
            margin-left: 110px;
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
                                    @foreach($allEmployees as $allEmployee)
                                        <option value="{{ $allEmployee['id']}}" id="po_{{ $allEmployee['id']}}">
                                            {{ $allEmployee["name"] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="" style="color: red;">
                                <label style="color: red;">{{$errors->first('po_name')}}</label>
                            </div>
                            <div class="form-group">
                                <label>Member</label><br/>
                                <select class="form-control select2 width80" name="employees" id="member">
                                    <option value="0" id="member_0">---Member---</option>
                                    @foreach($allEmployees as $allEmployee)
                                        <option value="{{$allEmployee["id"]}}"
                                                id="member_{{$allEmployee["id"]}}">{{$allEmployee["name"]}}</option>
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

                            </div>
                            <div class="form-group">
                                <ul class="contextMenuTeam" id="contextMenuTeam" >
                                    @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                                        <li class="listInTeam" id="show_{{$allEmployeeInTeam->id}}" data-employee-id="{{$allEmployeeInTeam->id}}">
                                            <input type="text" hidden="hidden" name="employee[]" value="{{$allEmployeeInTeam->id}}">
                                            <a class="btn-employee-remove">
                                                <i class="fa fa-remove"
                                                   onclick="removeEmployee({{$allEmployeeInTeam->id}} , '{{$allEmployeeInTeam->name}}') "></i>
                                                <label>ID:{{$allEmployeeInTeam->id}}</label>
                                                <label>{{$allEmployeeInTeam->name}}</label>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
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
                <script type="text/javascript">
                    $listEmployeeID = new Array();
                    $listEmployeeName = new Array();
                    @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                    $listEmployeeID.push({{$allEmployeeInTeam->id}});
                    $listEmployeeName.push('{{$allEmployeeInTeam->name}}');
                    @endforeach
                        $idPO = "";
                    $namePO = "";
                </script>
                <script type="text/javascript">
                    function addFunction() {
                        $id = document.getElementById("member").value;
                        if ($id != 0) {
                            if ($listEmployeeID.length == 0) {
                                $listEmployeeID[0] = document.getElementById("member").value;
                                $listEmployeeName[0] = $("#member_" + $id).text();
                            } else {
                                $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                                $listEmployeeName[$listEmployeeName.length] = $("#member_" + $id).text();
                            }
                            $listAdd = "";
                            for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                $listAdd += "<li  id=\"show_" + $listEmployeeID[$i] + "\"><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"  onclick=\"removeEmployee(" + $listEmployeeID[$i] + ",\'" + $listEmployeeName[$i] + "\')\"></i><label>ID:" + $listEmployeeID[$i] + "</label><label>" + $listEmployeeName[$i] + "</label></a></li>";
                            }
                            $listChoose = "";
                            for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                $listChoose += "<input type=\"text\" name=\"employee[]\" id=\"employee\" value=\"" + $listEmployeeID[$i] + "\" class=\"form-control width80 input_" + $listEmployeeID[$i] + "\">";
                            }
                            document.getElementById("contextMenuTeam").innerHTML = $listAdd;
                            document.getElementById("listChoose").innerHTML = $listChoose;
                            $('option').remove('#member_' + $id);
                            $('option').remove('#po_' + $id);
                        }
                    }
                </script>
                <script type="text/javascript">
                    function removeEmployee($id, $name) {
                        $('li').remove('#show_' + $id);
                        $('input').remove('.input_' + $id);
                        $listEmployeeID.splice($listEmployeeID.indexOf($id), 1);
                        $listEmployeeName.splice($listEmployeeName.indexOf($name), 1);

                        $option = document.createElement("option");
                        $option.value = $id;
                        $option.text = $name;
                        $option.id = "member_" + $id;
                        $select = document.getElementById('member');
                        $select.appendChild($option);

                        $option1 = document.createElement("option");
                        $option1.value = $id;
                        $option1.text = $name;
                        $option1.id = "po_" + $id;
                        $select1 = document.getElementById('select_po_name');
                        $select1.appendChild($option1);
                    }
                </script>
                <script type="text/javascript">
                    function choosePO() {
                        if ($idPO == "") {
                            $idPO = document.getElementById("select_po_name").value;
                            $namePO = $("#po_" + $idPO).text();
                        } else {
                            $option = document.createElement("option");
                            if ($idPO != 0) {
                                $option.value = $idPO;
                                $option.text = $namePO;
                                $option.id = "member_" + $idPO;
                                $select = document.getElementById('member');
                                $select.appendChild($option);
                            }
                            $idPO = document.getElementById("select_po_name").value;
                            $namePO = $("#po_" + $idPO).text();
                        }
                        $id = document.getElementById("select_po_name").value;
                        $('option').remove('#member_' + $id);
                    }
                </script>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>

    <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function () {
            $("#btn_reset_form_team").bind("click", function () {
                var select_po = $('#select_po_name');
                select_po.val('0');
                var select_members = $("#member");
                select_members.val('0');
                $("#team_name").val('');

                var eId = $("li.listInTeam").data('employee-id');

                /*$("#contextMenuTeam").html(function () {

                    }
                );*/
                $("#contextMenuTeam").remove();
                $("#listChoose").remove();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#edit_id").blur(function () {
                var name = $(this).val();
                $.get("/checkTeamNameEdit", {name: name}, function (data) {
                    console.log(data);
                    $("#name_error").html(data);
                });
            });
        });
    </script>
@endsection