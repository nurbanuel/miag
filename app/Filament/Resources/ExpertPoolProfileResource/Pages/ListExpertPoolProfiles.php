<?php

namespace App\Filament\Resources\ExpertPoolProfileResource\Pages;

use App\Filament\Resources\ExpertPoolProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpertPoolProfiles extends ListRecords
{
    protected static string $resource = ExpertPoolProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
