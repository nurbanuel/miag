<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['email' => mb_strtolower(trim((string) $request->input('email')))]);

        $validator = Validator::make($request->only('email'), [
            'email' => ['required', 'email', 'max:150', 'unique:newsletter_subscribers,email'],
        ], [
            'email.required' => 'Lütfen e-posta adresinizi yazın.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi yazın.',
            'email.max' => 'E-posta adresi en fazla 150 karakter olabilir.',
            'email.unique' => 'Bu e-posta adresi bültenimize zaten kayıtlı.',
        ]);

        // Hatalar ayrı bir torbada tutulur; aynı sayfadaki diğer formların "email" alanına karışmaz.
        if ($validator->fails()) {
            return back()->withErrors($validator, 'newsletter')->withInput()->withFragment('newsletter-signup');
        }

        NewsletterSubscriber::create($validator->validated());

        return back()->with('success', 'Bültenimize abone olduğunuz için teşekkürler!')->withFragment('newsletter-signup');
    }
}
