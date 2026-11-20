<?php

namespace App\Http\Controllers;

use App\Models\CorporateSection;
use App\Models\Page;
use Illuminate\View\View;

class CorporateController extends Controller
{
    public function index(): View
    {
        // Yalnızca banner alanları kullanılır; sayfanın eski "Ana İçerik" ve "Sidebar" alanları gösterilmez.
        $page = Page::where('slug', 'kurumsal')->first();

        $sections = CorporateSection::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.corporate', compact('page', 'sections'));
    }
}
