<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:48 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function rules(){
        return [
            'teamName' => 'required',
            'POName' => 'required'
        ];
    }
}