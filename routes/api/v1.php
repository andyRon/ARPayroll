<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentEmployeeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePaycheckController;
use App\Http\Controllers\PaydayController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employees', EmployeeController::class);

Route::get('departments/{department}/employees', [DepartmentEmployeeController::class, 'index']
)->name('department.employees.index');

Route::post('paycheck', [PaydayController::class, 'store']
)->name('payday.store');

Route::get('employees/{employee}/paychecks', [EmployeePaycheckController::class, 'index']
)->name('employee.paychecks.index');


Route::get('/test', function () {
    return \route('payday.store');

//    $development = Department::factory(['name' => 'Development3', 'description' => 'dev is very good3'])->create();
//
//    print_r(route('departments.show', ['department' => $development]));
//    $department = getJson(route('departments.show', ['department' => $development]))
//        ->json('data');
//    print_r(12);
////    print_r($department);

});
