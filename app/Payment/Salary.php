<?php

namespace App\Payment;

use App\Enums\PaymentTypes;
use App\Payment\PaymentType;

class Salary extends PaymentType
{

    public function monthlyAmount(): int
    {
        // TODO: Implement monthlyAmount() method.
        return 0;
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
