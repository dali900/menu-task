<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\OrderController;
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

Route::prefix('/currencies')->group(function () {
    Route::get('/', [CurrencyController::class, 'getAll']);
    Route::get('/quote/{currency}/{amount}', [CurrencyController::class, 'getQuote']);
});
Route::prefix('/orders')->group(function () {
    Route::post('/purchase', [OrderController::class, 'purchase']);
});