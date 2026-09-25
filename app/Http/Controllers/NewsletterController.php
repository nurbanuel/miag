<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email|max:150',
        ]);

        NewsletterSubscriber::firstOrCreate(['email' => strtolower($data['email'])]);

        return back()->with('newsletter_status', 'Abone olduğunuz için teşekkürler!');
    }
}
