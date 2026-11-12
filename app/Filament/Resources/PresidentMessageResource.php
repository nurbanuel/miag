<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresidentMessageResource\Pages;
use App\Models\PresidentMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PresidentMessageResource extends Resource
{
    protected static ?string $model = PresidentMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Başkanın Mesajı';

    protected static ?string $pluralModelLabel = 'Başkanın Mesajı';

    protected static ?string $navigationLabel = 'Başkanın Mesajı';

    /**
     * Tekil kayıt (singleton): yalnızca hiç kayıt yokken oluşturmaya izin ver.
     */
    public static function canCreate(): bool
    {
        return PresidentMessage::query()->doesntExist();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('president_name')
                    ->label('Ad Soyad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('president_title')
                    ->label('Unvan')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Fotoğraf')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('president')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Mesaj İçeriği')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Fotoğraf')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('president_name')
                    ->label('Ad Soyad'),
                Tables\Columns\TextColumn::make('president_title')
                    ->label('Unvan'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme Tarihi')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresidentMessages::route('/'),
            'create' => Pages\CreatePresidentMessage::route('/create'),
            'edit' => Pages\EditPresidentMessage::route('/{record}/edit'),
        ];
    }
}
