<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function recipes()
    {
        return $this->hasMany(Recipe::class)->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
