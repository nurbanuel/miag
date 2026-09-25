<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = [
        'category_id',
        'featured_image',
        'slug',
        'title',
        'category_label',
        'summary',
        'content',
        'key_findings',
        'cover_color',
        'file_path',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
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
