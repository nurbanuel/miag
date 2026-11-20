<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Event;
use App\Models\News;
use App\Models\PolicyContent;
use App\Models\Report;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $news = News::with('category')->orderBy('published_at', 'desc')->take(4)->get();

        $featuredContent = $this->latestFeaturedContent();

        $featuredReports = Report::with('category')->latest('created_at')->latest('id')->take(3)->get();

        $featuredArticles = Article::with('author')->latest('published_at')->take(3)->get();

        $upcomingEvent = Event::where('starts_at', '>', now())->orderBy('starts_at')->first();

        return view('home', compact('news', 'featuredContent', 'upcomingEvent', 'featuredReports', 'featuredArticles'));
    }

    /**
     * Manşete eklenmiş içerikler arasından en son güncelleneni (updated_at), tüm
     * modüllerde ortak bir dizi biçiminde döndürür. Kartta gösterilen tarih ise
     * içeriğin kendi yayın/etkinlik tarihidir.
     */
    private function latestFeaturedContent(): ?array
    {
        // [tür, model, tarih sütunu, modül adı, detay rotası]
        $modules = [
            ['report', Report::class, 'published_at', 'Rapor ve Analizler', 'reports.show'],
            ['policy', PolicyContent::class, 'published_at', 'Politika ve Mevzuat', 'policy.show'],
            ['news', News::class, 'published_at', 'Haberler', 'news.show'],
            ['article', Article::class, 'published_at', 'Yazılar', 'articles.show'],
            ['event', Event::class, 'starts_at', 'Etkinlikler', 'events.show'],
            ['announcement', Announcement::class, 'created_at', 'Duyurular', 'announcements.show'],
        ];

        $now = now();

        return collect($modules)
            ->map(function (array $module) use ($now) {
                [$type, $model, $dateColumn, $moduleLabel, $route] = $module;

                $item = $model::with('category')
                    ->where('is_featured', true)
                    ->where(fn ($q) => $q->whereNull('visibility_start')->orWhere('visibility_start', '<=', $now))
                    ->where(fn ($q) => $q->whereNull('visibility_end')->orWhere('visibility_end', '>=', $now))
                    ->latest('updated_at')
                    ->first();

                if (! $item) {
                    return null;
                }

                return [
                    'type' => $type,
                    'title' => $item->title,
                    'date' => $item->{$dateColumn} ?? $item->created_at,
                    'url' => lroute($route, $item),
                    'image' => $item->featured_image ? asset('storage/'.$item->featured_image) : null,
                    'module' => $moduleLabel,
                    'type_label' => $item instanceof Report ? $item->type_label : null,
                    'is_analysis' => $item instanceof Report && $item->isAnalysis(),
                    'category' => $item->category?->name,
                    'has_360_badge' => (bool) $item->has_360_badge,
                    'updated_at' => $item->updated_at,
                ];
            })
            ->filter()
            ->sortByDesc(fn (array $content) => $content['updated_at']?->getTimestamp() ?? 0)
            ->first();
    }
}
