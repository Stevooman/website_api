<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SystemsController;
use App\Http\Controllers\UsersController;

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

// Companies
Route::controller(CompaniesController::class)->group(function () {
  Route::get('companies', 'index')->name('companies.index');
  Route::get('companies/{companyId}', 'showOne')->name('companies.showOne');
  Route::get('activeCompanies', 'showAllActive')->name('companies.showAllActive');
  Route::post('companies', 'create')->name('companies.create');
  Route::put('companies/{companyId}', 'update')->name('companies.update');
  Route::delete('companies/{companyId}', 'delete')->name('companies.delete');
});

// Systems
Route::controller(SystemsController::class)->group(function () {
  Route::get('systems', 'index')->name('systems.index');
  Route::get('systems/{systemId}', 'showOne')->name('systems.showOne');
  Route::get('systemReleases', 'showDateRange')->name('systems.showDateRange');
  Route::post('systems', 'create')->name('systems.create');
  Route::put('systems/{systemId}', 'update')->name('systems.update');
  Route::delete('systems/{systemId}', 'delete')->name('systems.delete');
});

// Users
Route::controller(UsersController::class)->group(function () {
  Route::get('users', 'index')->name('users.index');
  Route::get('users/{userId}', 'showOne')->name('users.showOne');
  Route::get('login', 'showByUsernamePassword')->name('users.showByUsernamePassword');
  Route::post('users', 'create')->name('users.create');
  Route::put('email/users/{userId}', 'updateEmail')->name('users.updateEmail');
  Route::put('password/users/{userId}', 'updatePassword')->name('users.updatePassword');
  Route::put('username/users/{userId}', 'updateUsername')->name('users.updatePassword');
  Route::delete('users/{userId}', 'delete')->name('users.delete');
});

// Zelda Users
Route::controller(ZeldaUsersController::class)->group(function () {
  Route::get('users/{userId}/LoZ', 'showOne')->name('zeldausers.showOne');
  Route::post('users/LoZ', 'create')->name('zeldausers.create');
  Route::delete('users/{userId}/LoZ', 'delete')->name('zeldausers.delete');
});
