<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all()->dd();
        echo $projects;
        return view('admin.module.index.index', [
            'projects' => $projects,
        ]);
    }


}
