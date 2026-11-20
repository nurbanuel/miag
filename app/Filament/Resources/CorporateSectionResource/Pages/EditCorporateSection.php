<?php

namespace App\Filament\Resources\CorporateSectionResource\Pages;

use App\Filament\Resources\CorporateSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorporateSection extends EditRecord
{
    protected static string $resource = CorporateSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
