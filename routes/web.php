<?php

use App\Http\Controllers\Others\DashboardController;
use App\Http\Controllers\Security\AuthController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

// Route::get('/', function () {
// return view('welcome');
// });

Route::get('initialize', function () {
    return response('Application Initialized!!!')
        ->header('Content-Type', 'text/plain');
});

Route::group(['prefix' => 'auth'], function () {
    Route::patch('/clear', [AuthController::class, 'clearUserSession']);
    Route::post('validate', [AuthController::class, 'validateLogin']);
    Route::get('authenticate-user', [AuthController::class, 'authenticateUser']);
});

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware('auth:Dashboard');

require 'masters.php';

require 'reception.php';

require 'out_patients.php';

require 'cash-counter.php';

require 'ip-process.php';

require 'lab.php';

require 'extras.php';

require 'printouts.php';

require 'reports.php';
