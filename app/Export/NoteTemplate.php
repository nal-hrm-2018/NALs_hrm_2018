<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/4/2018
 * Time: 3:49 PM
 */

namespace App\Export;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class NoteTemplate implements WithHeadings, WithMapping, WithTitle
{

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['NOTE',
            '',
            'GENDER'];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        dd($this->headings());
        return['NOTE'=>'ok fine',
        ''=>'',
        'GENDER'=>'MALE'];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'NOTE';
    }
}