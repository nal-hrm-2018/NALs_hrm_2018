<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;


class AbsenceController extends Controller
{
    public function index()
    {


        return view('vangnghi.list');
    }
}
