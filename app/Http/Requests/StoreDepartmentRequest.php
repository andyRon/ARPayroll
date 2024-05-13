<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// 专门处理新建部门的表单请求类
class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:departments|max:50',
            'description' => 'string'
        ];
    }
}
