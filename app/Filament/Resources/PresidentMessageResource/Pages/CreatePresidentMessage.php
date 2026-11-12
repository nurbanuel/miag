<?php

namespace App\Filament\Resources\PresidentMessageResource\Pages;

use App\Filament\Resources\PresidentMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePresidentMessage extends CreateRecord
{
    protected static string $resource = PresidentMessageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
