<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        // TODO
        Model::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
