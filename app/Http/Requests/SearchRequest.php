<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 11:07 PM
 */

namespace App\Http\Requests;


class SearchRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return[];
    }

    public function messages()
    {
        return[];
    }
}