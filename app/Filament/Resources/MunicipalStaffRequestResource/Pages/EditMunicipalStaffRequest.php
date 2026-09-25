<?php

namespace App\Filament\Resources\MunicipalStaffRequestResource\Pages;

use App\Filament\Resources\MunicipalStaffRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMunicipalStaffRequest extends EditRecord
{
    protected static string $resource = MunicipalStaffRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
