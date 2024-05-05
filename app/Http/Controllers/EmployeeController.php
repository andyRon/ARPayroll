<?php

namespace App\Http\Controllers;

use App\Action\UpsertEmployeeAction;
use App\DTOs\EmployeeData;
use App\Http\Requests\UpsertEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function __construct(private readonly UpsertEmployeeAction $upsertEmployee) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(UpsertEmployeeRequest $request)
    {
        $employee = $this->upsertEmployee->execute(
            new Employee(),
            EmployeeData::fromRequest($request)
        );

        return EmployeeResource::make($employee)->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(UpsertEmployeeRequest $request, Employee $employee): Response
    {
        $employee = $this->upsertEmployee->execute($employee, EmployeeData::fromRequest($request));
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
