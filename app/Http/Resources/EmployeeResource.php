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
            'email' => $this->email,
            'jobTitle' => $this->job_title,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => $this->payment_type->amount(),
            ],
        ];
    }
}
