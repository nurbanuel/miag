<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Author;
use App\Models\Event;
use App\Models\PolicyContent;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@miargem.org'],
            ['name' => 'MİARGEM Admin', 'password' => bcrypt('password')],
        );

        $this->seedAnnouncements();
        $this->seedReports();
        $authors = $this->seedAuthors();
        $this->seedArticles($authors);
        $this->seedEvents();
        $this->seedPolicyContents();
    }

    private function categoryId(string $name): int
    {
        return \App\Models\Category::firstOrCreate(['name' => $name])->id;
    }

    private function seedAnnouncements(): void
    {
        $items = [
            ['title' => '2026 Yılı Araştırma Bursu Başvuruları Açıldı', 'category_id' => $this->categoryId('Duyuru'), 'href' => '/duyurular/arastirma-bursu-2026', 'created_at' => now()->subDays(2)],
            ['title' => 'Etkin Belediye Proje Yarışması Başvuruları Uzatıldı', 'category_id' => $this->categoryId('Yarışma'), 'href' => '/proje-yarismasi', 'created_at' => now()->subDays(5)],
            ['title' => 'Mevzuat Takip Sistemi (MTS) Beta Sürümü Yayında', 'category_id' => $this->categoryId('MTS'), 'href' => '/mevzuat-takip-sistemi', 'created_at' => now()->subDays(9)],
            ['title' => 'Belediyelerde Dijital Dönüşüm Endeksi 2026 Yayımlandı', 'category_id' => $this->categoryId('Rapor'), 'href' => '/rapor-ve-analizler/belediyelerde-dijital-donusum-endeksi-2026', 'created_at' => now()->subDays(14)],
            ['title' => 'Yerel Yönetimlerde Yapay Zeka Çalıştayı Kayıtları Başladı', 'category_id' => $this->categoryId('Etkinlik'), 'href' => '/etkinlikler/yerel-yonetimlerde-yapay-zeka-caligtayi', 'created_at' => now()->subDays(20)],
        ];

        foreach ($items as $item) {
            $createdAt = $item['created_at'];
            unset($item['created_at']);
            $announcement = Announcement::firstOrCreate(['title' => $item['title']], $item);
            $announcement->forceFill(['created_at' => $createdAt])->save();
        }
    }

    private function seedReports(): void
    {
        $reports = [
            [
                'slug' => 'belediyelerde-dijital-donusum-endeksi-2026',
                'title' => 'Belediyelerde Dijital Dönüşüm Endeksi 2026',
                'category_id' => $this->categoryId('Dijital Dönüşüm'),
                'summary' => "81 il belediyesinin e-belediyecilik, açık veri ve dijital hizmet olgunluğunu ölçen kapsamlı endeks çalışması.",
                'key_findings' => "Büyükşehir belediyelerinin %68'i açık veri portalına sahip\nDijital başvuru sistemlerinde bölgesel eşitsizlik sürüyor\nMobil uygulama kullanım oranı son 2 yılda %40 arttı",
                'cover_color' => 'turquoise',
                'published_at' => now()->subMonths(3),
            ],
            [
                'slug' => 'yerel-yonetimlerde-mali-surdurulebilirlik-raporu',
                'title' => 'Yerel Yönetimlerde Mali Sürdürülebilirlik Raporu',
                'category_id' => $this->categoryId('Mali Yönetim'),
                'summary' => 'Belediyelerin gelir-gider dengesi, borçlanma eğilimleri ve mali disiplin göstergelerinin karşılaştırmalı analizi.',
                'key_findings' => "Öz gelir/toplam gelir oranı ilçe belediyelerinde düşük seyrediyor\nBorç servis oranı kritik eşiği aşan belediye sayısı arttı",
                'cover_color' => 'navy',
                'published_at' => now()->subMonths(4),
            ],
            [
                'slug' => 'katilimci-butce-uygulamalari-karsilastirmali-analiz',
                'title' => 'Katılımcı Bütçe Uygulamaları: Karşılaştırmalı Analiz',
                'category_id' => $this->categoryId('Katılımcı Yönetişim'),
                'summary' => 'Türkiye\'deki katılımcı bütçe uygulamalarının vatandaş katılımı ve şeffaflık açısından değerlendirilmesi.',
                'key_findings' => "Katılımcı bütçe uygulayan belediye sayısı 3 yılda ikiye katlandı\nGenç ve kadın katılımını artıran belediyelerde memnuniyet daha yüksek",
                'cover_color' => 'bordo',
                'published_at' => now()->subMonths(6),
            ],
            [
                'slug' => 'personel-istihdam-egilimleri-2025',
                'title' => 'Belediyelerde Personel İstihdam Eğilimleri 2025',
                'category_id' => $this->categoryId('İnsan Kaynakları'),
                'summary' => 'Norm kadro uygulamaları, sözleşmeli personel oranları ve nitelikli işgücü ihtiyacına ilişkin saha araştırması.',
                'key_findings' => "Teknik personel açığı küçük ölçekli belediyelerde derinleşiyor\nSözleşmeli personel oranı son 5 yılda istikrarlı biçimde arttı",
                'cover_color' => 'turquoise',
                'published_at' => now()->subMonths(8),
            ],
        ];

        foreach ($reports as $report) {
            Report::updateOrCreate(['slug' => $report['slug']], $report);
        }
    }

    /** @return array<string, Author> */
    private function seedAuthors(): array
    {
        $authors = [
            [
                'slug' => 'elif-arslanoglu',
                'name' => 'Dr. Elif Arslanoğlu',
                'title' => 'Kentsel Yönetişim Araştırmacısı',
                'bio' => 'Yerel yönetimlerde katılımcı demokrasi ve kentsel politika üzerine çalışmaktadır.',
            ],
            [
                'slug' => 'mert-kaya',
                'name' => 'Mert Kaya',
                'title' => 'Kamu Maliyesi Uzmanı',
                'bio' => 'Belediye maliyesi, bütçeleme süreçleri ve mali denetim alanlarında çalışmaktadır.',
            ],
        ];

        $created = [];
        foreach ($authors as $author) {
            $created[$author['slug']] = Author::updateOrCreate(['slug' => $author['slug']], $author);
        }

        return $created;
    }

    /** @param array<string, Author> $authors */
    private function seedArticles(array $authors): void
    {
        $articles = [
            [
                'slug' => 'yerel-secimler-sonrasi-kurumsal-hafiza-sorunu',
                'title' => 'Yerel Seçimler Sonrası Kurumsal Hafıza Sorunu',
                'excerpt' => 'Seçim dönemlerinde yaşanan personel değişimi, belediyelerin kurumsal hafızasını nasıl etkiliyor?',
                'content' => 'Bu yazı, yazarın kişisel değerlendirmesidir ve MİARGEM\'in kurumsal görüşünü temsil etmez. İçerik yakında genişletilecektir.',
                'author' => 'elif-arslanoglu',
                'published_at' => now()->subMonth(),
            ],
            [
                'slug' => 'belediye-butcelerinde-seffaflik-neden-onemli',
                'title' => 'Belediye Bütçelerinde Şeffaflık Neden Önemli?',
                'excerpt' => 'Açık bütçe uygulamalarının vatandaş güvenine ve mali disipline katkısı üzerine bir değerlendirme.',
                'content' => 'Bu yazı, yazarın kişisel değerlendirmesidir ve MİARGEM\'in kurumsal görüşünü temsil etmez. İçerik yakında genişletilecektir.',
                'author' => 'mert-kaya',
                'published_at' => now()->subMonths(2),
            ],
            [
                'slug' => 'kucuk-olcekli-belediyelerde-kapasite-gelistirme',
                'title' => 'Küçük Ölçekli Belediyelerde Kapasite Geliştirme',
                'excerpt' => 'Sınırlı kaynaklarla çalışan belediyelerin kurumsal kapasitesini güçlendirmenin yolları.',
                'content' => 'Bu yazı, yazarın kişisel değerlendirmesidir ve MİARGEM\'in kurumsal görüşünü temsil etmez. İçerik yakında genişletilecektir.',
                'author' => 'elif-arslanoglu',
                'published_at' => now()->subMonths(3),
            ],
        ];

        foreach ($articles as $article) {
            $authorSlug = $article['author'];
            unset($article['author']);
            $article['author_id'] = $authors[$authorSlug]->id;
            Article::updateOrCreate(['slug' => $article['slug']], $article);
        }
    }

    private function seedEvents(): void
    {
        $events = [
            [
                'slug' => 'yerel-yonetimlerde-yapay-zeka-caligtayi',
                'title' => 'Yerel Yönetimlerde Yapay Zeka Çalıştayı',
                'description' => 'Belediye hizmetlerinde yapay zeka uygulamalarının fırsat ve risklerini tartışan uygulamalı çalıştay.',
                'location' => 'Ankara / Çevrimiçi',
                'speakers' => ['Dr. Elif Arslanoğlu', 'Mert Kaya'],
                'starts_at' => now()->addMonth(),
                'is_past' => false,
            ],
            [
                'slug' => 'mali-surdurulebilirlik-paneli',
                'title' => 'Mali Sürdürülebilirlik Paneli',
                'description' => 'Belediyelerin borçlanma politikaları ve mali risk yönetimi üzerine uzman panel.',
                'location' => 'İstanbul',
                'speakers' => ['Mert Kaya'],
                'starts_at' => now()->subMonths(5),
                'is_past' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(['slug' => $event['slug']], $event);
        }
    }

    private function seedPolicyContents(): void
    {
        $items = [
            [
                'slug' => 'norm-kadro-yonetmeligi-degisikligi-etki-notu',
                'title' => 'Norm Kadro Yönetmeliği Değişikliği Etki Notu',
                'summary' => 'Taslak değişikliğin belediyelerin istihdam kapasitesine olası etkilerinin ön değerlendirmesi.',
                'content' => 'Detaylı içerik yakında eklenecektir.',
                'type' => 'mevzuat_etki_notu',
                'published_at' => now()->subMonth(),
            ],
            [
                'slug' => 'katilimci-butce-icin-yasal-cerceve-onerisi',
                'title' => 'Katılımcı Bütçe İçin Yasal Çerçeve Önerisi',
                'summary' => 'Katılımcı bütçe uygulamalarının yaygınlaşması için mevzuat önerileri.',
                'content' => 'Detaylı içerik yakında eklenecektir.',
                'type' => 'duzenleme_onerisi',
                'published_at' => now()->subMonths(2),
            ],
        ];

        foreach ($items as $item) {
            PolicyContent::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
