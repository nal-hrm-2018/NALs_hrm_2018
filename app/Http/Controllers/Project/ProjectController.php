<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */
namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function show($id)
    {
        $project = Project::where('delete_flag', 0)->find($id);

        if (!isset($project)) {
            return abort(404);
        }
        $member = Employee::select('employees.id','employees.name','processes.*','employees.email','employees.mobile')
            ->join('processes', 'processes.employee_id', '=', 'employees.id')
            ->where([
            ['processes.project_id', '=', $id],
            ['employees.delete_flag', '=', 0],
            ['processes.delete_flag', '=', 0]])
            ->orderByRaw('role_id DESC')
            ->get();

        return view('projects.view', compact('member','project'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id, Request $request)
    {
    }
}