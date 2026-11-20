<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'full_name',
        'institution',
        'department',
        'title',
        'email',
        'phone',
        'is_mts_subscriber',
    ];

    protected function casts(): array
    {
        return [
            'is_mts_subscriber' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        // Pasif (yayından kaldırılmış) etkinliklerin kayıtları da panelde görünsün.
        return $this->belongsTo(Event::class)->withoutGlobalScope('active');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
