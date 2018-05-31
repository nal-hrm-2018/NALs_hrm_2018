<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */

namespace App\Http\Controllers\Project;

use App\Http\Requests\ProjectEditRequest;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\Team;
use App\Service\SearchProjectService;
use App\Service\ProjectService;
use App\Http\Requests\ProjectAddRequest;
use App\Http\Requests\ProcessAddRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ProjectController extends Controller
{
    private $searchProjectService;
    private $projectService;

    public function __construct(SearchProjectService $searchProjectService, ProjectService $projectService)
    {
        $this->searchProjectService = $searchProjectService;
        $this->projectService = $projectService;
    }

    public function index(Request $request)

    {
        $allStatusValue = Status::all();
        $poRole = Role::select('id')
            ->where('name', 'PO')->first();

        $projects = $this->searchProjectService->searchProject($request)
            ->orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')
            ->paginate($request['number_record_per_page']);
        $projects->setPath('');

        $getAllStatusInStatusTable = Status::all();

        $param = (Input::except('page'));

        $isEmployee = 1;
        $isVendor = 0;
        return view('projects.list', compact('param', 'allStatusValue', 'projects', 'poRole', 'getAllStatusInStatusTable', 'isEmployee', 'isVendor'));

    }

    public function checkProcessesAjax(Request $request)
    {
        if ($request->ajax()) {
            $processAddRequest = new ProcessAddRequest();
            $validator = Validator::make($request->all(), $processAddRequest->rules(), $processAddRequest->messages());
            // available_processes get from manpower validate
            if ($validator->fails()) {
                return response()->json([$validator->messages(), 'available_processes' => request()->get('available_processes')]);
            }

            return response()->json([trans('project.msg_success') => trans('project.msg_content.msg_check_process_success')]);
        }
        return response()->json([trans('project.msg_fails') => trans('project.msg_content.msg_check_process_fail')]);
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
        $error_messages = checkValidProjectData();
        if (!empty($error_messages)) {
            session()->flash('error_messages', $error_messages);
            session()->flash('processes', $request->get('processes'));
            return back()->withInput();
        }

        if (!is_null($this->projectService->addProject($request))) {
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
        $member = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.mobile', 'employees.is_employee', 'processes.*')
            ->join('processes', 'processes.employee_id', '=', 'employees.id')
            ->where([
                ['processes.project_id', '=', $id],
                ['processes.delete_flag', '=', 0]])
            ->orderByRaw('role_id DESC')
            ->get();
        return view('projects.view', compact('member', 'project'));
    }

    public function edit($id)
    {
        $currentProject = Project::where('delete_flag', 0)->find($id);
        if (is_null($currentProject)) {
            return abort(404);
        }
        if (!\session()->get('errors') && !\session()->get('error_messages')) {
            $processes = $currentProject->processes()->get();
            view()->share('processes', $processes);
        }

        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $employees = Employee::orderBy('name', 'asc')->where('delete_flag', 0)->get();
        $manPowers = getArrayManPower();
        $project_status = Status::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view('projects.edit', compact('employeeInProcess', 'roles', 'employees', 'manPowers', 'project_status', 'currentProject'));
    }

    public function update(ProjectEditRequest $request, $id)
    {
        $error_messages = checkValidProjectData();
        if (!empty($error_messages)) {
            session()->flash('error_messages', $error_messages);
            session()->flash('processes', $request->get('processes'));
            return back()->withInput();
        }

        if (!is_null($this->projectService->editProject($request, $id))) {
            session()->flash(trans('common.msg_success'), trans('project.msg_content.msg_edit_success'));
            return redirect(route('projects.index'));
        }
        session()->flash(trans('common.msg_fails'), trans('project.msg_content.msg_edit_fail'));
        return back();
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $project = Project::where('id', $id)->where('delete_flag', 0)->first();
            $project->delete_flag = 1;
            $project->save();

            return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $id]);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }


}