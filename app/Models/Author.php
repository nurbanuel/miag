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

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? asset('storage/'.$this->avatar_path) : null;
    }

    public function getInitialsAttribute(): string
    {
        return static::initialsFor((string) $this->name);
    }

    /**
     * Ad soyaddan iki harfli baş harf (unvanlar atlanır): "Dr. Can Emre MEMİŞ" -> "CM".
     */
    public static function initialsFor(string $name): string
    {
        $parts = collect(preg_split('/\s+/u', trim($name)))
            ->filter(fn ($p) => $p !== '' && ! preg_match('/^(dr|av|prof|doç|doc|öğr|ogr|uzm|arş|ars|gör|gor)\.?$/iu', $p))
            ->values();

        if ($parts->isEmpty()) {
            return 'M';
        }

        $letters = $parts->count() > 1 ? [$parts->first(), $parts->last()] : [$parts->first()];

        return collect($letters)
            ->map(fn ($p) => mb_strtoupper(str_replace('i', 'İ', mb_substr($p, 0, 1)), 'UTF-8'))
            ->implode('');
    }

    /**
     * Biyografi HTML'i: zengin metin olduğu gibi; eski düz metin kayıtlar satır sonları korunarak.
     */
    public function getBioHtmlAttribute(): ?string
    {
        $bio = trim((string) $this->bio);

        if ($bio === '') {
            return null;
        }

        return $bio === strip_tags($bio) ? '<p>'.nl2br(e($bio)).'</p>' : $bio;
    }

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
