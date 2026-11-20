<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug, \App\Models\Concerns\HasPublishingFields;

    protected $fillable = [
        'category_id',
        'author_id',
        'slug',
        'title',
        'excerpt',
        'content',
        'featured_image',
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

    /**
     * Vatandaş Rehberi menüsünde listelenen kategoriler (slug parçaları).
     * Eşleşme slug üzerinden LIKE ile yapılır; Türkçe karakter/büyük-küçük harf farkından etkilenmez.
     */
    public const CITIZEN_GUIDE_CATEGORIES = [
        'rehber' => 'vatandas-rehberi',
        'bunlari-biliyor-musunuz' => 'biliyor-musunuz',
    ];

    public function scopeCitizenGuide($query, ?string $key = null)
    {
        $patterns = $key ? [self::CITIZEN_GUIDE_CATEGORIES[$key]] : array_values(self::CITIZEN_GUIDE_CATEGORIES);

        return $query->whereHas('category', function ($q) use ($patterns) {
            $q->where(function ($q) use ($patterns) {
                foreach ($patterns as $pattern) {
                    $q->orWhere('slug', 'like', '%'.$pattern.'%');
                }
            });
        });
    }

    public function scopeExcludingCitizenGuide($query)
    {
        return $query->whereNot(fn ($q) => $q->citizenGuide());
    }

    public function isCitizenGuide(): bool
    {
        $slug = (string) $this->category?->slug;

        foreach (self::CITIZEN_GUIDE_CATEGORIES as $pattern) {
            if (str_contains($slug, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * İçerikteki kelime sayısından (dakikada ~200 kelime) okuma süresi, ör. "4 dk okuma".
     */
    public function getReadingTimeAttribute(): string
    {
        $text = html_entity_decode(strip_tags((string) $this->content), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Türkçe karakterler kelime içi sayılsın diye ek karakter listesi verilir.
        $words = str_word_count($text, 0, 'çÇğĞıİöÖşŞüÜâÂîÎûÛ0123456789');

        return max(1, (int) ceil($words / 200)).' dk okuma';
    }

    protected static function booted(): void
    {
        // Eski "excerpt" sütunu (zorunlu) spot ile eşitlenir; mevcut kartlar/arama çalışmaya devam eder.
        static::saving(function (self $article) {
            if (filled($article->spot)) {
                $article->excerpt = $article->spot;
            } elseif (blank($article->excerpt)) {
                $article->excerpt = '';
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
