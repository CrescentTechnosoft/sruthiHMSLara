<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashCounter\OPBillingController;
use App\Http\Controllers\CashCounter\IPAdvanceController;
use App\Http\Controllers\CashCounter\IPBillingController;

Route::group(['prefix' => 'cash-counter'], function () {
    Route::group(['prefix' => 'op-billing', 'middleware' => 'auth:OPBill'], function () {
        Route::get('', [OPBillingController::class, 'index'])->middleware('compress');
        Route::get('ids', [OPBillingController::class, 'getIds']);
        Route::get('search-patients', [OPBillingController::class, 'searchPatients']);
        Route::get('patient-details/{id}', [OPBillingController::class, 'getPatientDetails']);
        Route::get('fees-cost/{id}', [OPBillingController::class, 'getFeesCost']);
        Route::get('test-cost/{id}', [OPBillingController::class, 'getTestCost']);
        Route::get('group-test-cost/{id}', [OPBillingController::class, 'getGroupTestCost']);
        Route::get('profile-cost/{id}', [OPBillingController::class, 'getProfileCost']);
        Route::post('', [OPBillingController::class, 'store']);
        Route::get('years', [OPBillingController::class, 'getYears']);
        Route::get('billnos/{year}', [OPBillingController::class, 'getBillNos']);
        Route::get('{id}', [OPBillingController::class, 'show']);
        Route::patch('{id}', [OPBillingController::class, 'update'])->middleware('auth:update');
        Route::delete('{id}', [OPBillingController::class, 'destroy'])->middleware('auth:delete');
    });

    Route::group(['prefix' => 'ip-advance', 'middleware' => 'auth:IPAdv'], function () {
        Route::get('', [IPAdvanceController::class, 'index']);
        Route::get('ip-nos/{year}', [IPAdvanceController::class, 'getIPNos']);
        Route::get('{ip_id}', [IPAdvanceController::class, 'getAdvanceDetails']);
        Route::post('', [IPAdvanceController::class, 'store']);
        Route::patch('{id}', [IPAdvanceController::class, 'update']);
        Route::delete('{id}', [IPAdvanceController::class, 'destroy']);
    });

    Route::group(['prefix' => 'ip-billing', 'middleware' => 'auth:IPBill'], function () {
        Route::get('', [IPBillingController::class, 'index']);
        Route::get('ip-nos/{year}', [IPBillingController::class, 'getIpNos']);
        Route::get('treatments/{ip_id}', [IPBillingController::class, 'getTreatments']);
        Route::post('', [IPBillingController::class, 'store']);
        Route::get('bill-nos/{year}', [IPBillingController::class, 'getBillNos']);
        Route::get('bill-details/{id}', [IPBillingController::class, 'show']);
        Route::patch('{id}', [IPBillingController::class, 'update']);
        Route::delete('{id}', [IPBillingController::class, 'destroy']);
    });
});
