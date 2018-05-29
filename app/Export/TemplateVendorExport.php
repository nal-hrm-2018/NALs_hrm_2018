<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/25/2018
 * Time: 2:59 PM
 */

namespace App\Export;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateVendorExport implements  WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'EMAIL',
            'NAME',
            'BIRTHDAY',
            'GENDER',
            'MOBILE',
            'ADDRESS',
            'MARITAL STATUS',
            'START WORK DATE',
            'END WORK DATE',
            'EMPLOYEE TYPE',
            'COMPANY',
            'ROLE'
        ];
    }
}