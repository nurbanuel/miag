<?php

namespace App\Filament\Resources\CorporateSectionResource\Pages;

use App\Filament\Resources\CorporateSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorporateSections extends ListRecords
{
    protected static string $resource = CorporateSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
