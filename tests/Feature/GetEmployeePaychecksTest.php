<?php

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\Paycheck;

// 获取员工薪资记录

it('should return all paychecks for an employee', function () {
    $employee = Employee::factory([
        'payment_type' => PaymentTypes::SALARY->value
    ])->create();

    Paycheck::factory([
        'empployee_id' => $employee->id,
    ])->count(5)->create();

    $paychecks = getJson(route('employee.paychecks.index', ['employee' => $employee, 'include' => 'employee']))
        ->json('data');

    expect($paychecks)->toHaveCount(5);
    expect($paychecks)
        ->each(fn ($paycheck) => $paycheck->relationships->employee->data->id->toBe($employee->uuid));
});
