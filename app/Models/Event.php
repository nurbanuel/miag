<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, \App\Models\Concerns\HasAutoSlug, \App\Models\Concerns\HasPublishingFields;

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

    public function registrations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /** Kayıt açık mı: geçmiş olarak işaretlenmemiş ve başlangıç zamanı geçmemiş etkinlikler. */
    public function isRegistrationOpen(): bool
    {
        return ! $this->is_past && ($this->starts_at === null || $this->starts_at->isFuture());
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
