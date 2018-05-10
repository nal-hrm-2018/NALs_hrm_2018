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

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index(Request $request)
    {
        return view('teams.list');
    }

    public function create()
    {
        $employees = Employee::orderBy('name', 'asc')->where('delete_flag', 0)->with('team', 'role')->get();
        return view('teams.add', compact('employees'));
    }

    public function store(TeamAddRequest $request)
    {
        if ($this->teamService->addNewTeam($request)) {
            session()->flash(trans('team.msg_success'), trans('team.msg_content.msg_add_success'));
            return view('teams.test.cong_test');
        }
        session()->flash(trans('team.msg_fails'), trans('team.msg_content.msg_add_fail'));
        return back();
    }

    public function show($id)
    {
        return null;
    }

    public function edit($id)
    {
        $allEmployees = Employee::query()
            ->with(['team', 'role'])
            ->where('employees.team_id',null)

            ->orwhereNotIn('employees.team_id', function ($q) {
                $q->select('id')->from('teams')->where('id', Auth::user()->team_id);
            })->get();
        $allEmployeeHasPOs = Employee::where('id', $id)->where('delete_flag', 0)->get();
        $onlyValue = null;
        $nameEmployee = null;
        try {
            $teamById = Team::findOrFail($id)->toArray();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        $nameTeam = $teamById['name'];
        $idUser = Auth::user()->id;
        $teamOfEmployee = "" . Auth::user()->team_id;
        $rolePoInRole = Role::select('id')
            ->where('name', 'PO')->first();
        $numberPoInRole = $rolePoInRole->id;
        $allRoleInTeam = Role::all();
        $allTeam = Team::all();
        if ($teamOfEmployee != $id) {
            return view('errors.403');
        } else {
            $poEmployee = Employee::select('id', 'email', 'name')
                ->Where('team_id', '=', $teamById['id'])
                ->Where('id', '=', $idUser)
                ->get()->toArray();
            $allEmployeeInTeams = Employee::select('employees.id', 'employees.name', 'roles.name as role')
                ->join('teams', 'teams.id', '=', 'employees.team_id')
                ->join('roles', 'roles.id', '=', 'employees.role_id')
                ->where('team_id', '=', Auth::user()->team_id)
                ->where('roles.name', '<>', 'PO')
                ->orderBy('employees.id', 'asc')->get();
            $values = $poEmployee;
            foreach ($values as $value) {
                $onlyValue = $value['email'];
                $nameEmployee = $value['name'];
                $idEmployee = $value['id'];
            }
            return view('teams.edit', compact('teamById','idUser', 'onlyValue', 'nameTeam','allEmployeeHasPOs', 'allEmployees', 'allEmployeeInTeams','idEmployee','nameEmployee', 'numberPoInRole','allRoleInTeam','allTeam'));

        }
    }

    /**
     *
     * @param TeamEditRequest $request
     * @param $id
     * @return null
     */
    public function update(TeamEditRequest $request, $id)
    {
        if ($this->teamService->updateTeam($request, $id)){
            return redirect('employee');
        }
        else{
            return back();
        }
    }

    public
    function destroy($id, Request $request)
    {
        return null;
    }

    public
    function checkNameTeam(Request $request)
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
}