<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MİARGEM Uzman ve Araştırmacı Havuzu kaydı. İK kayıtlarından (HrApplication vb.) tamamen
 * bağımsızdır; değerlendirme notları yalnızca yöneticilere aittir ve adayla paylaşılmaz.
 */
class ExpertPool extends Model
{
    use HasFactory;

    protected $table = 'expert_pools';

    public const STATUSES = ['Bekliyor', 'İnceleniyor', 'Havuza Alındı', 'İleride Değerlendirilecek', 'Uygun Bulunmadı'];

    public const EDUCATION_LEVEL_LABELS = [
        'lisans' => 'Lisans',
        'yuksek_lisans' => 'Yüksek Lisans',
        'doktora' => 'Doktora',
        'on_lisans' => 'Ön Lisans',
        'diger' => 'Diğer',
    ];

    public const ACADEMIC_TITLES = ['Araştırma Görevlisi', 'Öğretim Görevlisi', 'Dr. Öğretim Üyesi', 'Doçent', 'Profesör'];

    public const EXPERTISE_AREAS = [
        'yerel_yonetim_hukuku' => 'Yerel Yönetim Hukuku',
        'kamu_maliyesi' => 'Kamu Maliyesi ve Bütçe',
        'imar_sehircilik' => 'İmar ve Şehircilik',
        'insan_kaynaklari' => 'İnsan Kaynakları ve Kurumsal Kapasite',
        'dijital_donusum' => 'Dijital Dönüşüm ve E-Belediye',
        'sosyal_politika' => 'Sosyal Politika ve Hizmetler',
        'cevre_iklim' => 'Çevre, Enerji ve İklim',
        'ulasim' => 'Ulaşım ve Altyapı',
        'afet_yonetimi' => 'Afet ve Risk Yönetimi',
        'katilim_yonetisim' => 'Katılım ve Yönetişim',
        'kent_ekonomisi' => 'Yerel Ekonomi ve Kalkınma',
        'istatistik_veri' => 'İstatistik ve Veri Bilimi',
    ];

    public const CONTRIBUTION_TYPES = [
        'arastirma' => 'Araştırma',
        'veri_analizi' => 'Veri Analizi',
        'mevzuat_incelemesi' => 'Mevzuat İncelemesi',
        'yayin' => 'Yayın / Yazı',
        'egitim' => 'Eğitim',
        'hakemlik' => 'Hakemlik',
        'proje' => 'Proje Çalışmaları',
    ];

    public const LINK_TYPES = [
        'yayin' => 'Yayın',
        'proje' => 'Proje',
        'rapor' => 'Rapor',
        'sunum' => 'Sunum / Eğitim',
        'profil' => 'Akademik / Mesleki Profil',
        'diger' => 'Diğer',
    ];

    public const CONTRIBUTION_PERIODS = [
        'proje_bazli' => 'Proje bazlı',
        'kisa_sureli' => 'Kısa süreli (3 aya kadar)',
        'duzenli' => 'Düzenli (dönemsel)',
        'uzun_sureli' => 'Uzun süreli',
    ];

    public const WORK_FORMATS = [
        'uzaktan' => 'Uzaktan',
        'yerinde' => 'Yerinde',
        'hibrit' => 'Hibrit',
    ];

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'current_institution',
        'actual_duty',
        'unit',
        'expertise_summary',
        'education_level',
        'university',
        'faculty',
        'department',
        'graduation_year',
        'profession_title',
        'academic_title',
        'academic_duty',
        'expertise_areas',
        'contribution_types',
        'total_experience',
        'local_gov_experience',
        'experience_links',
        'foreign_languages',
        'digital_tools',
        'contribution_period',
        'work_format',
        'cv_path',
        'profile_visibility',
        'status',
        'evaluation_notes',
    ];

    protected $attributes = [
        'profile_visibility' => false,
        'status' => 'Bekliyor',
    ];

    protected function casts(): array
    {
        return [
            'expertise_areas' => 'array',
            'contribution_types' => 'array',
            'experience_links' => 'array',
            'foreign_languages' => 'array',
            'graduation_year' => 'integer',
            'profile_visibility' => 'boolean',
        ];
    }
}
