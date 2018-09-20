<?php

namespace App\Export;
use App\Models\Role;
use App\Models\Team;
use App\Service\SearchEmployeeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Employee;
use App\Models\Overtime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 4:47 PM
 */

class InvoicesExport implements FromCollection,WithEvents, WithHeadings
{
    use Exportable, RegistersEventListeners;
    private $searchEmployeeService;
    protected $returnCollectionEmployee;
    /**
     * @var Request
     */
    private $request;


    /**
     * @var Request
     */

    public function __construct(SearchEmployeeService $searchEmployeeService,Request $request)
    {
        $this->request = $request;
        $this->searchEmployeeService = $searchEmployeeService;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Employee::query();

        if (!isset($this->request['number_record_per_page'])) {
            $this->request['number_record_per_page'] = config('settings.paginate');
        }
        $params['search'] = [
            'id' => !empty($this->request->id) ? $this->request->id : '',
            'name' => !empty($this->request->name) ? $this->request->name : '',
            'team' => !empty($this->request->team) ? $this->request->team : '',
            'email' => !empty($this->request->email) ? $this->request->email : '',
            'role' => !empty($this->request->role) ? $this->request->role : '',
        ];
        
        foreach ($params as $key => $value) {
            $id = $value['id'];
            $name = $value['name'];
            $team = $value['team'];
            $role = $value['role'];
            $email = $value['email'];
        }
        $status = !is_null($this->request->status) ? $this->request->status : '';
        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name",$role);
                });
        }
        if (!empty($name)) {
            $query->Where('name', 'like', '%' . $name . '%');
        }

        /*if (!is_null($this->request['is_employee'])) {
            $query->Where('is_employee', $this->request['is_employee']);
        }*/

        /*if (!empty($request['role_in_process'])) {
            $role_in_process= $request['role_in_process'];
            $query
                ->whereHas('processes', function ($query) use ( $role_in_process ) {
                    $query->where("role_id", $role_in_process);
                });
        }*/
/*
        if (!empty($this->request['company'])) {
            $query->Where('company', 'like', '%' . $this->request['company'] . '%');
        }*/

        if (!empty($id)) {
            $query->Where('id', '=', $id);
        }
        if (!empty($team)) {
            $query
                ->whereHas('teams', function ($query) use ($team) {
                    $query->where("name", 'like', '%' . $team . '%');
                });
        }        
        if (!empty($email)) {
            $query->Where('email', 'like', '%' . $email . '%');
        }
        if ($status != "") {
            $dateNow = date('Y-m-d');
            if($status == 0){
                $query->Where('work_status', $status)
                    ->where('endwork_date','>=',$dateNow);
            }
            if ($status == 1){
                $query->Where('work_status', $status);
            }
            if ($status == 2){
                $query->Where('work_status', '0')
                    ->where('endwork_date','<',$dateNow);
            }
        }

       /* if (!is_null($request['status'])) {
            $query->Where('work_status', $request['status']);
        }*/

        $employeesSearch = $query
            ->where('delete_flag', '=', 0)
            ->where('is_employee',1)->paginate($this->request['number_record_per_page']);
        foreach($employeesSearch as $val){
            $arr_team = $val->teams()->get();
            $string_team ="";
            foreach ($arr_team as $team){
                $addteam=  (string)$team->name;
                if ($string_team){
                $string_team = $string_team.", ".$addteam;
                } else{
                $string_team = $string_team.$addteam;
                }
            }
            $val->avatar = $string_team;
        }
        $newmonth = date('d');
        $newmonth = date("Y-m-d", strtotime('-'.$newmonth.' day'));
        foreach($employeesSearch as $val){
            $ots = $val->overtime()->get();
            $s = 0;
            foreach ($ots as $ot){
                if(($ot->overtime_status_id == 3 || $ot->overtime_status_id == 4) && strtotime($ot->date) > strtotime($newmonth)){
                    $s += $ot->correct_total_time;
                }
            }
            if($s){
                $val->updated_at = $s.' hours';
            }else{
                $val->updated_at  = '-';
            }
        }
        return $employeesSearch->map(function(Employee $item) {
            if ($item->team_id == null){
                $item->team_id = "-";
            }
            else{
                $teamFindId = Team::where('id',$item->team_id)->first();
                $item->team_id = $teamFindId->name;
            }
            if ($item->role_id == null){
                $item->role_id = "-";
            }
            else{
                $roleFindId = Role::where('id',$item->role_id)->first();
                $item->role_id = $roleFindId->name;
            }
            if ($item->avatar == null){
                $item->avatar = "-";
            }
//            $item->work_status = $item->work_status?'Inactive':'Active';
            $dateNow = date('Y-m-d');
            $dateEndWork = Employee::find($item->id);

            if (($item->work_status == 0) && ($dateEndWork->endwork_date < $dateNow)){
                $item->work_status = 'Expired';
            }
            if(($item->work_status == 0) && ($dateEndWork->endwork_date >= $dateNow)){
                $item->work_status = 'Active';
            }
            if ($item->work_status == 1){
                $item->work_status = 'Quited';
            }
            unset($item->team_id);//trinhhunganh28082018
            unset($item->password); unset($item->remember_token);
            unset($item->birthday);unset($item->gender);
            unset($item->mobile);
            unset($item->address);
            unset($item->marital_status);
//            unset($item->work_status);
            unset($item->startwork_date);
            unset($item->endwork_date);unset($item->curriculum_vitae);
            unset($item->is_employee);unset($item->company);
            unset($item->is_manager);
            unset($item->salary_id);unset($item->employee_type_id);
            // unset($item->updated_at);
            unset($item->last_updated_by_employee);
            unset($item->created_at);unset($item->created_by_employee);
            unset($item->delete_flag);
            unset($item->updated_by_employee);
            unset($item->remaining_absence_days);
            return $item;
        });
    }
    public static function beforeExport(BeforeExport $event)
    {
        //
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        //
    }

    public static function afterSheet(AfterSheet $event)
    {
        //
    }

    /**
     * @return array
     */
    public function headings(): array
    {
//        return [
//            'ID',
//            'EMAIL',
//            'NAME',
//            'TEAM',
//            'ROLE',
//            'STATUS'
//        ];
        return [
            'EMPLOYEE ID',
            'EMAIL',
            'NAME',
            'TEAM',
            'POSITION',
            'STATUS',
            'OVERTIME'
        ];
    }

}