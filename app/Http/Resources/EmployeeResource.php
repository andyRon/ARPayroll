<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->full_name,
            'job_title' => $this->job_title,
            'payment_type' => $this->payment_type,
            'salary' => $this->salary,
        ];
    }
}
