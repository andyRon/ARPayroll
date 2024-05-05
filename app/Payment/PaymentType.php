<?php

namespace App\Payment;

use App\Models\Employee;

/**
 * 把每种支付类型都抽象成独立的策略类，其中包含类型、总包、月付金额等方法
 */
abstract class PaymentType
{
    public function __construct(protected readonly Employee $employee)
    {
    }

    abstract public function monthlyAmount(): int;
    abstract public function type(): string;
    abstract public function amount(): int;
}
