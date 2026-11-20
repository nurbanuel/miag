<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug, \App\Models\Concerns\HasPublishingFields;

    protected $fillable = [
        'category_id',
        'featured_image',
        'slug',
        'title',
        'sub_category',
        'category_label',
        'summary',
        'content',
        'key_findings',
        'cover_color',
        'file_path',
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

    public const SUB_CATEGORIES = ['Rapor' => 'Rapor', 'Analiz' => 'Analiz'];

    /**
     * Kartlardaki tür etiketi: "RAPOR" / "ANALİZ" (Türkçe büyük harf; i → İ).
     */
    public function getTypeLabelAttribute(): string
    {
        $label = __($this->sub_category ?: 'Rapor');

        if (app()->getLocale() === 'tr') {
            $label = str_replace(['i', 'ı'], ['İ', 'I'], $label);
        }

        return mb_strtoupper($label, 'UTF-8');
    }

    public function isAnalysis(): bool
    {
        return $this->sub_category === 'Analiz';
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
