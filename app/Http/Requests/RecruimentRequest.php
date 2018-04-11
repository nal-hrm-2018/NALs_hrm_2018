<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:57 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RecruimentRequest extends FormRequest
{
    public function rules(){
        return [
            'role' => 'required',
            'team' => 'required',
            'number' => 'required|numeric',
            'yearExp' => 'required|numeric',
            'startFrom' => 'required|date_format:"d-m-Y"',
            'endTo' => 'required|date_format:"d-m-Y"',
            'status' => 'required'
        ];
    }
}