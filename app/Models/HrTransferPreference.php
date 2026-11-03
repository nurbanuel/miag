<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrTransferPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'hr_application_id',
        'sort_order',
        'province',
        'district',
        'institution',
        'position',
        'available_from',
        'available_until',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'available_from' => 'date',
            'available_until' => 'date',
        ];
    }

    public function hrApplication(): BelongsTo
    {
        return $this->belongsTo(HrApplication::class);
    }
}
