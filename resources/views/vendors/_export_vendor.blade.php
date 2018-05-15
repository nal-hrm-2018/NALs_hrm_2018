<?php
$id = null; $name = null; $company = null; $role = null; $email = null; $status = -1;
$arrays[] = request();
/*if (!empty($arrays)){
    dd('aaa');
}
else{
    dd($arrays);
}*/
foreach ($arrays as $key => $value) {
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
    if (is_null($value['status'])){
        $status = "";
    }else{
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
<script type="text/javascript">
    function clickExport() {
        return confirm("Are you sure?")
    }
</script>

<button type="button" class="btn btn-default export-employee" onclick="return clickExport()">
    <a id="export"
       href="{{asset('/vendors/export').'?'.'id='.$id.'&name='.$name.'&company='.$company.'&email='.$email.'&role='.$role.'&email='.$email.'&status='.$status}}">
        <i class="fa fa-vcard"></i> EXPORT</a>
</button>