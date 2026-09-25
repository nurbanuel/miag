<?php

namespace App\Filament\Resources\PolicyContentResource\Pages;

use App\Filament\Resources\PolicyContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPolicyContent extends EditRecord
{
    protected static string $resource = PolicyContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
