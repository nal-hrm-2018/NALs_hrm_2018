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

interface TeamService
{
    public function addNewTeam( $Request);
    public function updateTeam(  $request, $id);
}