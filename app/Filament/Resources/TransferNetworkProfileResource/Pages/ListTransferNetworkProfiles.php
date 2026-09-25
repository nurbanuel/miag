<?php

namespace App\Filament\Resources\TransferNetworkProfileResource\Pages;

use App\Filament\Resources\TransferNetworkProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransferNetworkProfiles extends ListRecords
{
    protected static string $resource = TransferNetworkProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
