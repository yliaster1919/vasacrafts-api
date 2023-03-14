<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('auth')->group(function()
{
    Route::post('signup',[AuthController::class,'sign_up']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout'])->middleware('auth:api');

});
Route::prefix('client')->group(function()
{
    Route::post('add',[ClientController::class,'add'])->middleware('auth:api');;
    Route::post('update',[ClientController::class,'update'])->middleware('auth:api');;
    Route::delete('delete',[ClientController::class,'delete'])->middleware('auth:api');
    Route::get('',[ClientController::class,'fetch'])->middleware('auth:api');
    Route::get('all',[ClientController::class,'all'])->middleware('auth:api');
});
Route::prefix('account')->group(function()
{
    Route::post('{id}/update',[AccountController::class,'update'])->middleware('auth:api');
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}',[AuthController::class, 'verify_email'])->middleware(['signed'])->name('verification.verify');

