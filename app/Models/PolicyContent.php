<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyContent extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug, \App\Models\Concerns\HasPublishingFields;

    protected $fillable = [
        'category_id',
        'featured_image',
        'slug',
        'title',
        'summary',
        'content',
        'type',
        'published_at',
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
            'published_at' => 'datetime',
        ];
    }

    public const TYPE_LABELS = [
        'mevzuat_etki_notu' => 'Mevzuat Etki Notu',
        'duzenleme_onerisi' => 'Düzenleme Önerisi',
        'politika_gundemi' => 'Politika Gündemi',
    ];

    protected static function booted(): void
    {
        // Eski "summary" sütunu (zorunlu) spot ile eşitlenir.
        static::saving(function (self $content) {
            if (filled($content->spot)) {
                $content->summary = $content->spot;
            } elseif (blank($content->summary)) {
                $content->summary = '';
            }
        });
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
