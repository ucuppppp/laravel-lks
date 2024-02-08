<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\VaccinationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/consultations', [ConsultationController::class, 'store']);
    Route::get('/consultations', [ConsultationController::class, 'show']);

    Route::get('/spots', [SpotController::class, 'index']);
    Route::get('/spots/{id}', [SpotController::class, 'show']);

    Route::post('/vaccinations', [VaccinationController::class, 'register']);
    Route::get('/vaccinations', [VaccinationController::class, 'index']);


});
