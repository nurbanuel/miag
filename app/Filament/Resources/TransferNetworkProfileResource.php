<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferNetworkProfileResource\Pages;
use App\Filament\Resources\TransferNetworkProfileResource\RelationManagers;
use App\Models\TransferNetworkProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransferNetworkProfileResource extends Resource
{
    protected static ?string $model = TransferNetworkProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $pluralModelLabel = 'Nakil Ağı Profilleri';

    protected static ?string $modelLabel = 'Nakil Ağı Profili';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'Nakil Ağı Profilleri';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('current_title')
                    ->label('Mevcut Unvan')
                    ->required(),
                Forms\Components\TextInput::make('current_institution')
                    ->label('Mevcut Kurum')
                    ->required(),
                Forms\Components\TextInput::make('target_locations')
                    ->label('Hedef Konumlar')
                    ->required(),
                Forms\Components\TextInput::make('experience_years')
                    ->label('Deneyim (Yıl)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('summary')
                    ->label('Özet')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_email')
                    ->label('İletişim E-postası')
                    ->email()
                    ->required(),
                Forms\Components\Toggle::make('is_identity_revealed')
                    ->label('Kimlik Açıldı mı?')
                    ->required(),
                Forms\Components\Toggle::make('consent_accepted')
                    ->label('Açık Rıza Onayı')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options(['beklemede' => 'Beklemede', 'incelendi' => 'İncelendi', 'onaylandi' => 'Onaylandı', 'reddedildi' => 'Reddedildi'])
                    ->default('beklemede')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('current_title')
                    ->label('Mevcut Unvan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_institution')
                    ->label('Mevcut Kurum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('target_locations')
                    ->label('Hedef Konumlar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('experience_years')
                    ->label('Deneyim (Yıl)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('İletişim E-postası')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_identity_revealed')
                    ->label('Kimlik Açıldı mı?')
                    ->boolean(),
                Tables\Columns\IconColumn::make('consent_accepted')
                    ->label('Açık Rıza Onayı')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransferNetworkProfiles::route('/'),
            'edit' => Pages\EditTransferNetworkProfile::route('/{record}/edit'),
        ];
    }
}
