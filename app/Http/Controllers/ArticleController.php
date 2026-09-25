<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('author')->latest('published_at')->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        $article->load('author');

        return view('articles.show', compact('article'));
    }
}
