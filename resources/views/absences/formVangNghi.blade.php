@extends('admin.template')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <strong>Phiếu Vắng Nghỉ</strong>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/absences">Vắng nghỉ</a></li>
        <li class="active">Phiếu vắng nghỉ</li>
      </ol>
    </section>
    <style type="text/css">
      .form-horizontal .form-group {
        margin-right: 0px;
      }
    </style>
    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-body">

          <div id="msg">
          </div>
          <SCRIPT LANGUAGE="JavaScript">
              function confirmAction() {
                  var name = $('#name').val();
                  var id = $('#id_employee').val();
                  return confirm(message_confirm('create', 'absences', id, name));
              }
          </SCRIPT>
          <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
          <div class="row">
            {{--{{ Form::model($objEmployee, ['url' => ['/absences', $objEmployee["id"]],
                                          'class' => 'form-horizontal',
                                          'method'=>isset($objEmployee["id"])?'PUT':'POST',
                                          'onSubmit' => 'return confirmEmployee()'])}}--}}
            <form action="{{asset('absences/create')}}" method="post" class="form-horizontal">
            <form class="fullwidth" action="{{asset('absences')}}" method="post" class="form-horizontal"
                  onSubmit="return confirmAction()">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>
            <div class="row">
              <div class="col-md-8"></div>
              <!-- /.col -->
              <div class="col-md-4">
                <!-- /.form-group -->
                <div class="form-group addab">
                  <label>Địa chỉ email<strong style="color: red">(*)</strong></label>
                  <input type="text" class="form-control" placeholder="Email Address" name="email" id="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}" readonly="readonly" />
                  <!-- /.input group -->
                </div>
              <div class="form-group addab">
                <label>Họ Tên<strong style="color: red">(*)</strong></label>
                <input type="text" class="form-control" placeholder="Name"  name="name" id="name" readonly="readonly" value="{!! old('name', isset($objEmployee->name) ? $objEmployee->name : null) !!}">
                <!-- /.input group -->
              </div>
                

                <div class="form-group addab">
                  <label>Team<strong style="color: red">(*)</strong></label>
                  @php
                    $arr_team = $objEmployee->teams()->get();
                    $string_team ="";
                    foreach ($arr_team as $team){
                      $addteam=  (string)$team->name;
                      if ($string_team){
                      $string_team = $string_team.", ".$addteam;
                      } else{
                      $string_team = $string_team."".$addteam;
                      }
                    }
                  @endphp
                  <input type="text" readonly="readonly" class="form-control" placeholder="Team Name"  name="team_name" id="team_name" value="{{isset($string_team)? $string_team: Null}}">
                  <!-- /.input group -->
                </div>
                {{--<div class="form-group">--}}
                  {{--<label>PO Project<strong style="color: red">(*)</strong></label>--}}
                  {{--@if($objPO!=null)--}}
                    {{--@foreach($objPO as $PO)--}}
                      {{--<input type="text" readonly="readonly" class="form-control" placeholder="Po Name"  name="Po_Name" id="Po_Name" value="{{isset($PO["PO_name"]) ? $PO["PO_name"] : null}}{{isset($PO["project_name"])  ? '  -  PROJECT: '.$PO["project_name"] : null}} ">--}}
                    {{--@endforeach--}}
                  {{--@else--}}
                    {{--<input type="text" readonly="readonly" class="form-control" placeholder="Po Name"  name="Po_Name" id="Po_Name" value="">--}}
                  {{--@endif--}}
                {{--</div>--}}

                <div class="form-group addab">
                  <label>Nghỉ từ ngày<strong style="color: red">(*)</strong></label><br />
                  <div class='input-group date form_datetime'>
                    <input name="from_date" type='datetime-local' value="{!! old('from_date') !!}" class="form-control" placeholder=""/>
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                  </div>
                  <label id="lb_error_from_date" style="color: red;">{{$errors->first('from_date')}}</label>
                  <!-- /.input group -->
                </div>

                <div class="form-group addab">
                  <label>Đến ngày<strong style="color: red">(*)</strong></label><br />
                  <div class='input-group date form_datetime'>
                    <input name="to_date" type='datetime-local' class="form-control" value="{!! old('to_date') !!}" placeholder="yyyy-MM-dd HH:mm"/>
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                  </div>
                  <label id="lb_error_to_date" style="color: red;">{{$errors->first('to_date')}}</label>
                  <!-- /.input group -->
                </div>

                <div class="form-group addab">
                  <label>Loại nghỉ phép<strong style="color: red">(*)</strong></label>
                  <select class="form-control select2" style="width: 100%;"  name="absence_type_id" id="absence_type_id">
                    <option value="" >---Chọn---</option>
                      <?php
                      foreach ($Absence_type as $val) {
                          $selected = "";
                          $name="";
                          if($val["name"]!="subtract_salary_date"){
                              if ($val["id"] == old('absence_type_id')) {
                                  $selected = "selected";
                              }
                              if (isset($Absence_employee)) {
                                  if ($absences->absence_type_id == $val["id"]) {
                                      $selected = "selected";
                                  }
                              }
                              if ($val["name"]=='non_salary_date'){
                                  echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ không lương' . '</option>';
                              }
                              if ($val["name"]=='insurance_date'){
                                  echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ theo bảo hiểm' . '</option>';
                              }
                              if ($val["name"]=='salary_date'){
                                  echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ có lương' . '</option>';
                              }

                          }

                      }
                      ?>
                  </select>
                  <label id="lb_error_absence_type_id" style="color: red; ">{{$errors->first('absence_type_id')}}</label>
                </div>

                <div class="form-group addab">
                  <label>Lý do<strong style="color: red">(*)</strong></label>
                  <input type="text" class="form-control" placeholder="Câu trả lời của bạn" value="{!! old('reason') !!}"  name="reason" id="ly_do">
                  <label id="lb_error_reason" style="color: red;">{{$errors->first('reason')}}</label>
                  <!-- /.input group -->
                </div>

                <div class="form-group addab">
                  <label>Ghi chú</label>
                  <input type="text" class="form-control" placeholder="Câu trả lời của bạn"{!! old('ghi_chu') !!}  name="ghi_chu" id="ghi_chu">
                  <!-- /.input group -->
                </div>

                <div class="row">
                  <br />
                  <div class="col-md-4" style="margin-left: 100px;">
                    <button type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
                      RESET
                    </button>
                    <button type="submit" class="btn btn-primary">
                      SAVE
                    </button>
                  </div>
                </div>
              </div>
              <!-- /.form-group -->
              {{--{{ Form::close() }}--}}
            </div>

            </form>

          </div>
          <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <script type="text/javascript"
              src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script>
          $(function () {
              $("#btn_reset_form_employee").bind("click", function () {
                  if(confirmAction("Do you want to reset?"))
                      location.reload();
              });
          });
      </script>

      <script type="text/javascript">
          $(function () {
              $('.form_datetime').datetimepicker({
                  weekStart: 1,
                  todayBtn:  1,
                  autoclose: 1,
                  todayHighlight: 1,
                  startView: 2,
                  forceParse: 0,
                  showMeridian: 1});
          });
      </script>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>


@endsection