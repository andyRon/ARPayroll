<?php

namespace App\VOs;

// 对 Money 值对象进一步进行封装，让资源类中的调用代码更精简
class Amount
{
    public function __construct(private readonly Money $cents, private readonly Money $dollars)
    {
    }

    public static function from(int $valueInCents): self
    {
        return new static(Money::from($valueInCents), Money::from($valueInCents)); // TODO
    }

    public function toArray(): array
    {
        return [
            'cents' => $this->cents->toCents(),
            'dollars' => $this->dollars->toDollars(),
        ];
    }
}
