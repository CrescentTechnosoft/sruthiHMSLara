<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Others\PrintoutController;

Route::group(['prefix' => 'printouts', 'middleware' => 'auth'], function () {
    Route::get('registration/{id}', [PrintoutController::class, 'generateRegistrationSheet']);
    Route::get('op-bill/{id}/{type}', [PrintoutController::class, 'generateOPBillReceipt']);
    Route::get('ip-bill/{id}/{type}', [PrintoutController::class, 'generateIPBillReceipt']);
    Route::get('prescription/{id}', [PrintoutController::class, 'generatePrescription']);
    Route::post('op-lab-report', [PrintoutController::class, 'generateOpLabResult']);
    Route::post('ip-lab-report', [PrintoutController::class, 'generateIpLabResult']);
    Route::get('ip-admission/{id}', [PrintoutController::class, 'generateIPCaseSheet']);
    Route::get('ip-discharge/{id}', [PrintoutController::class, 'generateDischargeSummary']);
    Route::get('advance/{id}', [PrintoutController::class, 'generateAdvanceReceipt']);
});
