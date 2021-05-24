<?php

use App\Http\Controllers\AuthContoller;

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AuthContoller::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('authenticatedUser',  [AuthContoller::class, 'user']);
    Route::get('getUserTransactions',  [TransactionsController::class, 'get']);
    Route::post('addTransaction',  [TransactionsController::class, 'create']);
    Route::get('getUserProfile',  [UserController::class, 'get']);
    Route::post('updateUserProfile', [UserController::class, 'update']);
    Route::post('logout',  [AuthContoller::class, 'logout']);
});



