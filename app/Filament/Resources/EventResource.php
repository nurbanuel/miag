<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Etkinlik';

    protected static ?string $pluralModelLabel = 'Etkinlikler';

    protected static ?string $navigationLabel = 'Etkinlikler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('İçerik')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('location')
                    ->label('Konum')
                    ->required(),
                Forms\Components\TagsInput::make('speakers')
                    ->label('Konuşmacılar')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('poster_path')
                    ->label('Afiş')
                    ->image()
                    ->directory('events'),
                Forms\Components\TextInput::make('registration_url')
                    ->label('Kayıt Linki'),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Başlangıç Zamanı')
                    ->required(),
                Forms\Components\Toggle::make('is_past')
                    ->label('Geçmiş Etkinlik mi?')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->searchable()
                    ->preload(),
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->label('Öne Çıkan Görsel')
                    ->directory('events')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge()->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL Uzantısı (Slug)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Konum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poster_path')
                    ->label('Afiş')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_url')
                    ->label('Kayıt Linki')
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Başlangıç Zamanı')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_past')
                    ->label('Geçmiş Etkinlik mi?')
                    ->boolean(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
