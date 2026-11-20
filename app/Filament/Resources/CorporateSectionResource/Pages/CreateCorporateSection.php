<?php

namespace App\Filament\Resources\CorporateSectionResource\Pages;

use App\Filament\Resources\CorporateSectionResource;
use App\Models\CorporateSection;
use Filament\Resources\Pages\CreateRecord;

class CreateCorporateSection extends CreateRecord
{
    protected static string $resource = CorporateSectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Yeni bölüm listenin sonuna eklenir; sırası tablodan sürükle-bırakla değiştirilebilir.
        $data['sort_order'] = (int) CorporateSection::max('sort_order') + 1;

        return $data;
    }
}
