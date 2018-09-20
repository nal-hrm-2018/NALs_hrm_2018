<?php

namespace App\Http\Controllers\Team;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:50 AM
 */
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamAddRequest;
use App\Http\Requests\TeamEditRequest;
use App\Service\ChartService;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Service\TeamService;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;


class TeamController extends Controller
{
    private $teamService;
    private $chartService;

    public function __construct(TeamService $teamService, ChartService $chartService)
    {
        $this->teamService = $teamService;
        $this->chartService = $chartService;
    }

    public function index()
    {
        $teams = Team::all()->where('delete_flag', 0);
        $currentMonth = date('Y-m-01');
        $teamsValue = $this->chartService->getValueOfListTeam($currentMonth);
        $listMonth = $this->chartService->getListMonth();

        return view('teams.list', compact('teams', 'teamsValue', 'listMonth'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name', 'asc')->where('is_employee',1)->where('delete_flag', 0)->with('team', 'role')->get();
        $listRole = Role::where('delete_flag','0')->get();
        return view('teams.add', compact('employees','listRole'));
    }

    public function store(TeamAddRequest $request)
    {
        if ($this->teamService->addNewTeam($request)) {
            session()->flash(trans('team.msg_success'), trans('team.msg_content.msg_add_success'));
            return redirect(route('teams.index'));
        }
        return back();
    }

    public function show($id)
    {
        $team = Team::where('delete_flag', 0)->find($id);
        if (!isset($team)) {
            return abort(404);
        }
        $member = Employee::where([
            ['team_id', '=', $id],
            ['delete_flag', '=', 0]
        ])->get();
        return view('teams.view', compact('member'));
    }

    public function edit($id)
    {
        $team = Team::where('delete_flag', 0)->find($id);
        if (!isset($team)) {
            return abort(404);
        }
        $listEmployee = Employee::query()
            ->with(['team', 'role'])
            ->where('delete_flag', 0)->get();
        $listEmployeeOfTeam = Employee::select('employees.id', 'employees.name', 'employees.role_id','teams.name as team', 'roles.name as role')
            ->join('teams', 'teams.id', '=', 'employees.team_id')
            ->join('roles', 'roles.id', '=', 'employees.role_id')
            ->where('employees.team_id', $id)
            ->where('employees.is_manager','<>', '1')
            ->where('employees.delete_flag', '0')
            ->orderBy('employees.id', 'asc')->get();
        $listRole = Role::where('delete_flag','0')->get();
        return view('teams.edit', compact('listEmployee','listEmployeeOfTeam', 'team','listRole'));

    }

    /**
     *
     * @param TeamEditRequest $request
     * @param $id
     * @return null
     */
    public function update(TeamEditRequest $request, $id)
    {
        if ($this->teamService->updateTeam($request, $id)) {
            session()->flash(trans('team.msg_success'), trans('team.msg_content.msg_edit_success'));
            return redirect('teams');
        } else {
            session()->flash(trans('team.msg_fails'), trans('team.msg_content.msg_edit_fail'));
            return back();
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $team = Team::where('id', $id)->where('delete_flag', 0)->first();
            $team->delete_flag = 1;
            $team->save();
            $employees = Employee::where('team_id', $id)->get();
            foreach ($employees as $employee) {
                $employee->team_id = null;
                $employee->save();
            }
            return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $id]);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }

    /*public function checkNameTeam(Request $request)
    {
        $name = $_GET["name"];
        $regexNameTeam = "/(^[a-zA-Z0-9 ]{1,50}+$)+/";
        try {
            $rolePoInRole = Team::select('teams.name')
                ->join('employees', 'teams.id', '=', 'employees.team_id')
                ->where('employees.email', Auth::user()->email)->first();
            $userTest = $rolePoInRole->name;
            $queryGetNameTeamTable = Team::where('name', $name)->first();
            $allEmployeeInTean = Team::select('teams.name')
                ->join('employees', 'teams.id', '=', 'employees.team_id')
                ->get()->toArray();
        } catch (Exception $exception) {
            echo "<h4>ERROR !</h4>";
            $queryGetNameTeamTable = null;
        } finally {
            if ($name == "") {
                echo "Name Team not blank!";
            } elseif (isset($queryGetNameTeamTable->name) && ($name == $userTest)) {
                echo "Name Team is your team!";
            } elseif (isset($queryGetNameTeamTable->name)) {
                echo "Name Team has exit!";
            } elseif (!preg_match($regexNameTeam, $name)) {
                echo "Name Team not true. <br>Name has less than 50 characters,number, space and !";
            }
        }
    }
*/
    public function showChart(Request $request)
    {
        $month = date('Y-m-01', strtotime($request->month));
        $teamsValue = $this->chartService->getValueOfListTeam($month);
        return response(['listValueOfMonth' => $teamsValue]);
    }
}