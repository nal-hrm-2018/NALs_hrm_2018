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
    public function getProcessbetweenDate($id, $start_date_process, $end_date_process , $except_project_id)
    {
        $query = Process::query();
        $query->where('employee_id', $id)->where('delete_flag', '=', 0);
        $query->where('project_id','!=',$except_project_id);
//        $query->whereNotExists(function ($query) use ($end_date_process) {
//            $query->where('start_date', '>=', $end_date_process);
//        });
        $query->whereRaw("NOT EXISTS (select * where `start_date` >= ".$end_date_process.")");
//        $query->whereNotExists(function ($query) use ($start_date_process) {
//            $query
//                ->where('end_date', '<=', $start_date_process);
//        });
        $query->whereRaw("NOT EXISTS (select * where `end_date` <= ".$start_date_process.")");
//        select * from `processes` where `employee_id` = ? and `delete_flag` = ? and `project_id` != ? and not exists (select * where `start_date` >= ?) and not exists (select * where `end_date` <= ?)
//        dd($query->toSql());
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
        $project_data = [
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
            $queryUpdateProject = Project::where('id', $id)->update($project_data);

//            $processGetFromDB1 = Process::where('project_id', $id);
//
//            try {
//                $processGetFromDB1->forceDelete();
//            } catch (Exception $exception) {
//                dd($exception->getMessage());
//            }

            //list nhung thang nhan dc tu client
            $processes = request()->get('processes');
            if (!empty($processes)) {
                foreach ($processes as $process) {
                    $processesNew = [
                        'id' => $process['id'],
                        'project_id'=> $id,
                        'employee_id' => $process['employee_id'],
                        'role_id' => $process['role_id'],
                        'man_power' => (float)$process['man_power'],
                        'check_project_exit' => 1,
                        'start_date' => $process['start_date_process'],
                        'end_date' => $process['end_date_process'],
                        'delete_flag' => (int)$process['delete_flag'],
                    ];
                    $process_model=Process::updateOrCreate(['id' => $process['id']],$processesNew);
                }
            }



            //so sanh list process cu nhan duoc tu client va process lay tu db
            //kiểu như so sánh 2 cái mảng, thằng process nào của $processGetFromDB ko có trong cái mảng $processesOld thì vào db xóa thằng đó
//            if(sizeof($processesOld) != sizeof($processGetFromDB)){
//                for ($i=0; $i<sizeof($processesOld); $i++){
//                    foreach ($processGetFromDB as $itemDB){
//                        if($itemDB->employee_id === $processesOld[$i]['employee_id'] &&
//                            $itemDB->role_id === $processesOld[$i]['role_id']&&
//                            $itemDB->man_power === $processesOld[$i]['man_power'] &&
//                            $itemDB->start_date === $processesOld[$i]['start_date'] &&
//                            $itemDB->end_date === $processesOld[$i]['end_date']){
//                            continue;
//                            //chưa xong, làm tiếp dùm nhé :v
//                        }
//                    }
//                }
//            }


            DB::commit();
            return $queryUpdateProject;
        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('common.msg_error'), trans('project.msg_content.msg_edit_error'));
            return null;
        }
    }
}