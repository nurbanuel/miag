<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'full_name',
        'email',
        'institution',
        'message',
        'status',
    ];

    public const TYPE_LABELS = [
        'rapor_analiz' => 'Rapor / Analiz Desteği',
        'veri' => 'Veri Katkısı',
        'etkinlik' => 'Etkinlik İş Birliği',
        'yazi_iletisim' => 'Yazı / İletişim',
    ];
}
