<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CompanyBillingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('company/create', [CompanyController::class, 'store'])->name('api.company.create');
Route::get('company/{id}', [CompanyController::class, 'show'])->name('api.company.show');
Route::put('company/{id}', [CompanyController::class, 'update'])->name('api.company.update');
Route::delete('company/{id}', [CompanyController::class, 'destroy'])->name('api.company.destroy');

Route::apiResource('company-billings', CompanyBillingController::class);
Route::get('/company-billings/{id}', [CompanyBillingController::class, 'show']);
Route::delete('company-billings/{company_billing}', [CompanyBillingController::class, 'destroy'])->name('company-billings.destroy');

Route::get('company/{id}/with-billing', [CompanyController::class, 'showWithBilling'])->name('api.company.show.with.billing');
