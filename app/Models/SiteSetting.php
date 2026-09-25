<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_menu',
        'footer_about_text',
        'footer_quick_links',
        'footer_legal_links',
        'footer_copyright_text',
    ];

    protected function casts(): array
    {
        return [
            'header_menu' => 'array',
            'footer_quick_links' => 'array',
            'footer_legal_links' => 'array',
        ];
    }
}
