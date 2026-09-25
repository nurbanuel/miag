<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = ['name', 'slug', 'description'];

    protected function slugSourceColumn(): string
    {
        return 'name';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
