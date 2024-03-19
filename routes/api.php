<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/employees', [EmployeeController::class, 'all']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);

Route::get('/contracts', [ContractController::class, 'all']);
Route::post('/contracts', [ContractController::class, 'create']);
Route::put('/contracts/{id}', [ContractController::class, 'update']);

Route::get('/certifications', [CertificationController::class, 'all']);
