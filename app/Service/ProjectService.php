<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:06 PM
 */

namespace App\Service;
use App\Http\Requests\CommonRequest;
use App\Http\Requests\TeamEditRequest;

interface ProjectService
{
    public function getProcessbetweenDate($id, $start_date_process, $end_date_process,$except_project_id);

    public function addProject($request);
    public function editProject($request, $id);
}