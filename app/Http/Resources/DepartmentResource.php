<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

/**
 * 封装响应的JSON数据
 */
class DepartmentResource extends JsonApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
//    public function toArray(Request $request): array
//    {
//        return parent::toArray($request);
//    }

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'employees' => fn() => EmployeeResource::collection($this->employees)
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => route('departments.show', ['department' => $this->uuid]),
        ];
    }
}
