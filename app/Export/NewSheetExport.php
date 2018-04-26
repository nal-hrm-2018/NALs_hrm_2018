<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/25/2018
 * Time: 2:59 PM
 */

namespace App\Export;


use Maatwebsite\Excel\Concerns\WithTitle;

class NewSheetExport implements  WithTitle
{

    /**
     * @return string
     */
    public function title(): string
    {
        return "Template";
    }
}