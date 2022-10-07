<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);
Route::middleware('auth:sanctum')->get('/authUser',[\App\Http\Controllers\AuthController::class, 'authUser']);
Route::middleware('auth:sanctum')->post('/logout',[\App\Http\Controllers\AuthController::class, 'logout']);

