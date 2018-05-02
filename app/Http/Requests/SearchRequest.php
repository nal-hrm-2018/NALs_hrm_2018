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
        return[
            'number_record_per_page' => 'integer|min:1',
        ];

    }

    public function messages()
    {
        return[
            'number_record_per_page.min' => trans('asd')
        ];

    }
}