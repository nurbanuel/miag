<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Kurumların personel talebi. İş başvurularından (HrApplication) bağımsızdır;
 * adaylardan CV toplanmaz, yalnızca talebi açıklayan ek belge saklanır.
 */
class HrPersonnelRequest extends Model
{
    use HasFactory;

    public const WORK_STATUS_LABELS = [
        'memur' => 'Memur',
        'sozlesmeli' => 'Sözleşmeli Personel',
        'kadrolu_isci' => 'Kadrolu İşçi',
        'gecici_isci' => 'Geçici İşçi',
        'sirket_personeli' => 'Belediye Şirketi Personeli',
        'diger' => 'Diğer',
    ];

    public const EDUCATION_LEVEL_LABELS = [
        'farketmez' => 'Fark etmez',
        'lise' => 'Lise',
        'on_lisans' => 'Ön Lisans',
        'lisans' => 'Lisans',
        'yuksek_lisans' => 'Yüksek Lisans',
        'doktora' => 'Doktora',
    ];

    /** Kurumsal e-posta için kabul edilmeyen kişisel sağlayıcılar. */
    public const PUBLIC_EMAIL_DOMAINS = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com', 'icloud.com', 'yandex.com', 'live.com'];

    protected $fillable = [
        'user_id',
        'institution_name',
        'institution_type',
        'unit',
        'authorized_person_name',
        'authorized_person_title',
        'corporate_email',
        'requested_position_title',
        'work_status',
        'personnel_count',
        'work_location',
        'education_level',
        'accepted_programs',
        'profession_title',
        'minimum_experience',
        'job_description',
        'mandatory_conditions',
        'preferred_conditions',
        'deadline_date',
        'application_channel',
        'additional_document_path',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'personnel_count' => 'integer',
            'deadline_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /** Yayında olan talepler: aktif ve son başvuru tarihi geçmemiş. */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('is_active', true)->whereDate('deadline_date', '>=', today());
    }

    /** Süresi dolmuş veya pasife alınmış talepler. */
    public function scopeExpiredOrInactive(Builder $query): Builder
    {
        return $query->where(fn (Builder $q) => $q->where('is_active', false)->orWhereDate('deadline_date', '<', today()));
    }

    public function isCurrent(): bool
    {
        return $this->is_active && $this->deadline_date?->gte(today());
    }

    /** Kaydı oluşturan üye. */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
