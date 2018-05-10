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

    public function headings(): array
    {
        return [
            'EMAIL',
            'PASSWORD',
            'NAME',
            'BIRTHDAY',
            'GENDER',
            'MOBILE',
            'ADDRESS',
            'WORK STATUS',
            'START WORK DATE',
            'END WORK DATE',
            'EMPLOYEE TYPE',
            'TEAM',
            'ROLE',
            '',
            '',
            'NOTE'
        ];
    }
}