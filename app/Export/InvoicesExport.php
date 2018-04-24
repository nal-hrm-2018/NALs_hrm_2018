<?php

namespace App\Export;
use App\Service\SearchEmployeeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Employee;
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
        $query->select('employees.id', 'employees.name', 'teams.name as team', 'roles.name as role', 'employees.email', 'employees.work_status')
            ->join('teams','teams.id','=','employees.team_id')
            ->join('roles','roles.id','=','employees.role_id');
        $params['search'] = [
            'id' => !empty($this->request->id) ? $this->request->id : '',
            'name' => !empty($this->request->name) ? $this->request->name : '',
            'team' => !empty($this->request->team) ? $this->request->team : '',
            'email' => !empty($this->request->email) ? $this->request->email : '',
            'role' => !empty($this->request->role) ? $this->request->role : '',
            'status' => !empty($this->request->status) ? $this->request->status : '',
        ];
        foreach ($params as $key => $value){
            $id = $value['id'];
            $name = $value['name'];
            $team = $value['team'];
            $role = $value['role'];
            $email = $value['email'];
            $status = $value['status'];
        }
        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name", 'like', '%' . $role . '%');
                });
        }
        if (!empty($name)) {
            $query->Where('name', 'like', '%' . $name . '%');
        }
        if (!empty($id)) {
            $query->Where('id', '=', $id);
        }
        if (!empty($team)) {
            $query
                ->whereHas('team', function ($query) use ($team) {
                    $query->where("name", 'like', '%' . $team. '%');
                });
        }
        if (!empty($email)) {
            $query->Where('email', 'like', '%' . $email . '%');
        }
        if (!empty($status)) {
            $query->Where('work_status', 'like', '%' . $status . '%');
        }
        $employeesSearch = $query
            ->where('employees.delete_flag','=',0);
        $returnCollectionEmployee = $employeesSearch->get();
         return  $returnCollectionEmployee->map(function(Employee $item) {
             $item->work_status = $item->work_status?'Unactive':'Active';
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
        return [
            'ID',
            'NAME',
            'TEAM',
            'ROLE',
            'EMAIL',
            'STATUS'
        ];
    }

}