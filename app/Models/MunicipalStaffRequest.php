<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalStaffRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'municipality_name',
        'contact_name',
        'contact_email',
        'position_title',
        'employment_status',
        'min_experience',
        'work_location',
        'description',
        'attachment_path',
        'consent_accepted',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consent_accepted' => 'boolean',
        ];
    }

    public const EMPLOYMENT_STATUS_LABELS = [
        'memur' => 'Memur',
        'sozlesmeli' => 'Sözleşmeli Personel',
        'isci' => 'İşçi',
        'diger' => 'Diğer',
    ];

    /** Kaydı oluşturan üye. */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
