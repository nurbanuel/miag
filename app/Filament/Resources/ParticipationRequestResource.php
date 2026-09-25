<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipationRequestResource\Pages;
use App\Filament\Resources\ParticipationRequestResource\RelationManagers;
use App\Models\ParticipationRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipationRequestResource extends Resource
{
    protected static ?string $model = ParticipationRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationLabel = 'Katılım Talepleri';

    protected static ?string $pluralModelLabel = 'Katılım Talepleri';

    protected static ?string $modelLabel = 'Katılım Talebi';

    protected static ?string $navigationGroup = 'Katılım';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tür')
                    ->options(ParticipationRequest::TYPE_LABELS)
                    ->required(),
                Forms\Components\TextInput::make('full_name')
                    ->label('Ad Soyad')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('E-posta')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('institution')
                    ->label('Kurum'),
                Forms\Components\Textarea::make('message')
                    ->label('Mesaj')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options(['beklemede' => 'Beklemede', 'incelendi' => 'İncelendi', 'tamamlandi' => 'Tamamlandı'])
                    ->default('beklemede')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->formatStateUsing(fn (string $state) => ParticipationRequest::TYPE_LABELS[$state] ?? $state)
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Ad Soyad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institution')
                    ->label('Kurum')
                    ->searchable(),
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
            'index' => Pages\ListParticipationRequests::route('/'),
            'edit' => Pages\EditParticipationRequest::route('/{record}/edit'),
        ];
    }
}
