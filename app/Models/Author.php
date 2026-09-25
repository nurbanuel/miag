<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = [
        'slug',
        'name',
        'title',
        'bio',
        'avatar_path',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    protected function slugSourceColumn(): string
    {
        return 'name';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
