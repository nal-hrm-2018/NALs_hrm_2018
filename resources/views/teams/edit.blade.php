@extends('admin.template')
@section('content')
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
                    {{ Form::model($teamById, ['url' => ['/team', $teamById["id"]],'class' => 'form-horizontal','method'=>isset($teamById["id"])?'PUT':'POST', 'onreset' => 'return confirmAction("Do you want to reset?")', 'onSubmit' => 'return confirmAction("Would you like to edit it?")'])}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <!-- /.col -->
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Team name</label>
                                    <input type="text" class="form-control width80" placeholder="Team name"
                                           name="team_name"
                                           value="{!! old('name', isset($teamById["name"]) ? $teamById["name"] : null) !!}"
                                           @if(\Illuminate\Support\Facades\Auth::user()->email != $onlyValue)
                                           readonly="readonly"
                                            @endif>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>PO name</label><br/>
                                    <select class="form-control select2 width80" name="po_name">
                                        <option>---PO name---</option>
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
                                        <option value="0" id="member_0">---Member---</option>
                                        <?php
                                        foreach ($allEmployees as $allEmployee){
                                            echo '<option value="'.$allEmployee["id"].'" id="member_'.$allEmployee["id"].'">'.$allEmployee["name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <button type="button" class="btn btn-default buttonAdd">
                                        <a onclick="addFunction()"><i class="fa fa-user-plus"></i> ADD</a>
                                    </button>
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
                                    <input type="reset" value="Reset" class="btn btn-info pull-left">
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
                      function addFunction(){
                        $id = document.getElementById("member").value;
                        if($listEmployeeID == null){
                          $listEmployeeID[0] = document.getElementById("member").value;
                          $listEmployeeName[0] = $("#member_"+$id).text();
                        }else{
                          $listEmployeeID[$listEmployeeID.length] = document.getElementById("member").value;
                          $listEmployeeName[$listEmployeeName.length] = $("#member_"+$id).text();
                        }
                        $listAdd = "";
                        for($i = 0; $i < $listEmployeeID.length; $i++){
                          $listAdd += "<li  id=\"show_"+$listEmployeeID[$i]+"\"><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"  onclick=\"removeEmployee("+$listEmployeeID[$i]+")\"></i><label>ID:"+$listEmployeeID[$i]+"</label><label>"+$listEmployeeName[$i]+"</label></a></li>";
                        }
                        $listChoose = "";
                        for($i = 0; $i < $listEmployeeID.length; $i++){
                          $listChoose += "<input type=\"text\" name=\"employee\" id=\"employee\" value=\""+$listEmployeeID[$i]+"\" class=\"form-control width80 input_"+$listEmployeeID[$i]+"\">";
                        }
                        document.getElementById("contextMenuTeam").innerHTML = $listAdd;
                        document.getElementById("listChoose").innerHTML = $listChoose;
                        $('option').remove('#member_'+$id);
                      }
                    </script>
                    <script type="text/javascript">
                      function removeEmployee($id){
                        $('li').remove('#show_'+$id);
                        $('input').remove('.input_'+$id);
                        $listEmployeeID.splice($listEmployeeID.indexOf($id),1);
                        $listEmployeeName.splice($listEmployeeName.indexOf($id),1);
                        
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
@endsection