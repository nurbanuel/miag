<?php

namespace App\Filament\Resources\TransferNetworkProfileResource\Pages;

use App\Filament\Resources\TransferNetworkProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransferNetworkProfile extends EditRecord
{
    protected static string $resource = TransferNetworkProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
