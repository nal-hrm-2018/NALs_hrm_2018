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
        $poRole = Role::select('id')
            ->where('name', 'PO')->first();

        $projects = $this->searchProjectService->searchProject($request)
            ->orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')
            ->paginate($request['number_record_per_page']);
        $projects->setPath('');

        $getAllStatusInStatusTable = Status::all();

        $param = (Input::except('page'));
        return view('projects.list', compact('param','allStatusValue','projects','poRole','getAllStatusInStatusTable'));

    }

    public function create()
    {dd('create');

    }

    public function show($id)
    {dd('abcshow');
    }

    public function edit($id)
    {dd('eidt');
    }

    public function update(Request $request, $id)
    {dd('abc');
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