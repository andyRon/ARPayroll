<?php

namespace App\Payment;

use App\Enums\PaymentTypes;
use App\Payment\PaymentType;

class HourlyRate extends PaymentType
{

    public function monthlyAmount(): int
    {
        return 0;
    }

    public function type(): string
    {
        return PaymentTypes::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        return $this->employee->hourly_rate;
    }
}
