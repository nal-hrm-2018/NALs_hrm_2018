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
use App\Http\Requests\ProjectAddRequest;
use App\Service\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProcessAddRequest;
use App\Models\Role;
use App\Models\Status;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
        if (!session()->has('processes'))
            session()->put('processes', []);
        if (!session()->has('available_processes'))
            session()->put('available_processes', []);
    }

    public function index()
    {
        return view('projects.list');

    }

    public function checkProcessesAjax(Request $request)
    {
        $processAddRequest = new ProcessAddRequest();
        $validator = Validator::make($request->all(), $processAddRequest->rules(), $processAddRequest->messages());
        session()->forget('available_processes');
        // available_processes get tu manpower validate
        if ($validator->fails()) {
            return response()->json([$validator->messages(), 'available_processes' => session()->get('available_processes')]);
        }

        $process = $request->input();
        session()->push('processes', $process);
        return response()->json([trans('common.msg_success') => trans('project.msg_content.msg_check_process_success')]);
    }

    public function removeProcessAjax(Request $request, $id)
    {
        if (!session()->has('processes')) {
            return response()->json([trans('common.msg_fails') => trans('project.msg_content.msg_remove_process_fail')]);
        } else {
            $processes = session()->get('processes');
            if (empty($processes)) {
                return response()->json([trans('common.msg_fails') => trans('project.msg_content.msg_remove_process_fail')]);
            } else {
                foreach ($processes as $index => $process) {
                    if ($process->id === $id) {
                        unset($processes[$index]);
                        return response()->json([trans('common.msg_success') => trans('project.msg_content.msg_remove_process_success')]);
                    }
                }
                return response()->json([trans('common.msg_fails') => trans('project.msg_content.msg_remove_process_fail')]);
            }
        }
    }

    public function create()
    {
        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $employees = Employee::orderBy('name', 'asc')->where('delete_flag', 0)->get();
        $manPowers = getArrayManPower();
        $project_status = Status::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('projects.add', compact('roles', 'employees', 'manPowers', 'project_status'));
    }

    public function store(ProjectAddRequest $request)
    {
        if ($this->projectService->addProject($request)) {
            session()->flash(trans('common.msg_success'), trans('project.msg_content.msg_add_success'));
            return redirect(route('projects.index'));
        }
        session()->flash(trans('common.msg_fails'), trans('project.msg_content.msg_add_fail'));
        return back();
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
        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $employees = Employee::orderBy('name', 'asc')->where('delete_flag', 0)->get();
        $manPowers = getArrayManPower();
        $project_status = Status::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('projects.edit', compact('roles', 'employees', 'manPowers', 'project_status'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id, Request $request)
    {
    }


}