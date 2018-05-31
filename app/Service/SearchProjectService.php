<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/23/2018
 * Time: 8:47 AM
 */

namespace App\Service;


use Illuminate\Http\Request;

interface SearchProjectService
{
    public function searchProject( Request $params);
}