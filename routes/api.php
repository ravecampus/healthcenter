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
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\MedicineDispenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministratorController;

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



Route::middleware('auth:sanctum')->group(function () {
    Route::post('schedule-visible', [ScheduleController::class, 'scheduleVisble']);
    Route::get('list-schedule', [ScheduleController::class, 'listOfSchedule']);
    Route::resource('schedule', ScheduleController::class);
    Route::get('list-health-worker', [HealthWorkerController::class, 'listHealthWorker']);
    Route::resource('health-worker', HealthWorkerController::class);
    Route::resource('medical-service', MedicalServiceController::class);
    Route::get('user-medication', [ServiceRequestController::class,'doneMedication']);
    Route::get('previous-med/{id}', [ServiceRequestController::class,'previousMed']);
    Route::get('completed-sr', [ServiceRequestController::class,'completedSR']);
    Route::post('mark-absent', [ServiceRequestController::class,'markAbsent']);
    Route::get('confirm-cancel/{id}', [ServiceRequestController::class,'confirmCancel']);
    Route::get('service-request-auth', [ServiceRequestController::class,'authRequest']);
    Route::get('service-request-complete/{id}', [ServiceRequestController::class,'completeService']);
    Route::post('add-service-request', [ServiceRequestController::class, 'addServiceRequest']);
    Route::resource('service-request', ServiceRequestController::class);
    Route::get('medicine-list', [MedicineController::class,'listOfMedicine']);
    Route::resource('medicine', MedicineController::class);
    Route::get('patient-list', [PatientController::class, 'listPatient']);
    Route::resource('patient', PatientController::class);
    Route::get('check-consult/{id}', [ConsultationController::class,'checkConsult']);
    Route::resource('consultation', ConsultationController::class);
    Route::resource('diagnosis', DiagnosisController::class);
    Route::resource('purok',PurokController::class);
    Route::resource('medicine-dispense',MedicineDispenseController::class);
    Route::get('dashboard',[DashboardController::class,'numberOfDash']);
    Route::resource('admin',AdministratorController::class);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
