@extends('admin.template')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{trans('leftbar.nav.add.absence')}}
        <small>NAL Solutions</small>
      </h1>
      {{--<ol class="breadcrumb">--}}
        {{--<li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="/absences">Vắng nghỉ</a></li>--}}
        {{--<li class="active">Phiếu vắng nghỉ</li>--}}
      {{--</ol>--}}
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
              <form action="{{asset('absences')}}" method="post" class="form-horizontal"
                    onSubmit="return confirmAction()">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="id_employee" value="{{$objEmployee["id"]}}"/>
            <div class="row">
              <div class="col-md-1"></div>
              <!-- /.col -->
              <div class="col-md-4">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Địa chỉ email<strong style="color: red">(*)</strong></label>
                  <input type="text" class="form-control" placeholder="Email Address" name="email" id="email" value="{!! old('email', isset($objEmployee["email"]) ? $objEmployee["email"] : null) !!}" readonly="readonly" />
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Họ Tên<strong style="color: red">(*)</strong></label>
                  <input type="text" class="form-control" placeholder="Name"  name="name" id="name" readonly="readonly" value="{!! old('name', isset($objEmployee->name) ? $objEmployee->name : null) !!}">
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
                <div class="form-group">
                  <label>Nghỉ từ ngày<strong style="color: red">(*)</strong></label><br />
                  <div class='input-group date' id='datetimepicker1'>
                    <input name="from_date" type='text' value="{!! old('from_date') !!}" class="form-control" readonly placeholder="From Date"  style="background: white;"/>
                    <span class="input-group-addon">
                      <span class="fa fa-calendar">
                    </span>
                  </div>
                  <label id="lb_error_from_date" style="color: red;">{{$errors->first('from_date')}}</label>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Đến ngày<strong style="color: red">(*)</strong></label><br />
                  <div class='input-group date' id='datetimepicker2'>
                    <input name="to_date" type='text' class="form-control" value="{!! old('to_date') !!}" readonly placeholder="To Date" style="background: white;"/>
                    <span class="input-group-addon">
                      <span class="fa fa-calendar">
                    </span>
                  </div>
                  <label id="lb_error_to_date" style="color: red;">{{$errors->first('to_date')}}</label>
                  <!-- /.input group -->
                </div>
                
              </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                  <div class="form-group">
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
                <div class="form-group">
                  <label>Ghi chú</label>
                  <input type="text" class="form-control" placeholder="Câu trả lời của bạn"{!! old('ghi_chu') !!}  name="ghi_chu" id="ghi_chu">
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Lý do<strong style="color: red">(*)</strong></label>
                  <input type="text" class="form-control" placeholder="Câu trả lời của bạn" value="{!! old('reason') !!}"  name="reason" id="ly_do">
                  <label id="lb_error_reason" style="color: red;">{{$errors->first('reason')}}</label>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Loại thời gian<strong style="color: red">(*)</strong></label>
                  <select class="form-control" style="width: 100%;"  name="absence_tỉme_id" id="absence_time_id">
                    <option value="" >Chọn</option>
                    <?php
                      foreach ($Absence_time as $val) {
                        $selected = "";
                        $name="";
                        if ($val["id"] == old('absence_time_id')) {
                            $selected = "selected";
                        }
                        if ($val["name"]=='all'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ cả ngày' . '</option>';
                        }
                        if ($val["name"]=='morning'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ buổi sáng' . '</option>';
                        }
                        if ($val["name"]=='afternoon'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ buổi chiều' . '</option>';
                        }
                      }
                    ?>
                  </select>
                  <label id="lb_error_absence_type_id" style="color: red; ">{{$errors->first('absence_type_id')}}</label>
                </div>
                <div class="form-group">
                  <label>Loại nghỉ phép<strong style="color: red">(*)</strong></label>
                  <select class="form-control" style="width: 100%;"  name="absence_type_id" id="absence_type_id">
                    <option value="" >Chọn</option>
                    <?php
                      foreach ($Absence_type as $val) {
                        $selected = "";
                        $name="";
                        if ($val["id"] == old('absence_type_id')) {
                            $selected = "selected";
                        }
                        if (isset($Absence_employee)) {
                            if ($absences->absence_type_id == $val["id"]) {
                                $selected = "selected";
                            }
                        }
                        if ($val["name"]=='unpaid_leave'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ không lương' . '</option>';
                        }
                        if ($val["name"]=='annual_leave'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ phép năm' . '</option>';
                        }
                        if ($val["name"]=='maternity_leave'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ thai sản' . '</option>';
                        }
                        if ($val["name"]=='marriage_leave'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ cưới' . '</option>';
                        }
                        if ($val["name"]=='maternity_leave'){
                            echo '<option value="' . $val["id"] . '" ' . $selected . '>' . 'Nghỉ tang' . '</option>';
                        }
                      }
                    ?>
                  </select>
                  <label id="lb_error_absence_type_id" style="color: red; ">{{$errors->first('absence_type_id')}}</label>
                </div>
              </div>
              <!-- /.form-group -->
              
            </div>
            <div class="row">
              <div class="col-md-6" style="display: inline;">
                <div style="float: right;">
                  <button type="reset" class="btn btn-default"><span class="fa fa-refresh"></span>
                    {{ trans('common.button.reset')}}
                  </button>
                </div>
              </div>
              <div class="col-md-1" style="display: inline;">
                <div>
                  <button type="submit" class="btn btn-info">
                    {{ trans('common.button.add')}}
                  </button>
                </div>
              </div>
            </div>
            {{--{{ Form::close() }}--}}
            </form>
          </div>
          <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <script type="text/javascript"
              src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script type="text/javascript">
          $(function () {
              $('#datetimepicker1').datepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1});
          });
          $(function () {
              $('#datetimepicker2').datepicker({
                  weekStart: 1,
                  todayBtn:  1,
                  autoclose: 1,
                  todayHighlight: 1});
          });
      </script>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>


@endsection