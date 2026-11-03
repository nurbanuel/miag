<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Haber';

    protected static ?string $pluralModelLabel = 'Haberler';

    protected static ?string $navigationLabel = 'Haberler';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Başlık')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('featured_image')
                ->image()
                ->label('Öne Çıkan Görsel')
                ->directory('news')
                ->columnSpanFull(),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->label('Kategori')
                ->searchable()
                ->preload(),
            Forms\Components\DatePicker::make('published_at')
                ->label('Yayın Tarihi')
                ->default(now()),
            Forms\Components\RichEditor::make('content')
                ->label('İçerik')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_featured')
                ->label('Manşete Ekle')
                ->default(false),
            Forms\Components\DateTimePicker::make('visibility_start')
                ->label('Manşet Görünürlük Başlangıcı'),
            Forms\Components\DateTimePicker::make('visibility_end')
                ->label('Manşet Görünürlük Bitişi')
                ->after('visibility_start'),
            Forms\Components\Toggle::make('has_360_badge')
                ->label('360° Etki Analizi Rozeti')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->label('Görsel')->square(),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge()->sortable(),
                Tables\Columns\TextColumn::make('published_at')->label('Yayın Tarihi')->date('d.m.Y')->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
