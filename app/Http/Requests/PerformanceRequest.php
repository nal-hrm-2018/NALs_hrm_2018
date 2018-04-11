<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:55 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PerformanceRequest extends FormRequest
{
    public function rules(){
        return [
            'title' => 'required',
            'point' => 'required|numeric'
        ];
    }
}