<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * İK ve Kariyer ortak başvurusu (personel talebi, nakil, iş / staj).
 * Uzman Havuzu'ndan bağımsızdır; kayıtlar oraya otomatik aktarılmaz.
 */
class HrApplication extends Model
{
    use HasFactory;

    public const TYPE_LABELS = [
        'personel_talebi' => 'Personel Talebi',
        'nakil' => 'Nakil',
        'is_staj' => 'İş / Staj',
    ];

    public const STATUSES = ['Alındı', 'İnceleniyor', 'Ek Bilgi Bekleniyor', 'Sonuçlandı'];

    public const APPLICATION_KIND_LABELS = [
        'is' => 'İş Başvurusu',
        'staj' => 'Staj Başvurusu',
    ];

    public const INTERNSHIP_TYPES = ['Zorunlu', 'İsteğe Bağlı'];

    public const STAFF_TITLES = [
        'Memur', 'Şef', 'Uzman', 'Müdür', 'Müdür Yardımcısı', 'Mühendis', 'Mimar', 'Şehir Plancısı',
        'Tekniker', 'Teknisyen', 'Avukat', 'Veteriner Hekim', 'Tabip', 'Hemşire', 'Sosyal Çalışmacı',
        'Psikolog', 'Bilgisayar İşletmeni', 'Programcı', 'Çözümleyici', 'Zabıta Memuru', 'Zabıta Komiseri',
        'İtfaiye Eri', 'İtfaiye Çavuşu', 'Ayniyat Saymanı', 'Mali Hizmetler Uzmanı', 'İç Denetçi',
    ];

    public const WORK_STATUS_LABELS = [
        'calisiyor' => 'Çalışıyor',
        'calismiyor' => 'Çalışmıyor',
        'ogrenci' => 'Öğrenci',
    ];

    /** Nakil başvurusundaki çalışma statüleri. */
    public const TRANSFER_WORK_STATUS_LABELS = [
        'memur_657' => '657 sayılı Kanun’a tabi Memur',
        'sozlesmeli_4b' => 'Sözleşmeli Personel (4/B)',
        'kadrolu_isci' => 'Kadrolu İşçi',
        'sirket_personeli' => 'Belediye Şirketi Personeli',
        'diger' => 'Diğer',
    ];

    /** Hizmet sınıfı ve derece yalnızca bu statülerde sorulur. */
    public const CIVIL_SERVANT_STATUSES = ['memur_657'];

    public const SERVICE_CLASSES = [
        'GİH' => 'Genel İdare Hizmetleri (GİH)',
        'THS' => 'Teknik Hizmetler (THS)',
        'SHS' => 'Sağlık Hizmetleri (SHS)',
        'AHS' => 'Avukatlık Hizmetleri (AHS)',
        'YHS' => 'Yardımcı Hizmetler (YHS)',
        'EÖH' => 'Eğitim-Öğretim Hizmetleri (EÖH)',
        'DHS' => 'Din Hizmetleri (DHS)',
        'EMN' => 'Emniyet Hizmetleri (EMN)',
        'MAH' => 'Mülki İdare Amirliği Hizmetleri (MAH)',
    ];

    public const JOB_SEARCH_STATUS_LABELS = [
        'aktif' => 'Aktif olarak arıyor',
        'acik' => 'Fırsatlara açık',
        'aramiyor' => 'Aramıyor',
    ];

    public const INSTITUTION_TYPE_LABELS = [
        'buyuksehir_belediyesi' => 'Büyükşehir Belediyesi',
        'il_belediyesi' => 'İl Belediyesi',
        'ilce_belediyesi' => 'İlçe Belediyesi',
        'belde_belediyesi' => 'Belde Belediyesi',
        'il_ozel_idaresi' => 'İl Özel İdaresi',
        'mahalli_idare_birligi' => 'Mahallî İdare Birliği',
        'belediye_sirketi' => 'Belediye Şirketi',
        'diger' => 'Diğer',
    ];

    protected $fillable = [
        'tracking_number',
        'type',
        'status',
        'application_kind',
        'full_name',
        'email',
        'phone',
        'professional_title',
        'staff_title',
        'actual_duty',
        'unit',
        'work_status',
        'job_search_status',
        'institution_type',
        'contact_info_public',
        'cv_public',
        'desired_position',
        'location_preferences',
        'experience_details',
        'start_date',
        'cv_path',
        'portfolio_path',
        'internship_school',
        'internship_department',
        'internship_type',
        'internship_start_date',
        'internship_end_date',
        'school_documents_path',
        'consent_accepted',
        'current_institution',
        'service_class',
        'degree',
        'total_service_time',
        'current_institution_time',
        'local_gov_experience',
        'expertise_areas',
        'transfer_reason',
        'share_current_institution',
        'share_contact_info',
        'is_active',
        'communication_stage',
        'evaluation_stage',
    ];

    protected $attributes = [
        'status' => 'Alındı',
        'contact_info_public' => false,
        'cv_public' => false,
        'share_current_institution' => false,
        'share_contact_info' => false,
        'is_active' => true,
    ];

    protected static function booted(): void
    {
        // Her başvuruya benzersiz bir takip numarası verilir (ör. IK-2026-7KQ2MX).
        static::creating(function (HrApplication $application) {
            if (blank($application->tracking_number)) {
                do {
                    $number = 'IK-'.now()->format('Y').'-'.Str::upper(Str::random(6));
                } while (static::where('tracking_number', $number)->exists());

                $application->tracking_number = $number;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'contact_info_public' => 'boolean',
            'cv_public' => 'boolean',
            'consent_accepted' => 'boolean',
            'share_current_institution' => 'boolean',
            'share_contact_info' => 'boolean',
            'is_active' => 'boolean',
            'location_preferences' => 'array',
            'start_date' => 'date',
            'internship_start_date' => 'date',
            'internship_end_date' => 'date',
        ];
    }

    public function educations(): HasMany
    {
        return $this->hasMany(HrEducation::class);
    }

    /** Nakil tercihleri, öncelik sırasına göre. */
    public function transferPreferences(): HasMany
    {
        return $this->hasMany(HrTransferPreference::class)->orderBy('sort_order');
    }

    /** Tüm statü seçenekleri (iş başvurusu + nakil), panel gösterimi için. */
    public static function allWorkStatusLabels(): array
    {
        return self::WORK_STATUS_LABELS + self::TRANSFER_WORK_STATUS_LABELS;
    }
}
