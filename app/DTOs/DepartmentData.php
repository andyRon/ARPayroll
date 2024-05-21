<?php

namespace App\DTOs;

/**
 * 封装新建部门的请求数据
 */
class DepartmentData
{
    public function __construct(
        public readonly string $name,
        public readonly  ?string $description // 只读。类型为string或null
    ) {}
}
