<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Jobs\JobsController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Middleware\RoleEmployee;
use App\Http\Middleware\RoleJobseeker;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/health-check', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/jobs', [JobsController::class, 'index']); // public
Route::get('/jobs/{id}', [JobsController::class, 'getJobByUserID']);
Route::get('/applications/{id}', [ApplicationController::class, 'getApplicationByUserID']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs', [JobsController::class, 'store']); // employee
    Route::post('/applications', [ApplicationController::class, 'apply']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
