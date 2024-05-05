<?php

namespace App\Http\Resources;

use App\VOs\Amount;
use App\VOs\Money;
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
                'amount' => Amount::from($this->payment_type->amount())->toArray()
            ],
        ];
    }

    // 将返回的 Id 换成 Uuid
    public function toId(Request $request)
    {
        return $this->uuid;
    }
}
