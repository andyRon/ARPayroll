<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('departments', \App\Http\Controllers\DepartmentController::class);
