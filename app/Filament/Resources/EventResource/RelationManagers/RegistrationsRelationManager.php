<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\EventRegistrationResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/** Etkinlik düzenleme ekranında o etkinliğe kayıt olan katılımcılar. */
class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Katılımcılar';

    protected static ?string $modelLabel = 'Katılımcı';

    protected static ?string $pluralModelLabel = 'Katılımcılar';

    protected static ?string $icon = 'heroicon-o-user-group';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return (string) $ownerRecord->registrations()->count();
    }

    public function form(Form $form): Form
    {
        return $form->schema(EventRegistrationResource::participantFields(withEvent: false))->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->modifyQueryUsing(fn ($query) => $query->with('user'))
            ->columns(EventRegistrationResource::participantColumns(withEvent: false))
            ->defaultSort('created_at', 'desc')
            ->filters([
                EventRegistrationResource::mtsFilter(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Katılımcı Ekle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Henüz kayıt yok')
            ->emptyStateDescription('Bu etkinliğe ön yüzdeki kayıt formundan yapılan başvurular burada listelenir.');
    }
}
