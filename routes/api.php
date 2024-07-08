<?php

    use App\Http\Controllers;
    use Illuminate\Support\Facades\Route;

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


    Route::middleware('auth:sanctum')->post('userSearch',
        Controllers\Api\User\UserSearchApiController::class)->name('api.get.userData');
    Route::post('registerNewUser', Controllers\Api\User\RegisterUserApiController::class)->name('send.registerNew');
    Route::post('loginNew', Controllers\Api\Auth\LoginUserApiController::class)->name('send.loginNew');
    Route::middleware('auth:sanctum')->post('createSchedule',
        Controllers\Api\Schedule\CreateScheduleApiController::class)->name('create.schedule');
    Route::middleware('auth:sanctum')->post('deleteSchedule',
        Controllers\Api\Schedule\DeleteScheduleApiController::class)->name('apidelete.schedule');
    Route::middleware('auth:sanctum')->post('updateWorkHour',
        Controllers\Api\WorkHour\UpdateWorkHourApiController::class)->name('update.workhour');
    Route::middleware('auth:sanctum')->post('logout',
        Controllers\Api\Auth\LogoutUserApiController::class)->name('logout.user');
    Route::middleware('auth:sanctum')->post('updateUser',
        Controllers\Api\User\UserUpdatePasswordApiController::class)->name('update.user');
