<?php

namespace App\Filament\Resources\ExpertPoolProfileResource\Pages;

use App\Filament\Resources\ExpertPoolProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpertPoolProfile extends EditRecord
{
    protected static string $resource = ExpertPoolProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
