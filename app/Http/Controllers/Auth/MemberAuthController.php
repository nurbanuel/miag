<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Ön yüz üyelik: giriş, kayıt ve çıkış.
 * Üyeler standart kullanıcıdır (is_admin = false); yönetim paneline erişemez.
 */
class MemberAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.member-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => __('Çok fazla deneme yapıldı. Lütfen :seconds saniye sonra tekrar deneyin.', [
                    'seconds' => RateLimiter::availableIn($throttleKey),
                ]),
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => __('E-posta adresi veya şifre hatalı.'),
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(lroute('career.index'));
    }

    public function showRegister(): View
    {
        return view('auth.member-register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\s-]{7,30}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'kvkk' => ['accepted'],
        ], [
            'email.unique' => __('Bu e-posta adresiyle kayıtlı bir üyelik zaten var. Lütfen giriş yapın.'),
            'phone.regex' => __('Lütfen geçerli bir telefon numarası girin.'),
            'kvkk.accepted' => __('Devam etmek için aydınlatma metnini onaylamalısınız.'),
        ]);

        // Yalnızca açıkça seçilen alanlar yazılır; yönetici yetkisi ön yüzden verilemez.
        $user = User::create([
            'name' => $data['name'],
            'email' => Str::lower($data['email']),
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(lroute('career.index'))
            ->with('status', __('Üyeliğiniz oluşturuldu. Hoş geldiniz, :name!', ['name' => $user->name]));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(lroute('home'));
    }
}
