<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\DoctorMasterController;
use App\Http\Controllers\Masters\DoctorTimingController;
use App\Http\Controllers\Masters\FeesMasterController;
use App\Http\Controllers\Masters\TestMasterController;
use App\Http\Controllers\Masters\GroupTestMasterController;
use App\Http\Controllers\Masters\ProfileMasterController;
use App\Http\Controllers\Masters\RoomMasterController;
use App\Http\Controllers\Masters\UserAccessController;
use App\Http\Controllers\Masters\UserMasterController;

Route::group(['prefix' => 'masters',], function () {
    Route::apiResource('doctor-master', DoctorMasterController::class)->middleware('auth:DocMas');
    Route::apiResource('doctor-timing', DoctorTimingController::class)->middleware('auth:DocTim');
    Route::apiResource('fees-master', FeesMasterController::class)->middleware('auth:FeesMas');
    Route::get('test-master/tests', [TestMasterController::class, 'getTests'])->middleware('auth:TestMas');
    Route::apiResource('test-master', TestMasterController::class)->middleware('auth:TestMas');
    Route::get('group-test-master/tests', [GroupTestMasterController::class, 'getTests'])->middleware('auth:GroupTMas');
    Route::apiResource('group-test-master', GroupTestMasterController::class)->middleware('auth:GroupTMas');
    Route::get('profile-master/profiles', [ProfileMasterController::class,'getProfiles'])->middleware('auth:ProfMas');
    Route::apiResource('profile-master', ProfileMasterController::class)->middleware('auth:ProfMas');
    Route::apiResource('room-master', RoomMasterController::class)->middleware(['auth:RoomMas','compress']);
    Route::apiResource('user-master', UserMasterController::class)->middleware('auth:UserMas');
    Route::apiResource('user-access', UserAccessController::class)->middleware('auth:UserAcc');
});
