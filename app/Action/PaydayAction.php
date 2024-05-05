<?php

namespace App\Action;

use App\Models\Employee;

/**
 * 用于在薪酬日创建所有员工的薪资支票
 */
class PaydayAction
{
    public function execute()
    {
        foreach (Employee::all() as $employee) {
            $amount = $employee->payment_type->monthlyAmount();
            if ($amount == 0) {
                continue;
            }
            $employee->paychecks()->create([
               'net_amount' => $amount,
                'payed_at' => now(),
            ]);
        }
    }
}
