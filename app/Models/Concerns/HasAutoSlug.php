<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasAutoSlug
{
    /** Slug'ın üretileceği sütun adı; gerekirse modelde ezilir. */
    protected function slugSourceColumn(): string
    {
        return 'title';
    }

    protected static function bootHasAutoSlug(): void
    {
        static::creating(function ($model) {
            $source = $model->slugSourceColumn();
            if (blank($model->slug) && filled($model->{$source})) {
                $model->slug = $model->makeUniqueSlug($model->{$source});
            }
        });

        static::updating(function ($model) {
            $source = $model->slugSourceColumn();
            if ($model->isDirty($source) && filled($model->{$source})) {
                $model->slug = $model->makeUniqueSlug($model->{$source});
            }
        });
    }

    protected function makeUniqueSlug(string $value): string
    {
        // Slug sütunu varchar(255); uzun başlıklarda sonek için yer bırakacak şekilde kısaltılır.
        $base = rtrim(Str::limit(Str::slug($value), 200, ''), '-') ?: 'kayit';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($this->exists, fn ($q) => $q->whereKeyNot($this->getKey()))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
