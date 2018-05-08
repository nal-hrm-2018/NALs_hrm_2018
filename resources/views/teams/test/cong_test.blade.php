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
                    <form action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <!-- /.col -->
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Team name</label>
                                    <input type="text" class="form-control width80" placeholder="Team name" name="team_name" value="">
                                    <label style="color: red;"></label>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>PO name</label><br />
                                    <select class="form-control select2 width80" name="po_name">
                                        <option>---PO name---</option>
                                        <option>Nguyễn Văn A</option>
                                        <option>Nguyễn Văn B</option>
                                        <option>Nguyễn Văn C</option>
                                        <option>Nguyễn Văn D</option>
                                        <option>Lê Văn A</option>
                                        <option>Hoàng Văn A</option>
                                        <option>Bùi Văn A</option>
                                        <option>Đại Văn A</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Member</label><br />
                                    <select class="form-control select2 width80" name="member" id="member">
                                        <option value="0" id="member_0">---Member---</option>
                                        <option value="1" id="member_1">Nguyễn Văn A</option>
                                        <option value="2" id="member_2">Nguyễn Văn B</option>
                                        <option value="3" id="member_3">Nguyễn Văn C</option>
                                        <option value="4" id="member_4">Nguyễn Văn D</option>
                                        <option value="5" id="member_5">Lê Văn A</option>
                                        <option value="6" id="member_6">Hoàng Văn A</option>
                                        <option value="7" id="member_7">Bùi Văn A</option>
                                        <option value="8" id="member_8">Đại Văn A</option>
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
                                <div style="float: right;" >
                                    <input type="reset" value="Reset" class="btn btn-info pull-left">
                                </div>
                            </div>
                            <div class="col-md-1" style="display: inline;">
                                <div style="float: right;">
                                    <button type="submit" class="btn btn-info pull-left">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                $listAdd += "<li><a class=\"btn-employee-remove\"><i class=\"fa fa-remove\"></i><label>ID:"+$listEmployeeID[$i]+"</label><label>"+$listEmployeeName[$i]+"</label></a></li>";
                            }
                            $listChoose = "";
                            for($i = 0; $i < $listEmployeeID.length; $i++){
                                $listChoose += "<input type=\"text\" name=\"employee\" id=\"employee\" value=\""+$listEmployeeID[$i]+"\" class=\"form-control width80\">";
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