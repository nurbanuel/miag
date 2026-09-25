<?php

namespace App\Filament\Resources\PolicyContentResource\Pages;

use App\Filament\Resources\PolicyContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolicyContents extends ListRecords
{
    protected static string $resource = PolicyContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
