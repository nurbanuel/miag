<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventRegistrationResource\Pages;
use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventRegistrationResource extends Resource
{
    protected static ?string $model = EventRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Etkinlikler';

    protected static ?string $navigationLabel = 'Etkinlik Katılımcıları';

    protected static ?string $modelLabel = 'Katılımcı';

    protected static ?string $pluralModelLabel = 'Etkinlik Katılımcıları';

    protected static ?int $navigationSort = 2;

    /** Katılımcı formu (etkinlik içinden düzenlemede de kullanılır). */
    public static function participantFields(bool $withEvent = true): array
    {
        return array_values(array_filter([
            $withEvent ? Forms\Components\Select::make('event_id')
                ->label('Etkinlik')
                ->relationship('event', 'title', fn (Builder $query) => $query->withoutGlobalScope('active')->latest('starts_at'))
                ->searchable()
                ->preload()
                ->required()
                ->columnSpanFull() : null,
            Forms\Components\TextInput::make('full_name')->label('Adı Soyadı')->required()->maxLength(150),
            Forms\Components\TextInput::make('institution')->label('Kurumu')->required()->maxLength(200),
            Forms\Components\TextInput::make('department')->label('Dairesi/Müdürlüğü')->required()->maxLength(200),
            Forms\Components\TextInput::make('title')->label('Unvanı/Görevi')->required()->maxLength(150),
            Forms\Components\TextInput::make('email')->label('E-posta Adresi')->email()->required()->maxLength(150),
            Forms\Components\TextInput::make('phone')->label('GSM Numarası')->tel()->required()->maxLength(30),
            Forms\Components\Radio::make('is_mts_subscriber')
                ->label('MTS Abonesi mi?')
                ->boolean('Evet', 'Hayır')
                ->inline()
                ->required(),
            Forms\Components\Placeholder::make('member')
                ->label('Eşleşen Üye')
                ->content(fn (?EventRegistration $record) => $record?->user ? $record->user->name.' ('.$record->user->email.')' : 'Üye girişi yapılmadan kayıt')
                ->visibleOn('edit'),
        ]));
    }

    /** Katılımcı tablo sütunları (toplu liste ve etkinlik içi liste ortak). */
    public static function participantColumns(bool $withEvent = true): array
    {
        return array_values(array_filter([
            $withEvent ? Tables\Columns\TextColumn::make('event.title')
                ->label('Etkinlik Adı')
                ->searchable()
                ->sortable()
                ->wrap()
                ->limit(60) : null,
            Tables\Columns\TextColumn::make('full_name')->label('Adı Soyadı')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('institution')->label('Kurumu')->searchable()->wrap(),
            Tables\Columns\TextColumn::make('department')->label('Dairesi/Müdürlüğü')->searchable()->wrap()->toggleable(),
            Tables\Columns\TextColumn::make('title')->label('Unvanı/Görevi')->searchable()->toggleable(),
            Tables\Columns\TextColumn::make('email')->label('E-posta Adresi')->searchable()->copyable(),
            Tables\Columns\TextColumn::make('phone')->label('GSM Numarası')->searchable()->copyable(),
            Tables\Columns\TextColumn::make('is_mts_subscriber')
                ->label('MTS Abonesi mi?')
                ->badge()
                ->formatStateUsing(fn (bool $state): string => $state ? 'Evet' : 'Hayır')
                ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')->label('Kayıt Tarihi')->dateTime('d.m.Y H:i')->sortable(),
        ]));
    }

    public static function mtsFilter(): Tables\Filters\TernaryFilter
    {
        return Tables\Filters\TernaryFilter::make('is_mts_subscriber')
            ->label('MTS Abonesi')
            ->trueLabel('Evet')
            ->falseLabel('Hayır');
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::participantFields())->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['event', 'user']))
            ->columns(static::participantColumns())
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->label('Etkinlik')
                    ->relationship('event', 'title', fn (Builder $query) => $query->withoutGlobalScope('active')->latest('starts_at'))
                    ->searchable()
                    ->preload(),
                static::mtsFilter(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventRegistrations::route('/'),
            'create' => Pages\CreateEventRegistration::route('/create'),
            'edit' => Pages\EditEventRegistration::route('/{record}/edit'),
        ];
    }
}
