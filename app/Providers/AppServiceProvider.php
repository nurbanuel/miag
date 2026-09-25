<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Schema::hasTable koruması, migration henüz çalışmamışken (ör. taze kurulum,
        // php artisan migrate komutunun kendisi) tüm artisan komutlarının kırılmasını önler.
        if (Schema::hasTable('site_settings')) {
            View::share('siteSettings', SiteSetting::first());
        }
    }
}
