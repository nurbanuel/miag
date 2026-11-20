<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class CitizenGuideController extends Controller
{
    public function index(?string $kategori = null): View
    {
        $articles = Article::with(['author', 'category'])
            ->citizenGuide($kategori)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);

        $tabs = [
            null => __('Tümü'),
            'rehber' => __('Vatandaş Rehberi'),
            'bunlari-biliyor-musunuz' => __('Bunları Biliyor Musunuz?'),
        ];

        return view('pages.vatandas-rehberi', [
            'articles' => $articles,
            'tabs' => $tabs,
            'activeTab' => $kategori,
        ]);
    }
}
