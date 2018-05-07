<?php
namespace App\Import;

use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\EmployeeType;
use App\Export\TemplateExport;
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

    public function checkCol($url){
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $col = count($data);
            break;
        }
        fclose($handle);
        $templateExport = new TemplateExport;
        $colTemplateExport = $templateExport -> headings();
        $rowError = "";
        if($col != count($colTemplateExport)){
            $rowError .= "<li>Invalid csv file. Please check the correct number of columns with the sample file!!!</li>";
        }
        $num = 1;
        
        $i = 0;
        $handle = fopen($url, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if($num > 1){
                $numCol = count($data);
                if($numCol > count($colTemplateExport)){
                    $rowError .= "<li>Row ".$num." has ".($numCol - count($colTemplateExport))." columns</li>";
                    $i++;
                }else if($numCol < count($colTemplateExport)){
                    $rowError .= "<li>Row ".$num." is missing ".(count($colTemplateExport) - $numCol)." columns</li>";
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
                        $listError .= "<li>Email ".$dataEmployees[$i*$num]." has been repeated.</li>";
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
                            $listError .= "<li>Email ".$dataEmployees[$i*$num]." has been repeated.</li>";
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
	public function checkFile($data, $num){
		$listError ="";
		for ( $row = 1; $row < count($data)/$num; $row++) {
			$c = $row*$num;
			if($c < $row*($num+1)){
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Email field is required.</li>";
                }else{                        
                    $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                    if($objEmployee != null){
                        $listError .= "<li>Row ".$row.": Email already exists!!!.</li>";
                    }else{
                        $partten = "/^[A-Za-z0-9_\.]{6,32}@([a-zA-Z0-9]{2,12})(\.[a-zA-Z]{2,12})+$/";
                        if(!preg_match($partten ,$data[$c], $matchs)){
                            $listError .= "<li>Row ".$row.": The Email must be a valid email address..</li>";
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Password field is required.</li>";
                }
                if(strlen($data[$c]) < 6){
                    $listError .= "<li>Row ".$row.": The Password must be at least 6 characters..</li>";
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Name field is required.</li>";   
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Birthday field is required.</li>"; 
                }else{
                    if(date_create($data[$c]) == FALSE ){
                        $listError .= "<li>Row ".$row.": Birthday is incorrect format. Example: 22-02-2000.</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Gender field is required.</li>";   
                }else{
                    if(strnatcasecmp($data[$c], "FEMALE") != 0 && strnatcasecmp($data[$c], "MALE") != 0 && strnatcasecmp($data[$c], "N/A") != 0){
                        $listError .= "<li>Row ".$row.": Gender only receives values Female, Male or N/A.</li>";
                    }
                }

                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Gender field is required.</li>";  
                }else{
                    $stMb = $data[$c];
                    for($k=0; $k < strlen($data[$c]); $k++){
                        if( $stMb[$k] < "0" || $stMb[$k] > "9" ){
                            $listError .= "<li>Row ".$row.": Mobile only number.</li>";
                            break;
                        }
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Address field is required.</li>"; 
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The marital_status field is required.</li>";
                }else{
                    if(strnatcasecmp($data[$c], "single") != 0 && strnatcasecmp($data[$c], "married") != 0 && strnatcasecmp($data[$c], "separated") != 0 && strnatcasecmp($data[$c], "devorce") != 0){
                        $listError .= "<li>Row ".$row.": Marital status only receives values Single, Married, Separated or Devorce.</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Startwork_date field is required.</li>";   
                }else{
                    if(date_create($data[$c]) == FALSE ){
                        $listError .= "<li>Row ".$row.": Startwork_date is incorrect format. Example: 22-02-2000.</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": The Endwork_date field is required.</li>";  
                }else{
                    if(date_create($data[$c]) == FALSE ){
                        $listError .= "<li>Row ".$row.": Endwork_date is incorrect format. Example: 22-02-2000.</li>";
                    }else{
                        if(date_create($data[$c - 1]) != FALSE){
                           /* dd(strtotime($data[$c - 1])."  ".strtotime($data[$c]));*/
                            if(strtotime($data[$c - 1]) >= strtotime($data[$c])){
                                $listError .= "<li>Row ".$row.": Startwork_date must be smaller than Endwork_date.</li>";
                            }
                        }
                    }

                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": Employee Type field is required.</li>";  
                }else{
                    $objEmployeeType = EmployeeType::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objEmployeeType == null){
                        $listError .= "<li>Row ".$row.": Employee_type does not exist.</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": Team field is required.</li>";
                }else{
                    $objTeam = Team::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objTeam == null){
                        $listError .= "<li>Row ".$row.": Team does not exist.</li>";
                    }
                }
                $c++;
                if($data[$c] == null){
                    $listError .= "<li>Row ".$row.": Role field is required.</li>";
                }else{
                    $objTeam = Role::select('name')->where('name', 'like', $data[$c])->get()->toArray();
                    if($objTeam == null){
                        $listError .= "<li>Row ".$row.": Role does not exist.</li>";
                    }
                }
			}
		}
		
        return $listError;
	}
}
