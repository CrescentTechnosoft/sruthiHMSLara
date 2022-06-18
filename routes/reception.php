<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reception\AppointmentsController;
use App\Http\Controllers\Reception\PatientsListController;
use App\Http\Controllers\Reception\RegistrationController;
use App\Http\Controllers\Reception\UpdateController;

Route::group(['prefix' => 'reception'], function () {
    Route::apiResource('registration', RegistrationController::class)
        ->middleware('auth:Reg');

    Route::group(['prefix' => 'patients-list', 'middleware' => ['auth:List', 'compress']], function () {
        Route::get('', [PatientsListController::class, 'index']);
        Route::get('profile/{id}', [PatientsListController::class, 'show']);
        Route::delete('{id}', [PatientsListController::class, 'destroy']);
    });

    Route::apiResource('update-patient', UpdateController::class)->middleware('auth:PtUpd');

    //Seperate Route due to api resource route
    Route::get('appointments/patient-details/{id}', [AppointmentsController::class, 'getPatientDetails'])
        ->middleware('auth:appts');
    Route::get('appointments/search', [AppointmentsController::class, 'searchPatients'])
        ->middleware('auth:appts');
    Route::apiResource('appointments', AppointmentsController::class)->middleware('auth:appts');
});
