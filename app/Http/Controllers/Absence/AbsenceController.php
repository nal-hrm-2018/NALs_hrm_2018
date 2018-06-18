<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;


class AbsenceController extends Controller
{
    public function confirmRequest($id){
        return view('absence.po_project');
    }
}
