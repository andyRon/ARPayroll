<?php

namespace App\Action;

use App\DTOs\DepartmentData;
use App\Models\Department;

class CreateDepartmentAction
{
    // 处理实际业务逻辑：新建部门
    public function execute(DepartmentData $departmentData): Department
    {
        return Department::create([
           'name' => $departmentData->name,
            'description' => $departmentData->description,
        ]);
    }
}
