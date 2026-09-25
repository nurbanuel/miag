<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Event;
use App\Models\News;
use App\Models\PolicyContent;
use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportWpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-wp-data {--path= : XML dosyasının yolu (varsayılan: storage/app/wordpress.xml)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WordPress XML dışa aktarma dosyasındaki içerikleri kategorilerine göre ilgili modüllere dağıtır';

    private const WP_NS = 'http://wordpress.org/export/1.2/';

    private const CONTENT_NS = 'http://purl.org/rss/1.0/modules/content/';

    private const EXCERPT_NS = 'http://wordpress.org/export/1.2/excerpt/';

    private const DC_NS = 'http://purl.org/dc/elements/1.1/';

    /** @var array<string,int> Hedef modüle göre oluşturulan kayıt sayısı */
    private array $created = [
        'news' => 0, 'event' => 0, 'report' => 0,
        'announcement' => 0, 'policy' => 0, 'article' => 0,
    ];

    private int $skipped = 0;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $path = $this->option('path') ?: storage_path('app/wordpress.xml');

        if (! file_exists($path)) {
            $this->error("Dosya bulunamadı: {$path}");

            return self::FAILURE;
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($path);

        if ($xml === false) {
            $this->error('XML dosyası okunamadı veya bozuk.');

            return self::FAILURE;
        }

        $items = $xml->channel->item;
        $this->info(count($items).' öğe bulundu, ayrıştırılıyor...');

        // Yazarları eşle (dc:creator login => Author modeli), yalnızca Article hedefi için gerekir.
        $authorsByLogin = [];
        foreach ($xml->channel->children(self::WP_NS)->author as $wpAuthor) {
            $login = (string) $wpAuthor->author_login;
            $displayName = trim((string) $wpAuthor->author_display_name) ?: $login;
            $authorsByLogin[$login] = Author::firstOrCreate(['name' => $displayName]);
        }
        $defaultAuthor = $authorsByLogin['miargem'] ?? (reset($authorsByLogin) ?: Author::firstOrCreate(['name' => 'MİARGEM']));

        $categoryCache = [];

        DB::transaction(function () use ($items, $authorsByLogin, $defaultAuthor, &$categoryCache) {
            $bar = $this->output->createProgressBar(count($items));
            $bar->start();

            foreach ($items as $item) {
                $wp = $item->children(self::WP_NS);

                if ((string) $wp->post_type !== 'post' || (string) $wp->status !== 'publish') {
                    $bar->advance();

                    continue;
                }

                $title = trim((string) $item->title);
                if ($title === '') {
                    $bar->advance();

                    continue;
                }

                $categoryName = $this->extractCategoryName($item);
                $categoryId = null;
                if ($categoryName !== null) {
                    $categoryCache[$categoryName] ??= Category::firstOrCreate(['name' => $categoryName])->id;
                    $categoryId = $categoryCache[$categoryName];
                }

                $content = (string) $item->children(self::CONTENT_NS)->encoded;
                $publishedAt = $this->parseDate((string) $wp->post_date);
                $target = $this->resolveTarget($categoryName);

                $created = match ($target) {
                    'news' => $this->importAsNews($title, $content, $categoryId, $publishedAt),
                    'event' => $this->importAsEvent($title, $content, $categoryId, $publishedAt),
                    'report' => $this->importAsReport($title, $content, $categoryId, $publishedAt),
                    'announcement' => $this->importAsAnnouncement($title, $content, $categoryId, $categoryName, $publishedAt),
                    'policy' => $this->importAsPolicy($title, $content, $categoryId, $publishedAt),
                    default => $this->importAsArticle($item, $title, $content, $categoryId, $publishedAt, $authorsByLogin, $defaultAuthor),
                };

                if ($created) {
                    $this->created[$target]++;
                } else {
                    $this->skipped++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
        });

        $this->info(sprintf(
            'Haberler: %d, Etkinlikler: %d, Raporlar: %d, Duyurular: %d, Politika/Mevzuat: %d, Yazılar: %d (toplam %d), %d kayıt zaten mevcut olduğu için atlandı.',
            $this->created['news'], $this->created['event'], $this->created['report'],
            $this->created['announcement'], $this->created['policy'], $this->created['article'],
            array_sum($this->created), $this->skipped,
        ));

        return self::SUCCESS;
    }

    /** İlgili kategori adını (varsa) döndürür; sadece domain="category" olan etiketler dikkate alınır. */
    private function extractCategoryName(\SimpleXMLElement $item): ?string
    {
        foreach ($item->category as $categoryNode) {
            if ((string) $categoryNode['domain'] === 'category') {
                $name = trim((string) $categoryNode);
                if ($name !== '') {
                    return $name;
                }
            }
        }

        return null;
    }

    /** Kategori adına göre içeriğin gideceği modülü belirler. */
    private function resolveTarget(?string $categoryName): string
    {
        if ($categoryName === null) {
            return 'article';
        }

        if (Str::contains($categoryName, ['Haberler', 'Belediye Haberleri'], true)) {
            return 'news';
        }

        if (Str::contains($categoryName, 'Etkinlik', true)) {
            return 'event';
        }

        if (Str::contains($categoryName, 'Rapor', true)) {
            return 'report';
        }

        if (Str::contains($categoryName, 'Duyuru', true)) {
            return 'announcement';
        }

        if (Str::contains($categoryName, ['Politika', 'Mevzuat', 'İlke'], true)) {
            return 'policy';
        }

        return 'article';
    }

    private function parseDate(string $postDate): ?Carbon
    {
        if ($postDate === '' || $postDate === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return Carbon::parse($postDate);
        } catch (\Throwable) {
            return null;
        }
    }

    private function excerptFrom(string $content, string $fallbackTitle): string
    {
        $excerpt = Str::limit(trim(strip_tags($content)), 200);

        return $excerpt !== '' ? $excerpt : $fallbackTitle;
    }

    private function importAsNews(string $title, string $content, ?int $categoryId, ?Carbon $publishedAt): bool
    {
        if (News::where('title', $title)->where('content', $content)->exists()) {
            return false;
        }

        News::create([
            'title' => $title,
            'content' => $content,
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
        ]);

        return true;
    }

    private function importAsEvent(string $title, string $content, ?int $categoryId, ?Carbon $publishedAt): bool
    {
        if (Event::where('title', $title)->where('description', $content !== '' ? $content : $title)->exists()) {
            return false;
        }

        $startsAt = $publishedAt ?? now();

        Event::create([
            'title' => $title,
            'description' => $content !== '' ? $content : $title,
            'location' => 'Belirtilmedi',
            'starts_at' => $startsAt,
            'is_past' => $startsAt->isPast(),
            'category_id' => $categoryId,
        ]);

        return true;
    }

    private function importAsReport(string $title, string $content, ?int $categoryId, ?Carbon $publishedAt): bool
    {
        if (Report::where('title', $title)->where('content', $content)->exists()) {
            return false;
        }

        Report::create([
            'title' => $title,
            'summary' => $this->excerptFrom($content, $title),
            'content' => $content,
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
        ]);

        return true;
    }

    private function importAsAnnouncement(string $title, string $content, ?int $categoryId, ?string $categoryName, ?Carbon $publishedAt): bool
    {
        if (Announcement::where('title', $title)->where('content', $content)->exists()) {
            return false;
        }

        $announcement = Announcement::create([
            'title' => $title,
            'category_label' => $categoryName ?? 'Duyuru',
            'href' => '#',
            'content' => $content,
            'category_id' => $categoryId,
        ]);

        if ($publishedAt) {
            $announcement->forceFill(['created_at' => $publishedAt])->save();
        }

        return true;
    }

    private function importAsPolicy(string $title, string $content, ?int $categoryId, ?Carbon $publishedAt): bool
    {
        if (PolicyContent::where('title', $title)->where('content', $content)->exists()) {
            return false;
        }

        PolicyContent::create([
            'title' => $title,
            'summary' => $this->excerptFrom($content, $title),
            'content' => $content,
            'type' => 'mevzuat_etki_notu',
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
        ]);

        return true;
    }

    /** @param array<string,Author> $authorsByLogin */
    private function importAsArticle(\SimpleXMLElement $item, string $title, string $content, ?int $categoryId, ?Carbon $publishedAt, array $authorsByLogin, Author $defaultAuthor): bool
    {
        if (Article::where('title', $title)->where('content', $content)->exists()) {
            return false;
        }

        $excerptNode = $item->children(self::EXCERPT_NS);
        $excerpt = trim((string) $excerptNode->encoded);
        if ($excerpt === '') {
            $excerpt = $this->excerptFrom($content, $title);
        }

        $creatorLogin = (string) $item->children(self::DC_NS)->creator;
        $author = $authorsByLogin[$creatorLogin] ?? $defaultAuthor;

        Article::create([
            'title' => $title,
            'excerpt' => $excerpt,
            'content' => $content,
            'author_id' => $author->id,
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
        ]);

        return true;
    }
}
