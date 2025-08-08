<?php

use App\Modules\Course\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('courses', CourseController::class);
});