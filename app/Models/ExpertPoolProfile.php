<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertPoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'expertise_areas',
        'visibility',
        'cv_path',
        'summary',
        'consent_accepted',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consent_accepted' => 'boolean',
        ];
    }

    public const VISIBILITY_LABELS = [
        'miargem_only' => 'Yalnızca MİARGEM',
        'municipality_projects' => 'Belediye Projeleri',
        'all_requests' => 'Tüm Talepler',
    ];

    /** Kaydı oluşturan üye. */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
