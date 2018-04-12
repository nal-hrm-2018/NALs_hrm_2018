<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:44 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    public function rules(){
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
            'full_name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:10,11',
            'married' => 'required',
            'company' => 'required',
            'birthday' => 'required|date_format:"d-m-Y"'
        ];
    }
}