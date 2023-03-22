<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\HealthWorkerController;
use App\Http\Controllers\ScheduleController;

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
Route::resource('schedule', ScheduleController::class);
Route::get('list-health-worker', [HealthWorkerController::class, 'listHealthWorker']);
Route::resource('health-worker', HealthWorkerController::class);
Route::resource('medical-service', MedicalServiceController::class);
Route::resource('service-request', ServiceRequestController::class);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
