<?php

use App\Http\Controllers\UserReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/dashboard/users', [UserReportController::class, 'dashboard_users'])->name('dash_users');
Route::get('/v1/users/yearly', [UserReportController::class, 'user_yearly'])->name('users.yearly');
