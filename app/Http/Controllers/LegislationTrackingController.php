<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegislationTrackingController extends Controller
{
    public function index(): View
    {
        return view('legislation-tracking.index');
    }
}
