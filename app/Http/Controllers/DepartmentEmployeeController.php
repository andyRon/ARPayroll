<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentEmployeeController extends Controller
{
    public function index(Request $request, Department $department)
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFields(['full_name', 'job_title', 'email'])
//            ->where('department_id', $department->id)
            ->whereBelongsTo($department)  // 两者等价 // TODO
            ->get();
        return EmployeeResource::collection($employees);
    }
}
