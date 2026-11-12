<?php

namespace App\Filament\Resources\PresidentMessageResource\Pages;

use App\Filament\Resources\PresidentMessageResource;
use App\Models\PresidentMessage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresidentMessages extends ListRecords
{
    protected static string $resource = PresidentMessageResource::class;

    /**
     * Tekil kayıt: kayıt varsa doğrudan düzenleme ekranına, yoksa oluşturma ekranına yönlendir.
     */
    public function mount(): void
    {
        $record = PresidentMessage::query()->first();

        $this->redirect($record
            ? PresidentMessageResource::getUrl('edit', ['record' => $record])
            : PresidentMessageResource::getUrl('create'));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
