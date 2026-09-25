<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::where('is_past', false)->orderBy('starts_at')->get();
        $past = Event::where('is_past', true)->orderByDesc('starts_at')->paginate(6, ['*'], 'gecmis');

        return view('events.index', compact('upcoming', 'past'));
    }

    public function show(Event $event): View
    {
        return view('events.show', compact('event'));
    }
}
