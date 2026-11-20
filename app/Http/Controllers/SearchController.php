<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Event;
use App\Models\PolicyContent;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $results = collect();

        if ($query !== '') {
            $term = '%'.$query.'%';

            $results = $results
                ->concat(Report::where('title', 'like', $term)->orWhere('summary', 'like', $term)->orWhere('content', 'like', $term)->get()->map(fn ($r) => [
                    'type' => $r->sub_category ?: 'Rapor', 'title' => $r->title, 'excerpt' => \Illuminate\Support\Str::limit(strip_tags($r->summary ?: $r->content), 160), 'href' => lroute('reports.show', $r),
                ]))
                ->concat(Article::where('title', 'like', $term)->orWhere('excerpt', 'like', $term)->get()->map(fn ($a) => [
                    'type' => 'Yazı', 'title' => $a->title, 'excerpt' => $a->excerpt, 'href' => lroute('articles.show', $a),
                ]))
                ->concat(PolicyContent::where('title', 'like', $term)->orWhere('summary', 'like', $term)->get()->map(fn ($p) => [
                    'type' => 'Mevzuat', 'title' => $p->title, 'excerpt' => $p->summary, 'href' => lroute('policy.show', $p),
                ]))
                ->concat(Event::where('title', 'like', $term)->orWhere('description', 'like', $term)->get()->map(fn ($e) => [
                    'type' => 'Etkinlik', 'title' => $e->title, 'excerpt' => \Illuminate\Support\Str::limit(strip_tags($e->description), 160), 'href' => lroute('events.show', $e),
                ]))
                ->concat(Announcement::where('title', 'like', $term)->get()->map(fn ($a) => [
                    'type' => 'Duyuru', 'title' => $a->title, 'excerpt' => '', 'href' => lroute('announcements.show', $a),
                ]));
        }

        return view('search.index', ['query' => $query, 'results' => $results]);
    }
}
