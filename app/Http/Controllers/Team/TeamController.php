<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamAddRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return null;
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
        $onlyValue=null;
        $nameEmployee = null;
        $teamById = Team::findOrFail($id)->toArray();
        $nameTeam = $teamById['name'];
        $idUser = Auth::user()->id;
        $poEmployee = Employee::select('email','name')
            ->Where('team_id','=',$teamById['id'])
            ->Where('id','=',$idUser)
            ->get()->toArray();
        $values = $poEmployee;
        foreach ($values as $value){
            $onlyValue = $value['email'];
            $nameEmployee= $value['name'];
        }

        return view('teams.edit', compact('teamById', 'onlyValue','nameTeam','allEmployees','nameEmployee'));
    }

    public function update(TeamAddRequest $request, $id)
    {

        die('okfine');
        $checkPoElementQuery = Team::select('employees.name')
        ->join('employees', 'employees.team_id', '=', 'teams.id')
        ->where('name', 'like', $request->po_name)
        ->where('id', '<>', $id)->get();
        try {
            $queryUpdateTeam = Team::find($id);
            $teamName = $request->team_name;
            $poName = $request->po_name;

            $multipleEmployees = $request->all()['employee'];
            $multipleEmployeesByIds = $request->all()['id'];

            $queryUpdateTeam->name = $teamName;
            $queryUpdateTeam->employee->name = $poName;

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
            $queryUpdateTeam->save();
            return view('teams.test.quy_test');
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function destroy($id, Request $request)
    {
        return null;
    }

}