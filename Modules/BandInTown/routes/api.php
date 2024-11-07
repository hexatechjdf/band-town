<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\BandInTown\App\Http\Controllers\Api\IndexController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('bandintown', fn(Request $request) => $request->user())->name('bandintown');
});


Route::get('/bandintown/dummy', [IndexController::class, 'dummy'])->name('api.bandintown.dummy');
Route::POST('/bandintown/data', [IndexController::class, 'index'])->name('api.bandintown.data');
Route::get('/bandintown/script', [IndexController::class, 'script'])->name('api.bandintown.script');
