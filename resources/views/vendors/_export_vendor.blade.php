<?php
$id = null;
$name = null;
$company = null;
$role = null;
$email = null;
$status = -1;
$page = 1;
$arrays[] = request();
/*if (!empty($arrays)){
    dd('aaa');
}
else{
    dd($arrays);
}*/
foreach ($arrays as $key => $value) {
    if (!empty($value['page'])) {
        $page = $value['page'];
    }
    if (!empty($value['id'])) {
        $id = $value['id'];
    }
    if (!empty($value['name'])) {
        $name = $value['name'];
    }
    if (!empty($value['company'])) {
        $company = $value['company'];
    }
    if (!empty($value['role'])) {
        $role = $value['role'];
    }
    if (!empty($value['email'])) {
        $email = $value['email'];
    }
    if (is_null($value['status'])) {
        $status = "";
    } else {
        $status = $value['status'];
    }
    /*dd($status);
    if (!empty($value['status'])) {

    }
    else{
        $status = null;
    }*/
}
?>

<SCRIPT LANGUAGE="JavaScript">
    function confirmExport(msg) {
        $check = confirm(msg);
        if($check == true){
            $(document).ready(function (){
                var ctx = document.getElementById('my_canvas').getContext('2d');
                var al = 0;
                var start = 4.72;
                var cw = ctx.canvas.width;
                var ch = ctx.canvas.height;
                var diff;
                function runTime() {
                    diff = ((al / 100) * Math.PI*0.2*10).toFixed(2);
                    ctx.clearRect(0, 0, cw, ch);
                    ctx.lineWidth = 3;
                    ctx.fillStyle = '#09F';
                    ctx.strokeStyle = "#09F";
                    ctx.textAlign = 'center';
                    ctx.beginPath();
                    ctx.arc(10, 10, 5, start, diff/1+start, false);
                    ctx.stroke();
                    if (al >= 100) {
                        clearTimeout(sim);
                        sim = null;
                        al=0;
                        $("#contain-canvas").css("visibility","hidden")
                        // Add scripting here that will run when progress completes
                    }
                    al++;
                }
                var sim = null;
                $("i.fa fa-vcard").css("visibility","hidden")
                $("#contain-canvas").css("visibility","visible")
                sim = setInterval(runTime, 5 );

            });
        }
        return $check;
    }
</SCRIPT>

<button type="button" class="btn btn-default export-employee" id="click-here" onclick="return confirmExport('{{trans('vendor.msg_content.msg_download_vendor_list')}}')">
    <a id="export"
       href="{{asset('/vendors/export').'?'.'id='.$id.'&name='.$name.'&company='.$company.'&email='.$email.'&role='.$role.
                '&email='.$email.'&status='.$status.'&page='.$page}}">
        <i class="fa fa-vcard"></i>
        <span id="contain-canvas" style="">
            <canvas id="my_canvas" width="16" height="16" style=""></canvas>
        </span>
        {{trans('vendor.export')}}</a>
</button>
