<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */
namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\Team;
use App\Service\SearchProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    private $searchProjectService;

    public function __construct(SearchProjectService $searchProjectService)
    {
        $this->searchProjectService = $searchProjectService;
    }

    public function index(Request $request)
    {
        $allStatusValue = Status::all();
//        $projects = Project::where('delete_flag', 0)->orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')->paginate($request['number_record_per_page']);
        $projects = $this->searchProjectService->searchProject($request)->orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')->paginate($request['number_record_per_page']);
        $projects->setPath('');
        $poRole = Role::select('id')
            ->where('name', 'PO')->first();
        $getAllStatusInStatusTable = Status::all();

        /*foreach ($projects as $project){

            dd($project->status);
            foreach ($project->processes as $process){
                $poInProject = $process->employee->where('role_id',$idRolePo);
                if (!is_null($poInProject)){
                }
            }
        }*/
        $param = (Input::except('page'));
        return view('projects.list', compact('param','allStatusValue','projects','poRole','getAllStatusInStatusTable'));

    }

    public function create()
    {

    }

    public function show($id)
    {
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