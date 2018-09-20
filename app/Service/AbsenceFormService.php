<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:26 PM
 */

namespace App\Service;


use Illuminate\Http\Request;

interface AbsenceFormService
{
    public function addNewAbsenceForm(Request $request);
    public function editAbsenceForm(Request $request,$id);
}