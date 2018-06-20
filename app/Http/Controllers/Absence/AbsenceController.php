<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Absence\AbsenceService;
class AbsenceController extends Controller
{
    public function index()
    {
    	$abc = new AbsenceService();
    	/*dd($abc->soNgayNghiPhep(1,2017,0));
    	dd($abc->soNgayDuocNghiPhep(1,2017));*/
        return view('vangnghi.list');
    }
}
