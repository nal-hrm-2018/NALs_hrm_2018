<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/25/2018
 * Time: 2:46 PM
 */

namespace App\Export;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateExport implements  WithHeadings
{
    use Exportable;

    private $fileName = 'invoices.csv';

    public function headings(): array
    {
        return [
            'ID',
            'EMAIL',
            'PASSWORD',
            'NAME',
            'BIRTHDAY',
            'GENDER',
            'MOBILE',
            'ADDRESS',
            'MARITAL STATUS',
            'WORK STATUS',
            'START WORK DATE',
            'END WORK DATE',
            'COMPANY',
            'TEAM',
            'ROLE',
            'SALARY'
        ];
    }

    /**
     * @return array
     */
    /*public function sheets(): array
    {
        $sheets = [];
        $sheets[1] = [
            'ID',
            'EMAIL',
            'PASSWORD',
            'NAME',
            'BIRTHDAY',
            'GENDER',
            'MOBILE',
            'ADDRESS',
            'MARITAL STATUS',
            'WORK STATUS',
            'START WORK DATE',
            'END WORK DATE',
            'COMPANY',
            'TEAM',
            'ROLE',
            'SALARY'
        ];
        return $sheets;
    }*/
}