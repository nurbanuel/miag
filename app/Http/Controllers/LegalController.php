<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('legal.privacy');
    }

    public function cookies(): View
    {
        return view('legal.cookies');
    }

    public function kvkk(): View
    {
        return view('legal.kvkk');
    }

    public function accessibility(): View
    {
        return view('legal.accessibility');
    }
}
