<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

<button type="button" class="btn btn-default export-employee" id="export_absence_hr">
    <a id="export"
       href="{{route('export-absences-hr',isset($param)?$param:'')}}">
        <i class="fa fa-vcard"></i>
        <span id="contain-canvas" style="">
            <canvas id="my_canvas" width="16" height="16" style=""></canvas>
        </span>
        {{trans('common.button.export')}}</a>
</button>
