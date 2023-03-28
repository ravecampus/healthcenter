<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\HealthWorkerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;

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
Route::resource('user-auth', UserController::class);
Route::post('auth-password', [AuthController::class, 'changePassword']);
Route::post('auth-signin', [AuthController::class, 'signin']);
Route::resource('auth', AuthController::class);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('schedule-visible', [ScheduleController::class, 'scheduleVisble']);
Route::get('list-schedule', [ScheduleController::class, 'listOfSchedule']);
Route::resource('schedule', ScheduleController::class);
Route::get('list-health-worker', [HealthWorkerController::class, 'listHealthWorker']);
Route::resource('health-worker', HealthWorkerController::class);
Route::resource('medical-service', MedicalServiceController::class);
Route::get('service-request-auth', [ServiceRequestController::class,'authRequest']);
Route::resource('service-request', ServiceRequestController::class);
Route::resource('medicine', MedicineController::class);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
