<?php

namespace App\Models\Concerns;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * İçerik modülleri için ortak alanlar:
 * - is_active: pasif içerikler silinmeden ön yüzden gizlenir (global scope).
 *   Yönetim paneli bu kapsamı kaldırarak tüm kayıtları görür.
 * - sub_category_id: ana kategoriye bağlı alt kategori.
 * - spot: giriş paragrafı (lead).
 */
trait HasPublishingFields
{
    public static function bootHasPublishingFields(): void
    {
        static::addGlobalScope('active', fn (Builder $query) => $query->where($query->qualifyColumn('is_active'), true));
    }

    public function initializeHasPublishingFields(): void
    {
        $this->mergeFillable(['spot', 'sub_category_id', 'is_active']);
        $this->mergeCasts(['is_active' => 'boolean']);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    /** Giriş paragrafı: spot; yoksa modülün eski özet alanı. */
    public function getLeadAttribute(): ?string
    {
        $lead = $this->spot;

        if (blank($lead)) {
            foreach (['excerpt', 'summary'] as $column) {
                if (array_key_exists($column, $this->attributes) && filled($this->attributes[$column])) {
                    return $this->attributes[$column];
                }
            }
        }

        return filled($lead) ? $lead : null;
    }
}
