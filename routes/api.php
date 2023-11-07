<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceInformationController;
use App\Http\Controllers\AppCrashController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\LikeController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

######################## auth
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);

######################## esqueci minha senha
Route::post('/password/email', [PasswordResetController::class, 'forgot']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

######################## device_information
Route::middleware('auth:sanctum')->put('/users/device_information', [DeviceInformationController::class, 'update']);

######################## app-crash
Route::post('/app-crash', [AppCrashController::class, 'store']);
Route::middleware('auth:sanctum')->get('/app-crash/{appCrash}', [AppCrashController::class, 'show']);
Route::middleware('auth:sanctum')->get('/app-crash', [AppCrashController::class, 'index']);

######################## settings
Route::get('/settings/{key}', [AppSettingController::class, 'show']);
Route::get('/settings', [AppSettingController::class, 'index']);
Route::middleware('auth:sanctum')->put('/settings/{key}', [AppSettingController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/settings/{key}', [AppSettingController::class, 'destroy']);

######################## users
Route::post('/users', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->get('/users/{user}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/cards', [UserController::class, 'cards']);
Route::middleware('auth:sanctum')->put('/users/{user}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('/email-check', [UserController::class, 'registeredEmail'])
->middleware('throttle:20,1'); // 5 solicitações por minuto;

######################## likes
Route::middleware('auth:sanctum')->post('/like', [LikeController::class, 'store']);

######################## dislikes
Route::middleware('auth:sanctum')->post('/dislike', [LikeController::class, 'store']);

