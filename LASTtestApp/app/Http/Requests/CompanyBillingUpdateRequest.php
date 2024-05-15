<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyBillingUpdateRequest extends FormRequest
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
            'department' => 'nullable|string',
            'billing_name' => 'nullable|string',
            'billing_name_kana' => 'nullable|string'
        ];
    }
}