<?php

namespace App\Export;
use App\Models\Role;
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

class VendorExport implements FromCollection, WithEvents, WithHeadings
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

    public function __construct(SearchEmployeeService $searchEmployeeService, Request $request)
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
        $query->select('employees.id', 'employees.name', 'employees.company','employees.role_id', 'employees.work_status');
        /*$query->select('employees.id', 'employees.name', 'employees.company', 'roles.name as role', 'employees.work_status')
            ->join('roles', 'roles.id', '=', 'employees.role_id');*/

        $id = !empty($this->request->id) ? $this->request->id : '';
        $name = !empty($this->request->name) ? $this->request->name : '';
        $company = !empty($this->request->company) ? $this->request->company : '';
        $role = !empty($this->request->role) ? $this->request->role : '';
        $status = !is_null($this->request->status) ? $this->request->status : '';

        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name", 'like', '%' . $role . '%');
                });
        }
        if (!empty($name)) {
            $query->Where('employees.name', 'like', '%' . $name . '%');
        }
        if (!empty($id)) {
            $query->Where('employees.id', '=', $id);
        }
        if (!empty($company)) {
            $query->Where('company', 'like', '%' . $company . '%');
        }
        if ($status != "") {
            $query->Where('work_status', $status);
        }

        $employeesSearch = $query
            ->where('employees.delete_flag', '=', 0)
            ->where('employees.is_employee', '=', 0);
        $returnCollectionEmployee = $employeesSearch->get();

         return $returnCollectionEmployee->map(function (Employee $item) {
             if ($item->role_id == null){
                 $item->role_id = "-";
             }
             else{
                 $roleFindId = Role::where('id',$item->role_id)->first();
                 $item->role_id = $roleFindId->name;
             }
             $item->work_status = $item->work_status ? 'Inactive' : 'Active';
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
            'VENDOR ID',
            'NAME',
            'COMPANY',
            'ROLE',
            'STATUS'
        ];
    }

}