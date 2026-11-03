<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrEducation extends Model
{
    use HasFactory;

    protected $table = 'hr_educations';

    public const LEVEL_LABELS = [
        'lise' => 'Lise',
        'on_lisans' => 'Ön Lisans',
        'lisans' => 'Lisans',
        'yuksek_lisans' => 'Yüksek Lisans',
        'doktora' => 'Doktora',
    ];

    public const STUDENT_STATUS_LABELS = [
        'ogrenci' => 'Öğrenci',
        'mezun' => 'Mezun',
    ];

    protected $fillable = [
        'hr_application_id',
        'education_level',
        'student_status',
        'university',
        'faculty',
        'department',
        'graduation_year',
        'current_class',
        'expected_graduation_date',
    ];

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'expected_graduation_date' => 'date',
        ];
    }

    public function hrApplication(): BelongsTo
    {
        return $this->belongsTo(HrApplication::class);
    }
}
