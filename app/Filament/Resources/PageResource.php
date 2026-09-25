<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Sayfa';

    protected static ?string $pluralModelLabel = 'Sayfalar';

    protected static ?string $navigationLabel = 'Sayfalar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Sayfa Başlığı')
                ->required()
                ->maxLength(255),

            Forms\Components\Section::make('Banner Alanı')->schema([
                Forms\Components\TextInput::make('banner_title')
                    ->label('Banner Başlığı')
                    ->maxLength(255),
                Forms\Components\TextInput::make('banner_subtitle')
                    ->label('Banner Alt Başlığı')
                    ->maxLength(255),
                Forms\Components\Textarea::make('banner_description')
                    ->label('Banner Açıklaması')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Ana İçerik')->schema([
                Forms\Components\RichEditor::make('content')
                    ->label('Sayfa İçeriği')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Yan Ekran (Sidebar)')->schema([
                Forms\Components\RichEditor::make('sidebar_content')
                    ->label('Sidebar İçeriği')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Sayfa Başlığı')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('URL Uzantısı (Slug)')->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Güncellenme Tarihi')->dateTime('d.m.Y H:i')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
