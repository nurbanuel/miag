<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobInternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_type',
        'full_name',
        'email',
        'field_of_interest',
        'cv_path',
        'message',
        'consent_accepted',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consent_accepted' => 'boolean',
        ];
    }

    public const APPLICANT_TYPE_LABELS = [
        'yeni_mezun' => 'Yeni Mezun',
        'deneyimli' => 'Deneyimli Aday',
        'stajyer' => 'Stajyer',
    ];
}
