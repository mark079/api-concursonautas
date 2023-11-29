<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/goals', GoalController::class);
    Route::apiResource('/schedules', ScheduleController::class);
    Route::apiResource('/study-blocks', StudyBlockController::class);
});
