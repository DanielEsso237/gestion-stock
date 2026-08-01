<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = ['store_id', 'name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}