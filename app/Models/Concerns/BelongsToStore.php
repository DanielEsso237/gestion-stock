<?php

namespace App\Models\Concerns;

use App\Models\Scopes\StoreScope;

trait BelongsToStore
{
    protected static function bootBelongsToStore(): void
    {
        static::addGlobalScope(new StoreScope);

        static::creating(function ($model) {
            if (auth()->check() && ! $model->store_id) {
                $model->store_id = auth()->user()->store_id;
            }
        });
    }
}