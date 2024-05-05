<?php

namespace App\Http\Resources;

use App\VOs\Amount;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class PaycheckResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'amount' => Amount::from($this->net_amount)->toArray(),
            'payed_at' => $this->payed_at
        ];
    }

    public function toId(Request $request)
    {
        return $this->uuid;
    }

    public function toRelationships(Request $request): array
    {
        return [
            'employee' => fn() => EmployeeResource::make($this->employee)
        ];
    }
}
