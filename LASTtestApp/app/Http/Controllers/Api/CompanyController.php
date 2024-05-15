<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    public function __construct(
        private Company $company
      ) {}

    /**
     * 会社情報の登録を行う
     */
    public function store(CompanyStoreRequest $request)
    {
        $this->company->fill($request->validated())->save();
        return ['message' => 'ok'];
    }

    /**
     * 会社情報の詳細を取得する
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    /**
     * 会社情報の更新を行う
     */
     public function update(CompanyUpdateRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->fill($request->validated())->save();
        return response()->json(['message' => 'ok']);
    }

    /**
     * 会社情報の削除を行う
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(['message' => 'ok']);
    }

    /**
     * 会社情報と請求先情報を同時に取得
     */
    public function showWithBilling($id)
    {
        $company = Company::with('billing')->findOrFail($id);
        return response()->json($company);
    }

    
}
