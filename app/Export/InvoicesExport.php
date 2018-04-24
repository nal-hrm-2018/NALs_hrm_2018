<?php

namespace App\Export;
use App\Models\Employee;
use App\Service\SearchEmployeeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 4:47 PM
 */

class InvoicesExport implements FromCollection
{

    private $searchEmployeeService;
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
         return  $this->searchEmployeeService->searchEmployee( $this->request)->get();
    }


}