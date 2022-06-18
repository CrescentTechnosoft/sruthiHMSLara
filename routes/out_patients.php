<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutPatient\OPRegistrationController;
use App\Http\Controllers\OutPatient\PrescriptionController;

Route::group(['prefix' => 'out-patients'], function () {
    Route::group(['prefix' => 'op-registration', 'middleware' => 'auth:OPReg'], function () {
        Route::get('', [OPRegistrationController::class, 'index']);
        Route::get('patient-details', [OPRegistrationController::class, 'getPatientDetails']);
        Route::get('ids', [OPRegistrationController::class, 'getIds']);
        Route::post('', [OPRegistrationController::class, 'store']);
        Route::get('years', [OPRegistrationController::class, 'getYears']);
        Route::get('op-nos', [OPRegistrationController::class, 'getOPNos']);
        Route::get('observation-details', [OPRegistrationController::class, 'getObservationDetails']);
        Route::patch('{id}', [OPRegistrationController::class, 'update']);
        Route::delete('{id}', [OPRegistrationController::class, 'destroy']);
    });

    Route::group(['prefix' => 'prescription', 'middleware' => 'auth:Presc'], function () {
        Route::get('', [PrescriptionController::class, 'index'])->middleware('compress');
        Route::get('op-nos', [PrescriptionController::class, 'getOPNos']);
        Route::get('observation-details', [PrescriptionController::class, 'getObservationDetails']);
        Route::post('', [PrescriptionController::class, 'store']);
        Route::get('presc-nos', [PrescriptionController::class, 'getPrescNos']);
        Route::get('{id}', [PrescriptionController::class, 'show']);
        Route::patch('{id}', [PrescriptionController::class, 'update']);
        Route::delete('{id}', [PrescriptionController::class, 'destroy']);
    });
});
