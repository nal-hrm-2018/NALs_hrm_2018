<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:26 PM
 */

namespace App\Service;


use Illuminate\Http\Request;

interface AbsencePoTeamService
{
    public function poTeamAcceptOrDenyAbsence(Request $request);
    public function poTeamAcceptAbsenceForm(Request $request);
    public function searchAbsence(Request $request);
}