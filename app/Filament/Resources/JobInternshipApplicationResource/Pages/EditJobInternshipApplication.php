<?php

namespace App\Filament\Resources\JobInternshipApplicationResource\Pages;

use App\Filament\Resources\JobInternshipApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobInternshipApplication extends EditRecord
{
    protected static string $resource = JobInternshipApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
