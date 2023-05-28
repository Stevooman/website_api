<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CompaniesController::class)->group(function () {
  Route::get('companies', 'index')->name('companies.index');
  Route::get('companies/{companyId}', 'showOne')->name('companies.showOne');
  Route::get('activeCompanies', 'showAllActive')->name('companies.showAllActive');
  Route::post('companies', 'create')->name('companies.create');
  Route::put('companies/{companyId}', 'update')->name('companies.update');
  Route::delete('companies/{companyId}', 'delete')->name('companies.delete');
});
