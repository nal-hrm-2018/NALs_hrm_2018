<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 9:18 AM
 */

namespace App\Service\Implement;


use App\Http\Requests\TeamEditRequest;
use App\Models\Project;
use App\Service\CommonService;
use App\Service\TeamService;
use App\Models\Team;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Exception;
use App\Service\ProjectService;
use App\Models\Process;

class ProjectServiceImpl extends CommonService
    implements ProjectService
{


    public function getProcessbetweenDate($id, $start_date_process, $end_date_process)
    {
        $query = Process::query();
        $query->where('employee_id', $id)->where('delete_flag', '=', 0);
        $query->whereNotExists(function ($query) use ($end_date_process) {
            $query->where('start_date', '>=', $end_date_process);
        });
        $query->whereNotExists(function ($query) use ($start_date_process) {
            $query
                ->where('end_date', '<=', $start_date_process);
        });
        return $query;
    }

    public function addProject($request)
    {
        //
        $project_data = [
            'id' => $request->get('id'),
            'name' => $request->get('name'),
            'income' => $request->get('income'),
            'real_cost' => $request->get('real_cost'),
            'description' => $request->get('description'),
            'status_id' => $request->get('status'),
            'start_date' => $request->get('start_date_project'),
            'end_date' => $request->get('end_date_project'),
            'estimate_end_date' => $request->get('estimate_end_date'),
            'estimate_start_date' => $request->get('estimate_start_date'),
        ];
        try {
            $project = new Project($project_data);
            $processes = request()->get('processes');
            DB::beginTransaction();
            $project->save();
            if (!empty($processes)) {
                foreach ($processes as $process) {
                    $process_data = [
                        'employee_id' => $process['employee_id'],
                        'project_id' => $project->id,
                        'role_id' => $process['role_id'],
                        'check_project_exit' => 1,
                        'man_power' => (float)$process['man_power'],
                        'start_date' => $process['start_date_process'],
                        'end_date' => $process['end_date_process'],
                    ];
                    $process_model = new Process($process_data);
                    $process_model->save();
                }
            }
            DB::commit();
            return $project;
        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('common.msg_error'), trans('project.msg_content.msg_add_error'));
            return null;
        }
    }

    public function editProject($request, $id)
    {
        dd($id);
        dd($request);
        $project_data = [
            'id' => $request->get('id'),
            'name' => $request->get('name'),
            'income' => $request->get('income'),
            'real_cost' => $request->get('real_cost'),
            'description' => $request->get('description'),
            'status_id' => $request->get('status'),
            'start_date' => $request->get('start_date_project'),
            'end_date' => $request->get('end_date_project'),
            'estimate_end_date' => $request->get('estimate_end_date'),
            'estimate_start_date' => $request->get('estimate_start_date'),
        ];
        try {
            DB::beginTransaction();

            DB::commit();

        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('common.msg_error'), trans('project.msg_content.msg_edit_error'));
            return false;
        }
    }
}