<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:50 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function rules(){
        return [
            'projectId' => 'required',
            'projectName' => 'required',
            'income' => 'required|numeric',
            'estimateCost' => 'required|numeric',
            'realCost' => 'required|numeric',
            'kickOff' => 'required'
        ];
    }
}