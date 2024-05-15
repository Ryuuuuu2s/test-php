<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyBillingStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'name_kana' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string',
            'department' => 'required|string',
            'billing_name' => 'required|string',
            'billing_name_kana' => 'required|string'
        ];
    }
}