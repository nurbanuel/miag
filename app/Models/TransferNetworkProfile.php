<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferNetworkProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_title',
        'current_institution',
        'target_locations',
        'experience_years',
        'summary',
        'contact_email',
        'is_identity_revealed',
        'consent_accepted',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_identity_revealed' => 'boolean',
            'consent_accepted' => 'boolean',
        ];
    }

    /** Kaydı oluşturan üye. */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
