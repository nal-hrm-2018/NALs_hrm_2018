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
            margin-left: 150px;
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
                    {{Form::model($teamById,array('url' => ['/teams', $teamById['id']], 'method' => 'PUT'))}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <!-- /.col -->
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Team name</label>
                                    <input type="text" class="form-control width80" id="edit_id" placeholder="Team name"
                                           name="team_name"
                                           value="{!! old('name', isset($teamById["name"]) ? $teamById["name"] : null) !!}"
                                           @if(\Illuminate\Support\Facades\Auth::user()->email != $onlyValue)
                                           readonly="readonly"
                                            @endif>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group" id="name_error" style="color: red; width: 150px;"></div>
                                <div class="form-group">
                                    <label>PO name</label><br/>
                                    <select class="form-control select2 width80" id="select_po_name" name="po_name">
                                        @if(!empty($nameEmployee))
                                            <option selected="selected" {{'hidden'}}  value="">
                                                {{$nameEmployee}}
                                            </option>
                                        @else
                                            <option selected="selected"
                                                    value="">
                                                {{  trans('employee.drop_box.placeholder-default') }}
                                                @endif
                                            </option>
                                        <?php
                                        foreach ($allEmployees as $allEmployee){
                                            echo '<option value="'.$allEmployee["id"].'">'.$allEmployee["name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Member</label><br/>
                                    <select class="form-control select2 width80" name="member" id="member">
                                        <option value="" id="member_0">---Member---</option>
                                        <?php
                                        foreach ($allEmployees as $allEmployee){
                                            echo '<option id="edit_'.$allEmployee["id"].'" value="'.$allEmployee["id"].'">'.$allEmployee["name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <button type="button" class="btn btn-default buttonAdd">
                                        <a onclick="addFunction()"><i class="fa fa-user-plus"></i> ADD</a>
                                    </button>
                                </div>
                                <div class="form-group" id="listInTeam">
                                    <ul class="contextMenuEmployeeInTeam" id="contextMenuEmployeeInTeam">
                                        @foreach($allEmployeeInTeams as $allEmployeeInTeam)
                                            <li class="removeLiEmployee" data-employee-id="{{$allEmployeeInTeam->id}}" >
                                                <span data-employee-id="{{$allEmployeeInTeam->id}}" class="remove-employee fa fa-remove"></span>
                                                <input type="text" name="employee_in_team[{{$allEmployeeInTeam->id}}]" value="{{$allEmployeeInTeam->id." ".$allEmployeeInTeam->name}}" readonly="readonly"
                                                style="border: 0px;">

                                            </li>
                                        @endforeach
                                    </ul>
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
                                    <button type="reset" class="btn btn-default"><span class="fa fa-refresh"></span>
                                        RESET
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1" style="display: inline;">
                                <div style="float: right;">
                                    <button type="submit" class="btn btn-info pull-left">Save</button>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                        <script type="text/javascript">
                            $listEmployeeID = new Array();
                            $listEmployeeName = new Array();
                        </script>
                        <script type="text/javascript">
                            function addFunction() {
                                $id = document.getElementById("member").value;
                                if ($listEmployeeID == null) {
                                    $listEmployeeID[0] = document.getElementById("member").value;
                                    $listEmployeeName[0] = $("#member_" + $id).text();
                                } else {
                                    $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                                    $listEmployeeName[$listEmployeeName.length] = $("#member_" + $id).text();
                                }
                                $listAdd = "";
                                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                    $listAdd += "<li><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"></i><label>ID:" + $listEmployeeID[$i] + "</label><label>" + $listEmployeeName[$i] + "</label></a></li>";
                                }
                                $listChoose = "";
                                for ($i = 0; $i < $listEmployeeID.length; $i++) {
                                    $listChoose += "<input type=\"text\" name=\"employee_in_team[]\" id=\"employee\" value=\"" + $listEmployeeID[$i] + "\" class=\"form-control width80\">";
                                }

                                document.getElementById("contextMenuTeam").innerHTML = $listAdd;
                                document.getElementById("listChoose").innerHTML = $listChoose;
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

    <script src="{!! asset('admin/templates/js/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.remove-employee').click(function () {
                var eId = $(this).data('employee-id');
                $('li.removeLiEmployee[data-employee-id="' + eId + '"').remove();
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#btn_reset").bind("click", function () {
                $("#select_po_name").val([]);
                $("#select_po_name")[0].selectedIndex = 0;
                $("#member").val([]);
                $("#member")[0].selectedIndex = 0;
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#edit_id").blur(function(){
                var name = $(this).val();
                $.get("/checkTeamNameEdit",{name:name},function(data){
                    console.log(data);
                    $("#name_error").html(data);
                });
            });
        });
    </script>
@endsection