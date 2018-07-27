<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use App\Models\PermissionEmployee;
use App\Models\Permissions;
use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
use Hash;

class EmployeeProjectController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $employee_id = $user->id;
        $view_list_project_id = Permissions::where('name', 'view_list_project')->value('id');
        $permissions = PermissionEmployee::where('employee_id',$employee_id)
            ->where('permission_id', $view_list_project_id)->get();
        $data = [];
        if (count($permissions)){
            $projects = Project::all();
            foreach ($projects as $project){
                $data[] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'income' => $project->income,
                    'real_cost'=> $project->real_cost,
                    "description"=> $project->description,
                    "status_id" => $project->status_id,
                    "estimate_start_date"=> $project->estimate_start_date,
                    "start_date"=> $project->start_date,
                    "estimate_end_date"=> $project->estimate_end_date,
                    "end_date"=> $project->end_date
                ];
            }
            return $this->sendSuccess($data, 'list empolyee projects');
        }
        return $this->sendSuccess($data, 'permission denied');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
