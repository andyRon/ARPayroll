<?php

namespace App\Enums;

use App\Models\Employee;
use App\Payment\HourlyRate;
use App\Payment\PaymentType;
use App\Payment\Salary;

/**
 * 员工工资支付方式：
 * - 工薪制：每月支付日，按年薪/12发放薪资给员工
 * - 小时工：每月支付日，按工作时长（小时）x时薪发放薪资给员工
 */
enum PaymentTypes: string
{
    case SALARY = 'salary';
    case HOURLY_RATE = 'hourlyRate';

    /**
     * 采用工厂模式基于枚举值创建支付类型对应的策略类实例
     * @param Employee $employee
     * @return PaymentType
     */
    public function makePaymentType(Employee $employee): PaymentType
    {
        return match ($this) {      // TODO
            self::SALARY => new Salary($employee),
            self::HOURLY_RATE => new HourlyRate($employee)
        };
    }
}
