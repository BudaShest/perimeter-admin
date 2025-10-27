<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->group(function () { //todo bb
    // API для получения расписаний
    Route::get('/schedules/today', [ScheduleController::class, 'getTodaySchedules']);
    Route::get('/schedules/by-date', [ScheduleController::class, 'getSchedulesByDate']);
//});
