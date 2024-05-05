<?php

namespace App\Http\Requests;

use App\Enums\PaymentTypes;
use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpsertEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getDepartment(): Department
    {
        return Department::where('uuid', $this->departmentId)->firstOrFail();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($this->employee),
            ],
            'departmentId' => ['required', 'string', 'exists:departments,uuid'],
            'jobTitle' => ['required', 'string'],
            'paymentType' => [
                'required',
                new Enum(PaymentTypes::class),
            ],
            'salary' => ['required_if:paymentType,salary', 'integer', 'min:0', 'not_in:0'],
            'hourlyRate' => ['required_if:paymentType,hourlyRate', 'integer', 'min:0', 'not_in:0'],
        ];
    }
}
