<?php


namespace App\Service;
use App\Http\Requests\CommonRequest;
use App\Http\Requests\TeamEditRequest;

interface NumberAbsenceService
{
    public function getNumberAbsence( $id);
}