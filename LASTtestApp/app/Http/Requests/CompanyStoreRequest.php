<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'name_kana' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string',
            'representative_name' => 'required|string',
            'representative_name_kana' => 'required|string',
        ];
    }
}