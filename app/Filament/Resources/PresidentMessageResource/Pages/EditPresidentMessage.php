<?php

namespace App\Filament\Resources\PresidentMessageResource\Pages;

use App\Filament\Resources\PresidentMessageResource;
use Filament\Resources\Pages\EditRecord;

class EditPresidentMessage extends EditRecord
{
    protected static string $resource = PresidentMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
