<?php

namespace App\Models;

use App\Models\Concerns\HasAutoSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, HasAutoSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'banner_title',
        'banner_subtitle',
        'banner_description',
        'sidebar_content',
    ];

    public function corporateSections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CorporateSection::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
