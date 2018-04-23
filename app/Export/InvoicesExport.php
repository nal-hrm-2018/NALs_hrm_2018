<?php

namespace App\Export;
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

    public function __construct(SearchEmployeeService $searchEmployeeService, Request $request)
    {
        $this->searchEmployeeService = $searchEmployeeService;
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        /*$arrayValues = $this->searchEmployeeService->searchEmployee($this->request);

        foreach ($arrayValues as $key => $value){
            switch ($value['role']){
                case 1: $value['role'] =
            }
        }*/
        return $this->searchEmployeeService->searchEmployee($this->request);
    }
}