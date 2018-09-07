<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 9:27 AM
 */

namespace App\Service;


use Illuminate\Http\Request;

interface SearchOvertimeService
{
    public function searchOvertime(Request $params);
}