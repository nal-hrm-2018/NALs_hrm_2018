<?php
namespace App\Import;

use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\EmployeeType;
use App\Export\TemplateExport;
use DateTime;
class ImportFile{

	public function readFile($url){
		$i = 0;
        $dataEmployees = array();
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
                $dataEmployees[$i] = $data[$c];
                $i++;
            }
        }
        fclose($handle);
        return $dataEmployees;
	}

	public function countCol($url){
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            break;
        }
        fclose($handle);
        return $num;
	}

    public function checkCol($url, $countNum){
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $col = count($data);
            break;
        }
        fclose($handle);
       
        $rowError = "";
        if($col != $countNum){
            $rowError .= "<li>".trans('importFile.import_file.check_col.invalid')."</li>";
        }
        $num = 1;
        
        $i = 0;
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if($num > 1){
                $numCol = count($data);
                if($numCol > $countNum){
                    $rowError .= "<li>".trans('importFile.import_file.check_col.row')." ".$num."".trans('importFile.import_file.check_col.has')." ".($numCol - $countNum)." ".trans('importFile.import_file.check_col.column')."</li>";
                    $i++;
                }else if($numCol < $countNum){
                    $rowError .= "<li>".trans('importFile.import_file.check_col.row')." ".$num." ".trans('importFile.import_file.check_col.missing')." ".($countNum - $numCol)." ".trans('importFile.import_file.check_col.column')."</li>";
                    $i++;
                }
            }
            
            $num++;
        }
        fclose($handle);
        return $rowError;
    }
	public function checkEmail($dataEmployees, $row, $num){
		$dataEmail = array();
        $dem = 0;
        $listError ="";
        for($i = 1; $i < $row -1; $i++){
            if($dataEmail == null){
                for($j = $i+1; $j < $row; $j++){
                    if($dataEmployees[$i*$num] == $dataEmployees[$j*$num]){
                        $listError .= "<li>".trans('vendor.profile_info.email')." ".$dataEmployees[$i*$num]." ".trans('importFile.import_file.check_Email.repeated')."</li>";
                        $dataEmail[$dem] = $dataEmployees[$i*$num];
                        $dem++;
                        break;
                    }
                }
            }else{
                $check = 0;
                for ($k=0; $k < $dem; $k++) { 
                    if($dataEmail[$k] == $dataEmployees[$i*$num]){
                        $check = 1;
                    }
                } 
                if($check == 0){
                    for($j = $i+1; $j < $row; $j++){
                        if($dataEmployees[$i*$num] == $dataEmployees[$j*$num]){
                            $listError .= "<li>".trans('vendor.profile_info.email')." ".$dataEmployees[$i*$num]." ".trans('importFile.import_file.check_Email.repeated')."</li>";
                            $dataEmail[$dem] = $dataEmployees[$i*$num];
                            $dem++;
                            break;
                        }
                    }
                }
            }
        }
        return $listError;
	}
	public function checkFileEmployee($data, $num){
		$listError ="";
        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
		for ( $row = 1; $row < count($data)/$num; $row++) {
			$c = $row*$num;
			if($c < $row*($num+1)){
                if($data[$c] == null){
                    $listError .= "<li>".trans('vendor.profile_info.email')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.email_required')."</li>";
                }else{                        
                    $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                    if($objEmployee != null){
                        $listError .= "<li>".trans('vendor.profile_info.email')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.email_exist')."</li>";
                    }else{
                        $partten = "/^[A-Za-z0-9_\.]{1,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/";
                        if(!preg_match($partten ,$data[$c], $matchs)){
                            $listError .= "<li>".trans('vendor.profile_info.email')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.email_valid')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.name_required')."</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_format')."</li>";
                        }else{
                            if(strtotime($data[$c]) >= strtotime($date)){
                                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_before')."</li>";
                                }
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.gender_required')."</li>";
                }else{
                    if(strnatcasecmp($data[$c], "FEMALE") != 0 && strnatcasecmp($data[$c], "MALE") != 0 && strnatcasecmp($data[$c], "N/A") != 0){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.gender_values')."</li>";
                    }
                }

                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.mobile_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        $stMb = $data[$c];
                        for($k=0; $k < strlen($data[$c]); $k++){
                            if( $stMb[$k] < "0" || $stMb[$k] > "9" ){
                                $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.mobile_number')."</li>";
                                break;
                            }
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.address_required')."</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.marital_status_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(strnatcasecmp($data[$c], "single") != 0 && strnatcasecmp($data[$c], "married") != 0 && strnatcasecmp($data[$c], "separated") != 0 && strnatcasecmp($data[$c], "devorce") != 0){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.marital_status_values')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.startwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.startwork_end_format')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_end_format')."</li>";
                        }else{
                            if(date_create($data[$c - 1]) != FALSE){
                               /* dd(strtotime($data[$c - 1])."  ".strtotime($data[$c]));*/
                                if(strtotime($data[$c - 1]) >= strtotime($data[$c])){
                                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_smaller')."</li>";
                                }
                            }
                        }
                    }

                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.employee_type_required')."</li>";
                }else{
                    $objEmployeeType = EmployeeType::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objEmployeeType == null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.employee_type_exist')."</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.team_required')."</li>";
                }else{
                    $objTeam = Team::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objTeam == null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.team_exist')."</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.role_required')."</li>";
                }else{
                    $objTeam = Role::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objTeam == null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.role_exist')."</li>";
                    }
                }
			}
		}
		
        return $listError;
    }
    public function checkFileAbsence($data, $num){
        $listError ="";
        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
        
		for ( $row = 1; $row < count($data)/$num; $row++) {
			$c = $row*$num;
			if($c < $row*($num+1)){
                if($data[$c] == null){
                    $listError .= "<li>".trans('vendor.profile_info.email')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.email_required')."</li>";
                }else{                        
                    $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                    // dd($objEmployee);
                    if($objEmployee == null){
                        $listError .= "<li>".trans('vendor.profile_info.email')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.email_exist')."</li>";
                    }
                }
                $c++;

                $c++;

                $c++;

                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.startwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.startwork_end_format')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.endwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.endwork_end_format')."</li>";
                        }else{
                            if(date_create($data[$c - 1]) != FALSE){
                               /* dd(strtotime($data[$c - 1])."  ".strtotime($data[$c]));*/
                                if(strtotime($data[$c - 1]) >= strtotime($data[$c])){
                                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.endwork_smaller')."</li>";
                                }
                            }
                        }
                    }

                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.time_type_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(strnatcasecmp($data[$c], "Cả ngày") != 0 && strnatcasecmp($data[$c], "Sáng") != 0 && strnatcasecmp($data[$c], "Chiều") != 0){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.time_time_values')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.absence_type_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(strnatcasecmp($data[$c], "Nghỉ phép năm") != 0 && strnatcasecmp($data[$c], "Nghỉ không lương") != 0 && strnatcasecmp($data[$c], "Nghỉ thai sản") != 0
                        && strnatcasecmp($data[$c], "Nghỉ cưới hỏi") != 0 && strnatcasecmp($data[$c], "Nghỉ tang") != 0 && strnatcasecmp($data[$c], "Nghỉ ốm") != 0
                        ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.absence_type_values')."</li>";
                        }
                    }
                }
                $c++;
                // if($data[$c] == null){
                //     $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileAbsence.employee_type_required')."</li>";
                // }
            }
        }
    }    
    public function checkFileVendor($data, $num){
        $listError ="";
        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
        for ( $row = 1; $row < count($data)/$num; $row++) {
            $c = $row*$num;
            if($c < $row*($num+1)){
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.email_required')."</li>";
                }else{                        
                    $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                    if($objEmployee != null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.role_exist')."</li>";
                    }else{
                        $partten = "/^[A-Za-z0-9_\.]{1,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/";
                        if(!preg_match($partten ,$data[$c], $matchs)){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.email_valid')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.name_required')."</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_format')."</li>";
                        }else{
                            
                            if(strtotime($data[$c]) >= strtotime($date)){
                                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.birthday_before')."</li>";
                                }
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.gender_required')."</li>";
                }else{
                    if(strnatcasecmp($data[$c], "FEMALE") != 0 && strnatcasecmp($data[$c], "MALE") != 0 && strnatcasecmp($data[$c], "N/A") != 0){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.gender_values')."</li>";
                    }
                }

                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.mobile_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        $stMb = $data[$c];
                        for($k=0; $k < strlen($data[$c]); $k++){
                            if( $stMb[$k] < "0" || $stMb[$k] > "9" ){
                                $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.mobile_number')."</li>";
                                break;
                            }
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.address_required')."</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.marital_status_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(strnatcasecmp($data[$c], "single") != 0 && strnatcasecmp($data[$c], "married") != 0 && strnatcasecmp($data[$c], "separated") != 0 && strnatcasecmp($data[$c], "devorce") != 0){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.marital_status_values')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.startwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.startwork_end_format')."</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_required')."</li>";
                }else{
                    if($data[$c] != "-"){
                        if(date_create($data[$c]) == FALSE ){
                            $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_end_format')."</li>";
                        }else{
                            if(date_create($data[$c - 1]) != FALSE){
                               /* dd(strtotime($data[$c - 1])."  ".strtotime($data[$c]));*/
                                if(strtotime($data[$c - 1]) >= strtotime($data[$c])){
                                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.endwork_smaller')."</li>";
                                }
                            }
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.employee_type_required')."</li>";
                }else{
                    $objEmployeeType = EmployeeType::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objEmployeeType == null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.employee_type_exist')."</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.company_required')."</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.role_required')."</li>";
                }else{
                    $objTeam = Role::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objTeam == null){
                        $listError .= "<li>".trans('importFile.import_file.check_col.row')." ".$row.": ".trans('importFile.import_file.checkFileEmployee.role_exist')."</li>";
                    }
                }
                
            }
        }
        
        return $listError;
    }
}
