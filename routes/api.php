<?php

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

Route::middleware('auth:api')->get('list', [App\Http\Controllers\Api\EmailController::class, 'index'])->name('api.list');
Route::middleware('auth:api')->post('send', [App\Http\Controllers\Api\EmailController::class, 'store'])->name('api.send');
