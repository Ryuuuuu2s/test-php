<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string',
            'name_kana' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'tel' => 'sometimes|required|string',
            'representative_name' => 'sometimes|required|string',
            'representative_name_kana' => 'sometimes|required|string',
        ];
    }
}