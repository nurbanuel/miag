<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class CorporateController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'kurumsal')->firstOrNew();

        return view('corporate.index', compact('page'));
    }
}
