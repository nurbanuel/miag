<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(['id' => 1], [
            'header_menu' => [
                ['title' => 'Kurumsal', 'url' => '/kurumsal'],
                ['title' => 'Başkan', 'url' => '/baskan'],
                ['title' => 'Rapor ve Analizler', 'url' => '/rapor-ve-analizler'],
                ['title' => 'Politika & Mevzuat', 'url' => '/politika-ve-mevzuat'],
                ['title' => 'Yazılar', 'url' => '/yazilar'],
                [
                    'title' => 'Vatandaş Rehberi',
                    'url' => '/vatandas-rehberi',
                    'children' => [
                        ['title' => 'Vatandaş Rehberi', 'url' => '/vatandas-rehberi/rehber'],
                        ['title' => 'Bunları Biliyor Musunuz?', 'url' => '/vatandas-rehberi/bunlari-biliyor-musunuz'],
                    ],
                ],
                [
                    'title' => 'İK ve Kariyer',
                    'url' => '/ik-ve-kariyer',
                    'children' => [
                        ['title' => 'Belediye Personel Talebi', 'url' => '/ik-ve-kariyer/belediye-personel-talebi'],
                        ['title' => 'Nakil Ağı', 'url' => '/ik-ve-kariyer/nakil-agi'],
                        ['title' => 'İş / Staj Başvurusu', 'url' => '/ik-ve-kariyer/is-staj-basvurusu'],
                        ['title' => 'MİARGEM CV Havuzu', 'url' => '/ik-ve-kariyer/miargem-cv-havuzu'],
                    ],
                ],
                ['title' => 'Etkinlikler', 'url' => '/etkinlikler'],
            ],
            'footer_about_text' => 'MİARGEM, belediye yöneticileri, çalışanları, akademisyenler, araştırmacılar ve yerel yönetim uzmanları için bağımsız bir araştırma, yayın, veri ve katılım merkezidir.',
            'footer_quick_links' => [
                ['title' => 'Hakkımızda', 'url' => '/kurumsal'],
                ['title' => 'Rapor ve Analizler', 'url' => '/rapor-ve-analizler'],
                ['title' => 'Etkin Belediye Proje Yarışması', 'url' => '/proje-yarismasi'],
                ['title' => 'Mevzuat Takip Sistemi', 'url' => '/mevzuat-takip-sistemi'],
                ['title' => 'Katılım', 'url' => '/katilim'],
            ],
            'footer_legal_links' => [
                ['title' => 'Gizlilik Politikası', 'url' => '/gizlilik-politikasi'],
                ['title' => 'Çerez Politikası', 'url' => '/cerez-politikasi'],
                ['title' => 'KVKK Aydınlatma Metni', 'url' => '/kvkk-aydinlatma-metni'],
                ['title' => 'Erişilebilirlik', 'url' => '/erisilebilirlik'],
            ],
            'footer_copyright_text' => 'MİARGEM. Tüm hakları saklıdır.',
            'corporate_page_title' => 'MİARGEM Kurumsal',
            'corporate_page_subtitle' => 'Mahallî İdareler Araştırma ve Geliştirme Merkezi',
            'contact_email' => 'info@miargem.org',
            'contact_phone' => '+90 (312) 000 00 00',
        ]);
    }
}
