<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $news = News::with('category')->orderBy('published_at', 'desc')->take(4)->get();

        return view('home', compact('news'));
    }
}
