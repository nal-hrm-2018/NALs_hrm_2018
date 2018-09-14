@extends('admin.template')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <strong>Phiếu Vắng Nghỉ</strong>
      <small>NAL Solutions</small>
    </h1>
    {{--<ol class="breadcrumb">--}}
      {{--<li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>--}}
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
        {{--<SCRIPT LANGUAGE="JavaScript">--}}
              {{--function confirmAction() {--}}
                  {{--var name = $('#name').val();--}}
                  {{--var id = $('#id_employee').val();--}}
                  {{--return confirm(message_confirm('edit', 'absences', id, name));--}}
              {{--}--}}
          {{--</SCRIPT>--}}
        <div class="col-md-10" style="width: 100% ; margin-bottom: 2em"></div>
        <div class="row">
          {{Form::model($objAbsence,array('url' => ['/absences', $objAbsence->id],
          'method'=>isset($objAbsence->id)?'PUT':'POST', 'id' => 'form_edit_absences','class' => 'form-horizontal'))}}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="id_employee" value="{{$objAbsence->employee->id}}" />
          <!-- /.col -->
          <div class="col-md-4">
            <!-- /.form-group -->
            <div class="form-group">
              <label>{{trans('absence_po.list_po.profile_info.email')}}<strong style="color: red">(*)</strong></label>
              <input type="text" class="form-control" placeholder="Email Address" name="email" id="email" value="{!! old('email', isset($objAbsence->employee->email) ? $objAbsence->employee->email : null) !!}"
                readonly="readonly" />
              <!-- /.input group -->
            </div>

            <div class="form-group">
              <label>{{trans('absence_po.list_po.profile_info.name')}}<strong style="color: red">(*)</strong></label>
              <input type="text" class="form-control" placeholder="Name" name="name" id="name" readonly="readonly"
                value="{!! old('name', isset($objAbsence->employee->name) ? $objAbsence->employee->name : null) !!}">
              <!-- /.input group -->
            </div>
            <div class="form-group">
              <label>{{trans('absence_po.list_po.profile_info.start_date')}}<strong style="color: red">(*)</strong></label><br />
              <div class='input-group date' id='datetimepicker1'>
                <input name="from_date" type='text' value="{!! old('from_date', $objAbsence->from_date->format('m/d/Y')) !!}"
                  class="form-control" readonly placeholder="From Date" style="background: white;" />
                <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </div>
              <label id="lb_error_from_date" style="color: red;">{{$errors->first('from_date')}}</label>
              <!-- /.input group -->
            </div>

            <div class="form-group">
              <label>{{trans('absence_po.list_po.profile_info.end_date')}}<strong style="color: red">(*)</strong></label><br />
              <div class='input-group date' id='datetimepicker2'>
                <input name="to_date" type='text' class="form-control" value="{!! old('to_date', $objAbsence->to_date->format('m/d/Y')) !!}"
                  readonly placeholder="To Date" style="background: white;" />
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
              <label>{{trans('absence_po.list_po.profile_info.note')}}</label>
              <input type="text" class="form-control" placeholder="Câu trả lời của bạn" value="{!! old('ghi_chu',isset($objAbsence->description) ? $objAbsence->description : null) !!}"
                name="ghi_chu" id="ghi_chu">
              <!-- /.input group -->
            </div>

            <div class="form-group">
              <label>Lý do<strong style="color: red">(*)</strong></label>
              <input type="text" class="form-control" placeholder="Câu trả lời của bạn" value="{!! old('reason', $objAbsence->reason ) !!}"
                name="reason" id="ly_do">
              <label id="lb_error_reason" style="color: red;">{{$errors->first('reason')}}</label>
              <!-- /.input group -->
            </div>

            <div class="form-group">
              <label>Loại thời gian<strong style="color: red">(*)</strong></label>
              <select class="form-control" style="width: 100%;" name="absence_time_id" id="absence_time_id">
                <?php
                    foreach ($Absence_time as $val) {
                      $selected = "";
                      $name="";
                      if ($val["id"] == $objAbsence->absence_time_id) {
                        $selected = "selected";
                      }
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
              <label id="lb_error_absence_time_id" style="color: red; ">{{$errors->first('absence_time_id')}}</label>
            </div>

            <div class="form-group">
              <label>Loại nghỉ phép<strong style="color: red">(*)</strong></label>
              <select class="form-control" style="width: 100%;" name="absence_type_id" id="absence_type_id">
                <?php
                    foreach ($Absence_type as $val) {
                      $selected = "";
                      $name="";
                      if ($val["id"] == $objAbsence->absence_type_id) {
                        $selected = "selected";
                      }
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
        </div>
        <div class="row">
          <br />
          <div class="col-md-3" style="margin-left: 100px;">
            <button type="reset" id="btn_reset_form_employee" class="btn btn-default"><span class="fa fa-refresh"></span>
              LÀM MỚI
            </button>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">
              SỬA
            </button>
          </div>
        </div>
      </div>
      <!-- /.form-group -->
      {{ Form::close() }}
      {{--</form>--}}
    </div>
    <div class="col-md-12" style="width: 100% ; margin-top: 2em"></div>
</div>
<!-- /.box-body -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('#datetimepicker1').datepicker({
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1
    });
  });
  $(function () {
    $('#datetimepicker2').datepicker({
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1
    });
  });
</script>
<!-- /.box -->
</section>
<!-- /.content -->
</div>


@endsection