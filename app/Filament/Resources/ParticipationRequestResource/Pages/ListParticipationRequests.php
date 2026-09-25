<?php

namespace App\Filament\Resources\ParticipationRequestResource\Pages;

use App\Filament\Resources\ParticipationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipationRequests extends ListRecords
{
    protected static string $resource = ParticipationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
