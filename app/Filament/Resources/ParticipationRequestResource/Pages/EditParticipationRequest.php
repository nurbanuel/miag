<?php

namespace App\Filament\Resources\ParticipationRequestResource\Pages;

use App\Filament\Resources\ParticipationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParticipationRequest extends EditRecord
{
    protected static string $resource = ParticipationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
