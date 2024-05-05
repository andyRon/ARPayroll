<?php

namespace App\Action;

use App\DTOs\DepartmentData;
use App\Models\Department;

class CreateDepartmentAction
{
    public function execute(DepartmentData $departmentData): Department
    {
        return Department::create([
           'name' => $departmentData->name,
            'description' => $departmentData->description,
        ]);
    }
}
