<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lab\OPLabController;
use App\Http\Controllers\Lab\IPLabController;

Route::group(['prefix' => 'lab'], function () {
    Route::group(['prefix' => 'op-lab', 'middleware' => 'auth:OPL'], function () {
        Route::get('', [OPLabController::class, 'index']);
        Route::get('bill-nos', [OPLabController::class, 'getBillNos']);
        Route::get('search', [OPLabController::class, 'searchPatient']);
        Route::get('{id}', [OPLabController::class, 'show']);
        Route::post('', [OPLabController::class, 'store']);
        Route::delete('{id}', [OPLabController::class, 'destroy']);
    });

    Route::group(['prefix' => 'ip-lab', 'middleware' => 'auth:IPL'], function () {
        Route::get('', [IPLabController::class, 'index']);
        Route::get('search/{key}', [IPLabController::class,'searchPatient']);
        Route::get('ip-nos/{year}', [IPLabController::class, 'getIPNos']);
        Route::get('{treatment_id}', [IPLabController::class, 'show']);
        Route::post('', [IPLabController::class, 'store']);
        Route::delete('{id}', [IPLabController::class, 'destroy']);
    });
});
