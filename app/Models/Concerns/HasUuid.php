<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * 用于需要UUID字段的模型
 */
trait HasUuid
{
    public static function bootHasUuid(): void
    {
        Model::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
