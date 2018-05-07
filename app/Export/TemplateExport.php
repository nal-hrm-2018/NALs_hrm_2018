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
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'MARITAL STATUS',
            'START WORK DATE',
            'END WORK DATE',
            'EMPLOYEE TYPE',
            'TEAM',
            'ROLE'
        ];
    }

    /**
     * @return array
     */
   /* public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new TemplateExport();
        $sheets[] = new NoteTemplate();
        return $sheets;
    }*/

    /**
     * @return string
     */
    /*public function title(): string
    {
        return "template";
    }*/
}