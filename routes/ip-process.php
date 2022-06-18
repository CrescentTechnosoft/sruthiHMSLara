<?php

use App\Http\Controllers\IPProcess\AdmissionController;
use App\Http\Controllers\IPProcess\DischargeController;
use App\Http\Controllers\IPProcess\HistoryController;
use App\Http\Controllers\IPProcess\TreatmentController;
use App\Http\Controllers\IPProcess\WardShiftingController;
use App\Http\Controllers\IPProcess\WardStatusController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'ip-process',
], function () {
    Route::group(['prefix' => 'admission', 'middleware' => 'auth:IPAdm'], function () {
        Route::get('', [AdmissionController::class, 'index']);
        Route::get('patient-details', [AdmissionController::class, 'getPatientDetails']);
        Route::get('wards', [AdmissionController::class, 'getWards']);
        Route::post('', [AdmissionController::class, 'store']);
        Route::get('years', [AdmissionController::class, 'getYears']);
        Route::get('ip-nos/{year}', [AdmissionController::class, 'getIpNos']);
        Route::get('admission-details/{id}', [AdmissionController::class, 'show']);
        Route::patch('{id}', [AdmissionController::class, 'update']);
        Route::delete('{id}', [AdmissionController::class, 'destroy']);
        Route::get('revert', [AdmissionController::class, 'getRevert']);
        Route::get('search', [AdmissionController::class, 'search']);
    });

    Route::group(['prefix' => 'treatment', 'middleware' => 'auth:IPTre'], function () {
        Route::get('', [TreatmentController::class, 'index']);
        Route::get('ip-nos/{year}', [TreatmentController::class, 'getIPNos']);
        Route::get('patient-details/{id}', [TreatmentController::class, 'getPatientDetails']);
        Route::get('fees-cost/{id}', [TreatmentController::class, 'getFeesCost']);
        Route::get('test-cost/{id}', [TreatmentController::class, 'getTestCost']);
        Route::get('group-test-cost/{id}', [TreatmentController::class, 'getGroupTestCost']);
        Route::get('profile-cost/{id}', [TreatmentController::class, 'getProfileCost']);
        Route::post('', [TreatmentController::class, 'store']);
        Route::get('old-ip-nos/{year}', [TreatmentController::class, 'getOldIpNos']);
        Route::get('ref-nos/{ip_id}', [TreatmentController::class, 'getRefNos']);
        Route::get('{id}', [TreatmentController::class, 'show']);
        Route::patch('{id}', [TreatmentController::class, 'update']);
        Route::delete('{id}', [TreatmentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'history', 'middleware' => 'auth:IPHis'], function () {
        Route::get('', [HistoryController::class, 'index']);
        Route::get('ip-nos/{year}', [HistoryController::class, 'getIpNos']);
        Route::get('{id}', [HistoryController::class, 'show']);
        Route::get('search/{search}', [HistoryController::class, 'searchPatients']);
    });

    Route::get('ward-status', [WardStatusController::class, 'getWardStatus'])->middleware(['auth:WardStat', 'compress']);

    Route::group(['prefix' => 'ward-shift', 'middleware' => 'auth:WardShift'], function () {
        Route::get('', [WardShiftingController::class, 'index']);
        Route::get('ip-nos/{year}', [WardShiftingController::class, 'getIpNos']);
        Route::get('{id}', [WardShiftingController::class, 'show']);
        Route::post('', [WardShiftingController::class, 'store']);
    });

    Route::group(['prefix' => 'discharge', 'middleware' => 'auth:IPDis'], function () {
        Route::get('', [DischargeController::class, 'index']);
        Route::get('ip-nos/{year}', [DischargeController::class, 'getIpNos']);
        Route::get('patient-details/{id}', [DischargeController::class, 'getPatientDetails']);
        Route::post('', [DischargeController::class, 'store']);
        Route::get('discharge-nos/{year}', [DischargeController::class, 'getDischargeNos']);
        Route::get('discharge-details/{id}', [DischargeController::class, 'getDischargeDetails']);
        Route::patch('{id}', [DischargeController::class, 'update']);
        Route::delete('{id}', [DischargeController::class, 'destroy']);
    });
});
