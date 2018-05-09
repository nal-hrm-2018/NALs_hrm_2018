<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 2:01 PM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class TeamEditRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    public function rules(){
        return[
            'team_name' => 'required|max:50|nullable',
            'po_name' => 'required|max:50|nullable',
            'member_select' => 'required'
        ];
    }
    public  function messages()
    {
        return [
            'team_name.required' => trans('validation.required', [
                'attribute' => 'Team Name'
            ]),
            'team_name.max' => trans('validation.max.string', [
                'attribute' => 'Team Name'
            ]),
            'team_name.nullable' => trans('validation.required', [
                'attribute' => 'Team Name'
            ]),

            'po_name.required' => trans('validation.required', [
                'attribute' => 'PO Name'
            ]),
            'po_name.max' => trans('validation.max.string', [
                'attribute' => 'PO Name'
            ]),
            'po_name.nullable' => trans('validation.required', [
                'attribute' => 'PO Name'
            ]),
        ];
    }

}