<?php

namespace App\Filament\Resources\ExpertPoolResource\Pages;

use App\Filament\Resources\ExpertPoolResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpertPool extends EditRecord
{
    protected static string $resource = ExpertPoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
