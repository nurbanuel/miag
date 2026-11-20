<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View|RedirectResponse
    {
        // Kurumsal sayfası kendi dinamik görünümüyle (/kurumsal) sunulur; eski taslak içerik gösterilmez.
        if ($slug === 'kurumsal') {
            return redirect(lroute('corporate'), 301);
        }

        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page', compact('page'));
    }
}
