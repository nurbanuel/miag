<?php

namespace App\Filament\Resources\HrPersonnelRequestResource\Pages;

use App\Filament\Resources\HrPersonnelRequestResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListHrPersonnelRequests extends ListRecords
{
    protected static string $resource = HrPersonnelRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Süresi dolan veya pasif talepler varsayılan sekmede (liste ve arama) gösterilmez.
     */
    public function getTabs(): array
    {
        return [
            'aktif' => Tab::make('Yayındaki Talepler')
                ->modifyQueryUsing(fn (Builder $query) => $query->current()),
            'sona_eren' => Tab::make('Süresi Dolan / Pasif')
                ->modifyQueryUsing(fn (Builder $query) => $query->expiredOrInactive()),
            'tumu' => Tab::make('Tümü'),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'aktif';
    }
}
