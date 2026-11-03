<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function show(Announcement $announcement): View
    {
        $announcement->load('category');

        return view('announcements.show', compact('announcement'));
    }
}
