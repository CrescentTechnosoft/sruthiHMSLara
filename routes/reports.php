<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\IPReportsController;
use App\Http\Controllers\Reports\RegistrationsController;
use App\Http\Controllers\Reports\OverallCollectionController;
use App\Http\Controllers\Reports\MonthlyCollectionsController;

Route::group(['prefix' => 'reports', 'middleware' => 'auth'], function () {
    Route::get('overall-collections/{start_date}/{end_date}/{base?}', [OverallCollectionController::class, 'index']);
    Route::get('monthly-collections/{year}/{month}/{base?}', [MonthlyCollectionsController::class, 'index']);
    Route::get('registrations/{start_date}/{end_date}/{base?}', [RegistrationsController::class, 'index']);
    Route::get('ip-reports/{type}/{start_date}/{end_date}/{base?}', [IPReportsController::class, 'index']);
});
