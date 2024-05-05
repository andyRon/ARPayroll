<?php

namespace App\VOs;

class Money
{
    public function __construct(private readonly int $valueInCents)
    {
    }

    // 对外提供静态方法进行构建
    public static function from(int $valueCents): self
    {
        return new static($valueCents);
    }

    // 转化为美元格式
    public function toDollars(): string
    {
        return '$' . number_format($this->valueInCents / 100, 2);
    }

    // 金额数值（以分为单位，避免浮点运算对精度的丢失）
    public function toCents(): int
    {
        return $this->valueInCents;
    }
}
