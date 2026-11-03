<?php

namespace App\Filament\Resources\HrPersonnelRequestResource\Pages;

use App\Filament\Resources\HrPersonnelRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHrPersonnelRequest extends EditRecord
{
    protected static string $resource = HrPersonnelRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
