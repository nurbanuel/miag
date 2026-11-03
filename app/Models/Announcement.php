<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug;

    protected $fillable = ['featured_image', 'title', 'slug', 'category_label', 'category_id', 'content', 'href', 'is_featured', 'visibility_start', 'visibility_end', 'has_360_badge'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'visibility_start' => 'datetime',
            'visibility_end' => 'datetime',
            'has_360_badge' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Bağlantı alanı formda sorulmaz; boşsa başlıktan türetilir. Elle girilmiş mevcut
        // hedef adresler (ör. /proje-yarismasi) korunur.
        static::saving(function (Announcement $announcement) {
            if (blank($announcement->href) && filled($announcement->title)) {
                $announcement->href = Str::slug($announcement->title);
            }
        });
    }

    /**
     * Duyurunun yönlendirdiği ilgili sayfa (varsa): yalnızca site içi yol ("/...") veya tam adres
     * ise döner; başlıktan türetilmiş kısa ad bir sayfaya karşılık gelmediği için null döner.
     */
    public function getUrlAttribute(): ?string
    {
        $href = (string) $this->href;

        return Str::startsWith($href, ['/', 'http://', 'https://']) ? $href : null;
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
