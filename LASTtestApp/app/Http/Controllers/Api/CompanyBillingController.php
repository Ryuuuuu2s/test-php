<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyBilling;
use App\Models\Company;

class CompanyBillingController extends Controller
{
    // 請求先情報の登録
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id', 
            'name' => 'required|string',
            'name_kana' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string',
            'department' => 'required|string',
            'billing_name' => 'required|string',
            'billing_name_kana' => 'required|string'
        ]);

        $billing = CompanyBilling::create($validatedData);
        return response()->json($billing, 201);
    }

    // 請求先情報の取得
    public function show($id)
    {
        $billing = CompanyBilling::find($id);
        if (!$billing) {
            return response()->json(['message' => 'Billing information not found.'], 404);
        }
        return response()->json($billing, 200);
    }

    
    // 請求先情報の更新
    public function update(Request $request, $id)
    {
        $billing = CompanyBilling::find($id);
        if (!$billing) {
            return response()->json(['message' => 'Billing information not found.'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'name_kana' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string',
            'department' => 'nullable|string',
            'billing_name' => 'nullable|string',
            'billing_name_kana' => 'nullable|string'
        ]);

        $billing->update($validatedData);
        return response()->json($billing, 200);
    }

    // 請求先情報の削除
    public function destroy($id)
    {
        $billing = CompanyBilling::findOrFail($id);
        $billing->delete();

        return response()->json(['message' => 'Billing information deleted successfully.'], 200);
    }
    
}