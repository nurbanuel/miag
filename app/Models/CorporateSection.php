<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorporateSection extends Model
{
    public const DISPLAY_TYPES = [
        'standard' => 'Standart Metin',
        'mission_vision' => 'Misyon, Vizyon ve Öncelikler',
        'cards' => 'Kart Izgarası (Değerler vb.)',
        'accordion' => 'Akordeon Alt Başlıklar',
        'team' => 'Danışma Kurulu ve Kadro Listesi',
    ];

    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'display_type',
        'content',
        'items',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Hangi ekrandan eklenirse eklensin bölüm "Sayfalar > Kurumsal" kaydına bağlanır.
        static::creating(function (self $section) {
            $section->page_id ??= Page::where('slug', 'kurumsal')->value('id');
        });
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
