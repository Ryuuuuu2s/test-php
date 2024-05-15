<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyBilling;
use App\Models\Company;
use App\Http\Requests\CompanyBillingStoreRequest;
use App\Http\Requests\CompanyBillingUpdateRequest;


class CompanyBillingController extends Controller
{
    // 請求先情報の登録
    public function store(CompanyBillingStoreRequest $request, $company_id)
    {
        $company = Company::findOrFail($company_id);
        $billing = $company->billings()->create($request->validated());
        return response()->json($billing, 201);
    }

   // 請求先情報の取得
    public function show($id)
    {
        $billing = CompanyBilling::findOrFail($id);
        return response()->json($billing, 200);
    }
    
    // 請求先情報の更新
    public function update(CompanyBillingUpdateRequest $request, $id)
    {
        $billing = CompanyBilling::findOrFail($id);
        $billing->update($request->validated());
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