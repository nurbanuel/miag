<?php

namespace App\Filament\Resources\JobInternshipApplicationResource\Pages;

use App\Filament\Resources\JobInternshipApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobInternshipApplications extends ListRecords
{
    protected static string $resource = JobInternshipApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
