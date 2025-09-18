<?php

use App\Http\Controllers\API\CompanyController;


Route::post('/register', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::put('/companies/{company}', [CompanyController::class, 'update']);
Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);


Route::post('/companies/switch/{company}', [CompanyController::class, 'switchCompany']);
});
