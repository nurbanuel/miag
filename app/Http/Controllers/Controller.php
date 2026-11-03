<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /** Ön yüzdeki Filament formları site renkleriyle uyumlu olsun (turkuaz birincil renk). */
    protected function useSiteColorsForFilamentForms(): void
    {
        \Filament\Support\Facades\FilamentColor::register([
            'primary' => \Filament\Support\Colors\Color::hex('#128884'),
        ]);
    }
}
