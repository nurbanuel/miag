<?php

namespace App\Http\Controllers;

use App\Models\ParticipationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParticipationController extends Controller
{
    public function index(): View
    {
        return view('participation.index', [
            'types' => ParticipationRequest::TYPE_LABELS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => 'required|in:rapor_analiz,veri,etkinlik,yazi_iletisim',
            'full_name' => 'required|string|min:2|max:150',
            'email' => 'required|email|max:150',
            'institution' => 'nullable|string|max:150',
            'message' => 'required|string|min:10|max:3000',
        ]);

        ParticipationRequest::create($data);

        return back()->with('status', 'Başvurunuz alınmıştır. En kısa sürede sizinle iletişime geçeceğiz.');
    }
}
