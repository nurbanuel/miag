<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyContent extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = [
        'category_id',
        'featured_image',
        'slug',
        'title',
        'summary',
        'content',
        'type',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public const TYPE_LABELS = [
        'mevzuat_etki_notu' => 'Mevzuat Etki Notu',
        'duzenleme_onerisi' => 'Düzenleme Önerisi',
        'politika_gundemi' => 'Politika Gündemi',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
