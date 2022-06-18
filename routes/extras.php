<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtrasController;

Route::group(['prefix' => 'extras', 'middleware' => 'auth'], function () {
    Route::post('test-category', [ExtrasController::class, 'addTestCategory']);
    Route::delete('test-category/{category}', [ExtrasController::class, 'removeTestCategory']);

    Route::post('specialization', [ExtrasController::class, 'addSpecialization']);
    Route::delete('specialization/{specialization}', [ExtrasController::class, 'removeSpecialization']);
    Route::post('department', [ExtrasController::class, 'addDepartment']);
    Route::delete('department/{department}', [ExtrasController::class, 'removeDepartment']);
    Route::post('complaint', [ExtrasController::class, 'addComplaint']);
    Route::delete('complaint/{complaint}', [ExtrasController::class, 'removeComplaint']);
    Route::post('treatment', [ExtrasController::class, 'addTreatment']);
    Route::delete('treatment/{treatment}', [ExtrasController::class, 'removeTreatment']);

    Route::post('pay-type', [ExtrasController::class, 'addPayType']);
    Route::delete('pay-type/{payType}', [ExtrasController::class, 'removePayType']);

    Route::post('card-type', [ExtrasController::class, 'addCardType']);
    Route::delete('card-type/{cardType}', [ExtrasController::class, 'removeCardType']);
    
    Route::post('insurance-category', [ExtrasController::class, 'addInsuranceCategory']);
    Route::delete('insurance-category/{category}', [ExtrasController::class, 'removeInsuranceCategory']);
});
