<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', function () {
    return ['message' => 'Hello from API!']; 
});

Route::middleware('auth:sanctum')->prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::get('{id}', [TaskController::class, 'show']);
    Route::put('{id}', [TaskController::class, 'update']);
    Route::delete('{id}', [TaskController::class, 'destroy']);
});