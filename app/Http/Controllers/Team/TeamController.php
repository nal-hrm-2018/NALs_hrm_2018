<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamEditRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:50 AM
 */
class TeamController extends Controller
{
    public function index(Request $request)
    {
        return view('teams.test.quy_test');
    }

    public function create()
    {
        return view('teams.add');
    }

    /**
     * @param TeamAddRequest $request
     * @param $id
     * @return null
     */
    public function store($id)
    {
        return null;
    }

    public function show($id)
    {
        return null;
    }

    public function edit($id)
    {
        $allEmployees = Employee::All();
        $onlyValue = null;
        $nameEmployee = null;
        $teamById = Team::findOrFail($id)->toArray();
        $nameTeam = $teamById['name'];
        $idUser = Auth::user()->id;
        $roleTeamOfEmployee = "".Auth::user()->team_id;
        if ($roleTeamOfEmployee != $id) {
            return view('errors.403');
        } else {
            $poEmployee = Employee::select('email', 'name')
                ->Where('team_id', '=', $teamById['id'])
                ->Where('id', '=', $idUser)
                ->get()->toArray();
            $allEmployeeInTeams = Employee::select('employees.id','employees.name','roles.name as role')
                ->join('teams','teams.id','=','employees.team_id')
                ->join('roles','roles.id','=','employees.role_id')
                ->where('team_id','=',Auth::user()->team_id)
                ->orderBy('employees.id', 'asc')->get();
            $values = $poEmployee;
            foreach ($values as $value) {
                $onlyValue = $value['email'];
                $nameEmployee = $value['name'];
            }
            return view('teams.edit', compact('teamById', 'onlyValue', 'nameTeam', 'allEmployees','allEmployeeInTeams', 'nameEmployee'));
        }
    }

    /**
     *
     * @param $id
     * @return null
     */
    public function update(Request $request, $id)
    {
        if (isset($id)) {
            /*$checkPoElementQuery = Team::select('employees.name')
                ->join('employees', 'employees.team_id', '=', 'teams.id')
                ->where('name', 'like', $request->po_name)
                ->where('id', '<>', $id)->get();*/
            try {
                $queryUpdateTeam = Team::find($id);
                $getPORole = Role::where('name', '=', 'PO')->firstOrFail();
                $teamName = $request->team_name;
                $poId = $request->po_name;
                $tests = $request->employee_in_team;
                dd(array_keys($tests));
                foreach ($tests as $test){
                    dd(array_keys($tests));
                }

//                $multipleEmployees = $request->all()['employee'];
                $multipleEmployeesByIds = $request->employee;
                $queryUpdateTeam->name = $teamName;
                $queryUpdateRoleToEmployee = Employee::find($poId);
                $queryUpdateRoleToEmployee->team_id = $queryUpdateTeam->id;
                $queryUpdateRoleToEmployee->role_id = $getPORole['id'];
                $queryUpdateTeam->save();
                $queryUpdateRoleToEmployee->save();
                foreach ($multipleEmployeesByIds as $multipleEmployeesById) {
                    $queryUpdateEmployee = Employee::find($multipleEmployeesById);
                    if ($queryUpdateEmployee == null) {
                        \Session::flash('msg_fail', 'Edit failed!!! Employee is not exit!!!');
                        return back();
                    } else {
                        $queryUpdateEmployee->team_id = $queryUpdateTeam->id;
                        $queryUpdateEmployee->save();
                    }
                }
                return redirect('employee');
            } catch (Exception $exception) {
                return $exception->getMessage();
            }
        } else {
            return redirect("teams");
        }
    }

    public function destroy($id, Request $request)
    {
        die('abc');
        return null;
    }

    public  function checkNameTeam(Request $request){
        $name = $_GET["name"];
        $regexNameTeam = "/(^[a-zA-Z0-9 ]{1,20}+$)+/";
        try{
            $queryGetNameTeamTable = Team::where('name', $name)->first();
        }
        catch (Exception $exception){
            echo "<h4>Name Team has exit !</h4>";
            $queryGetNameTeamTable = null;
        }
        finally{
            if ($name == ""){
                echo "Name Team not blank!";
            }
            elseif (isset($queryGetNameTeamTable->name)) {
                echo "Name Team has exit !";
            }
            elseif (!preg_match($regexNameTeam, $name)){
                echo "Name Team not true !";
            }
        }

    }

}