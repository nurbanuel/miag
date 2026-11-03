<?php

namespace App\Filament\Resources\HrApplicationResource\Pages;

use App\Filament\Resources\HrApplicationResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListHrApplications extends ListRecords
{
    protected static string $resource = HrApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Pasif ya da sonuçlanmış profiller varsayılan sekmede (liste ve arama) gösterilmez.
     */
    public function getTabs(): array
    {
        return [
            'aktif' => Tab::make('Aktif Başvurular')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('is_active', true)
                    ->where('status', '!=', 'Sonuçlandı')),
            'pasif' => Tab::make('Pasifler / Sonuçlananlar')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where(fn (Builder $q) => $q->where('is_active', false)->orWhere('status', 'Sonuçlandı'))),
            'tumu' => Tab::make('Tümü'),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'aktif';
    }
}
