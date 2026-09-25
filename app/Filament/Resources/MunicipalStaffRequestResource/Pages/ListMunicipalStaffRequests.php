<?php

namespace App\Filament\Resources\MunicipalStaffRequestResource\Pages;

use App\Filament\Resources\MunicipalStaffRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMunicipalStaffRequests extends ListRecords
{
    protected static string $resource = MunicipalStaffRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
