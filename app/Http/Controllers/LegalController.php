<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function cookies(): View
    {
        return view('legal.cookies');
    }

    public function accessibility(): View
    {
        return view('legal.accessibility');
    }
}
