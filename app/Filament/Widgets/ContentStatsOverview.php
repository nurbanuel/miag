<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\News;
use App\Models\NewsletterSubscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Yazılar', Article::count())
                ->description('Toplam yayımlanan yazı')
                ->icon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Haberler', News::count())
                ->description('Toplam haber')
                ->icon('heroicon-o-newspaper')
                ->color('info'),

            Stat::make('Bülten Aboneleri', NewsletterSubscriber::count())
                ->description('Toplam e-posta aboneliği')
                ->icon('heroicon-o-envelope')
                ->color('warning'),
        ];
    }
}
