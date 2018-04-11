<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:18 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(){
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}