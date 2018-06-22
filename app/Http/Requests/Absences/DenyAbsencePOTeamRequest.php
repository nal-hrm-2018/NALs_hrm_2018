<?php

use Illuminate\Foundation\Http\FormRequest;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/20/2018
 * Time: 11:00 AM
 */

class DenyAbsencePOTeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}