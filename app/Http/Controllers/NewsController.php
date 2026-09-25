<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::with('category')->orderBy('published_at', 'desc')->paginate(9);

        return view('news.index', compact('newsItems'));
    }

    public function show(News $news): View
    {
        $news->load('category');

        return view('news.show', compact('news'));
    }
}
