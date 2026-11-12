<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Kurumsal',
                'banner_title' => 'KURUMSAL',
                'banner_subtitle' => 'Hakkımızda',
                'banner_description' => 'MİARGEM, belediye yöneticileri, çalışanları, akademisyenler, araştırmacılar ve yerel yönetim uzmanları için bağımsız bir araştırma, yayın, veri ve katılım merkezidir.',
                'content' => <<<'HTML'
                    <h2 class="text-xl font-bold text-navy-900">İlkelerimiz</h2>
                    <ul class="mt-4 grid gap-3 sm:grid-cols-2 list-none pl-0">
                        <li class="flex items-start gap-2 rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><svg class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z" clip-rule="evenodd"/></svg> Bağımsızlık ve tarafsızlık</li>
                        <li class="flex items-start gap-2 rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><svg class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z" clip-rule="evenodd"/></svg> Kanıta dayalı araştırma</li>
                        <li class="flex items-start gap-2 rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><svg class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z" clip-rule="evenodd"/></svg> Açıklık ve şeffaflık</li>
                        <li class="flex items-start gap-2 rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><svg class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z" clip-rule="evenodd"/></svg> Yerel yönetimlerle iş birliği</li>
                    </ul>

                    <h2 class="mt-10 text-xl font-bold text-navy-900">Araştırma Yöntemi</h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-600">Çalışmalarımız; saha araştırması, resmi veri kaynaklarının analizi, karşılaştırmalı vaka incelemeleri ve uzman görüşmelerini bir araya getiren karma bir yöntemle yürütülür. Tüm raporlarımızda kaynaklar ve metodoloji açıkça belirtilir.</p>

                    <h2 class="mt-10 text-xl font-bold text-navy-900">Faaliyet Raporları</h2>
                    <p class="mt-4 text-sm text-navy-600">Yıllık faaliyet raporlarımız yakında bu bölümde yayımlanacaktır.</p>
                    HTML,
                'sidebar_content' => <<<'HTML'
                    <h2 class="text-xl font-bold text-navy-900">Yönetim ve Danışma Kurulu</h2>
                    <ul class="mt-4 space-y-3 list-none pl-0">
                        <li class="rounded-lg border border-navy-100 p-4">
                            <p class="font-semibold text-navy-900">Prof. Dr. Ayşe Yıldız</p>
                            <p class="text-sm text-navy-500">Yönetim Kurulu Başkanı</p>
                        </li>
                        <li class="rounded-lg border border-navy-100 p-4">
                            <p class="font-semibold text-navy-900">Dr. Elif Arslanoğlu</p>
                            <p class="text-sm text-navy-500">Araştırma Direktörü</p>
                        </li>
                        <li class="rounded-lg border border-navy-100 p-4">
                            <p class="font-semibold text-navy-900">Mert Kaya</p>
                            <p class="text-sm text-navy-500">Danışma Kurulu Üyesi</p>
                        </li>
                    </ul>
                    HTML,
            ],
            [
                'title' => 'Rapor ve Analizler',
                'banner_title' => 'RAPOR VE ANALİZLER',
                'banner_subtitle' => 'Rapor ve Analizler',
                'banner_description' => 'Yerel yönetimler için üretilen araştırma çıktılarını filtreleyin ve inceleyin.',
                'content' => '<p class="text-sm text-navy-600">Yayımlanan tüm rapor ve analizlere bu bölümden ulaşabilirsiniz.</p>',
            ],
            [
                'title' => 'Yazılar',
                'banner_title' => 'YAZILAR',
                'banner_subtitle' => 'Yazılar',
                'banner_description' => "Uzmanların imzalı kişisel değerlendirmeleri. Bu bölümdeki yazılar yazarların kişisel değerlendirmelerini içerir ve MİARGEM'in kurumsal görüşünü temsil etmez.",
                'content' => '<p class="text-sm text-navy-600">Yayımlanan tüm yazılara bu bölümden ulaşabilirsiniz.</p>',
            ],
            [
                'title' => 'İK ve Kariyer - Genel Bakış',
                'banner_title' => 'İK VE KARİYER',
                'banner_subtitle' => 'İK ve Kariyer Platformu',
                'banner_description' => 'Kullanıcı gizliliğine ve kontrollü eşleşmeye dayalı dört modül aracılığıyla belediyeleri, personeli ve uzmanları bir araya getiriyoruz.',
                'content' => '<p class="text-sm text-navy-600">Belediye Personel Talebi, Nakil Ağı, İş / Staj Başvurusu ve MİARGEM CV Havuzu modüllerine buradan ulaşabilirsiniz.</p>',
            ],
            [
                'title' => 'Belediye Personel Talebi',
                'banner_title' => 'İK VE KARİYER',
                'banner_subtitle' => 'Belediye Personel Talebi',
                'banner_description' => 'Doğrulanmış kurumsal e-postaya sahip belediyeler süreli personel talebi oluşturabilir.',
                'content' => '<p class="text-sm text-navy-600">Belediyeler, süreli personel taleplerini bu modül üzerinden ilan edebilir.</p>',
            ],
            [
                'title' => 'Nakil Ağı',
                'banner_title' => 'İK VE KARİYER',
                'banner_subtitle' => 'Nakil Ağı',
                'banner_description' => 'Başka bir belediyeye geçmek isteyen personel için gizlilik esaslı profil ağı. Ad ve kurum bilgileri, aday onayı olmadan görüntülenmez.',
                'content' => '<p class="text-sm text-navy-600">Nakil talep eden personel, kimliğini gizli tutarak profil oluşturabilir.</p>',
            ],
            [
                'title' => 'İş / Staj Başvurusu',
                'banner_title' => 'İK VE KARİYER',
                'banner_subtitle' => 'İş / Staj Başvurusu',
                'banner_description' => 'Yeni mezun, deneyimli aday ve stajyerler için ortak kariyer havuzu.',
                'content' => '<p class="text-sm text-navy-600">Açık pozisyonlara ve staj fırsatlarına buradan başvurabilirsiniz.</p>',
            ],
            [
                'title' => 'MİARGEM CV Havuzu',
                'banner_title' => 'İK VE KARİYER',
                'banner_subtitle' => 'MİARGEM CV Havuzu',
                'banner_description' => "MİARGEM'in araştırma, analiz, eğitim ve proje çalışmalarında görev alacak uzman havuzu.",
                'content' => '<p class="text-sm text-navy-600">Uzmanlık alanınızı belirterek CV havuzuna katılabilirsiniz.</p>',
            ],
            [
                'title' => 'Etkinlikler',
                'banner_title' => 'ETKİNLİKLER',
                'banner_subtitle' => 'Etkinlikler',
                'banner_description' => 'Paneller, çalıştaylar ve söyleşiler.',
                'content' => '<p class="text-sm text-navy-600">Yaklaşan ve geçmiş tüm etkinliklere bu bölümden ulaşabilirsiniz.</p>',
            ],
            [
                'title' => 'Gizlilik Politikası',
                'banner_title' => 'GİZLİLİK POLİTİKASI',
                'banner_subtitle' => 'Gizlilik Politikası',
                'banner_description' => '',
                'content' => '',
            ],
            [
                'title' => 'Çerez Politikası',
                'banner_title' => 'ÇEREZ POLİTİKASI',
                'banner_subtitle' => 'Çerez Politikası',
                'banner_description' => '',
                'content' => '',
            ],
            [
                'title' => 'KVKK Aydınlatma Metni',
                'banner_title' => 'KVKK AYDINLATMA METNİ',
                'banner_subtitle' => 'KVKK Aydınlatma Metni',
                'banner_description' => '',
                'content' => '',
            ],
            [
                'title' => 'Erişilebilirlik',
                'banner_title' => 'ERİŞİLEBİLİRLİK',
                'banner_subtitle' => 'Erişilebilirlik',
                'banner_description' => '',
                'content' => '',
            ],
            [
                'title' => 'Belediye Proje Günleri Programı',
                'slug' => 'belediye-proje-gunleri-programi',
                'banner_title' => 'BELEDİYE PROJE GÜNLERİ',
                'banner_subtitle' => 'Belediye Proje Günleri Programı',
                'banner_description' => 'Etkin Belediye Proje Yarışması ile Mevzuat Takip Sistemi\'ni bir araya getiren; iyi uygulamaları görünür kılan ve mevzuat desteğiyle yaygınlaştıran program.',
                'content' => <<<'HTML'
                    <h2 class="text-xl font-bold text-navy-900">Program Hakkında</h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-600">Belediye Proje Günleri, mahallî idarelerin yenilikçi ve sürdürülebilir projelerini tanıtan, değerlendiren ve yaygınlaştıran bir programdır. Program iki tamamlayıcı bileşenden oluşur: Etkin Belediye Proje Yarışması ve Mevzuat Takip Sistemi.</p>

                    <h2 class="mt-10 text-xl font-bold text-navy-900">Etkin Belediye Proje Yarışması</h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-600">Yarışma, belediyelerin hizmet kalitesini artıran, katılımcı ve ölçülebilir sonuç üreten projelerini ödüllendirir. Başvurular bağımsız bir jüri tarafından etki, uygulanabilirlik ve yaygınlaştırılabilirlik ölçütlerine göre değerlendirilir.</p>

                    <h2 class="mt-10 text-xl font-bold text-navy-900">Mevzuat Takip Sistemi ile İlişkisi</h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-600">Başarılı projelerin başka belediyelerde uygulanabilmesi çoğu zaman mevzuat uyumuna bağlıdır. Mevzuat Takip Sistemi, projelerin dayandığı ya da etkilendiği düzenlemeleri izler; değişiklikleri erken uyarıyla paylaşır ve gerektiğinde düzenleme önerilerine kaynak oluşturur.</p>
                    <ul class="mt-4 grid gap-3 sm:grid-cols-3 list-none pl-0">
                        <li class="rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><strong class="block text-navy-900">1. Proje</strong>Yarışmada öne çıkan uygulama belirlenir.</li>
                        <li class="rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><strong class="block text-navy-900">2. Mevzuat Analizi</strong>Uygulamanın hukukî dayanağı ve engelleri incelenir.</li>
                        <li class="rounded-lg border border-navy-100 p-4 text-sm text-navy-700"><strong class="block text-navy-900">3. Yaygınlaştırma</strong>Uyumlu model diğer belediyelerle paylaşılır.</li>
                    </ul>
                    HTML,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(['title' => $pageData['title']], $pageData);
        }
    }
}
