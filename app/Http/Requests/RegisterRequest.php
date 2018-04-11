<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:28 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(){
        return [
            'username' => 'required|max:255',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ];
    }
}