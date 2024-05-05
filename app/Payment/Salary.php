<?php

namespace App\Payment;

use App\Enums\PaymentTypes;
use App\Payment\PaymentType;

class Salary extends PaymentType
{

    public function monthlyAmount(): int
    {
        return $this->employee->salary / 12;
    }

    public function type(): string
    {
        return PaymentTypes::SALARY->value;
    }

    public function amount(): int
    {
        return $this->employee->salary;
    }
}
