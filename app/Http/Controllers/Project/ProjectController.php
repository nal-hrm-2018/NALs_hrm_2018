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
        return view('projects.list');

    }

    public function create()
    {
        return view('projects.add');
    }

    public function show($id)
    {
        $project = Project::where('delete_flag', 0)->find($id);

        if (!isset($project)) {
            return abort(404);
        }
        $member = Employee::select('employees.id','employees.name','employees.email','employees.mobile','employees.is_employee','processes.*')
            ->join('processes', 'processes.employee_id', '=', 'employees.id')
            ->where([
            ['processes.project_id', '=', $id],
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

    public function phucTest(Request $request){
        $id = $request->id;
        $name = $request->name;
        $user = array('id'=>$id, 'name'=>$name);
        $request->session()->push('listUser', $user);
        return response('Success');
    }

    public function phucTest2(Request $request){
        $user = $request->session()->get('listUser');
        foreach ($user as $item){
            foreach($item as $key => $value) {
                echo "$key is at $value--";
            };
        }

    }
}