<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'setlocale' => \App\Http\Middleware\SetLocale::class,
        ]);

        // Üye girişi gerektiren sayfalara (İK ve Kariyer) misafirler /uye-girisi sayfasına
        // yönlendirilir; giriş sonrası redirect()->intended() ile tıklanan sayfaya dönülür.
        // (Yönetim paneli kendi Filament giriş sayfasını kullanmaya devam eder.)
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if (! $request->expectsJson()) {
                session()->flash('warning', __('İK ve Kariyer bölümündeki içerikleri görüntülemek ve işlem yapabilmek için lütfen üye girişi yapın veya kayıt olun.'));
            }

            return route(($request->is('en') || $request->is('en/*') ? 'en.' : 'tr.').'member.login');
        });

        // Giriş yapmış kullanıcı giriş/kayıt sayfasına gelirse İK ve Kariyer'e gönderilir.
        $middleware->redirectUsersTo(fn (\Illuminate\Http\Request $request) => route(($request->is('en') || $request->is('en/*') ? 'en.' : 'tr.').'career.index'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
