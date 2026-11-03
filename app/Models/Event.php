<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = [
        'category_id',
        'featured_image',
        'slug',
        'title',
        'description',
        'location',
        'speakers',
        'poster_path',
        'registration_url',
        'starts_at',
        'is_past',
        'is_featured',
        'visibility_start',
        'visibility_end',
        'has_360_badge',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'visibility_start' => 'datetime',
            'visibility_end' => 'datetime',
            'has_360_badge' => 'boolean',
            'starts_at' => 'datetime',
            'is_past' => 'boolean',
            'speakers' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
