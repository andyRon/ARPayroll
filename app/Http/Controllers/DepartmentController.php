<?php

namespace App\Http\Controllers;

use App\Action\CreateDepartmentAction;
use App\Action\UpdateDepartmentAction;
use App\DTOs\DepartmentData;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        public readonly CreateDepartmentAction $createDepartment,
        public readonly UpdateDepartmentAction $updateDepartment
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DepartmentResource::collection(Department::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $departmentData = new DepartmentData(...$request->validated()); // TODO
        $department = $this->createDepartment->execute($departmentData);
        return DepartmentResource::make($department)->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return DepartmentResource::make($department);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $departmentData = new DepartmentData(...$request->validated());
        $department = $this->updateDepartment->execute($department, $departmentData);

        return response()->noContent();  // PUT请求没有响应 Body，所有不需要资源类包装响应数据。
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
