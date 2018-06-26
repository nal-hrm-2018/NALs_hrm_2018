<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:06 PM
 */

namespace App\Service;
use App\Http\Requests\CommonRequest;
use Illuminate\Http\Request;

interface SearchConfirmService
{
    public function searchConfirm($Request, $id);
    public function createTempTable($listValueOnPage, $tempTableName);
}