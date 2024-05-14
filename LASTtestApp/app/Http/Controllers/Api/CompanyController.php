<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function __construct(
        private Company $company
      ) {}

    /**
     * 会社情報の登録を行う
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'name_kana' => ['required', 'string'],
            'address' => ['required', 'string'],
            'tel' => ['required', 'string'],
            'representative_name' => ['required', 'string'],
            'representative_name_kana' => ['required', 'string'],
        ]);

        $this->company->fill($validated)->save();

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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string'],
            'name_kana' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'tel' => ['sometimes', 'string'],
            'representative_name' => ['sometimes', 'string'],
            'representative_name_kana' => ['sometimes', 'string'],
        ]);

        $company = Company::findOrFail($id);
        $company->fill($validated)->save();

        return response()->json(['message' => 'Updated successfully']);
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
