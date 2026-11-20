<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $navigationLabel = 'Kategoriler';

    protected static ?string $modelLabel = 'Kategori';

    protected static ?string $pluralModelLabel = 'Kategoriler';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Kategori Adı')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('parent_id')
                ->label('Üst (Ana) Kategori')
                ->helperText('Boş bırakılırsa ana kategori olur. Seçilirse bu kategori, seçilen ana kategorinin alt kategorisi olur.')
                ->options(fn (?Category $record) => Category::query()
                    ->whereNull('parent_id')
                    ->when($record, fn ($q) => $q->whereKeyNot($record->getKey()))
                    ->orderBy('name')
                    ->pluck('name', 'id'))
                ->searchable()
                ->disabled(fn (?Category $record) => $record?->children()->exists())
                ->hint(fn (?Category $record) => $record?->children()->exists() ? 'Alt kategorileri olan bir kategori başka bir kategorinin altına taşınamaz.' : null),
            Forms\Components\Textarea::make('description')
                ->label('Açıklama')
                ->rows(4)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Kategori Adı')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Üst Kategori')->badge()->color('gray')->placeholder('— Ana kategori')->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Oluşturulma')->dateTime('d.m.Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Kategori Seviyesi')
                    ->nullable()
                    ->trueLabel('Alt kategoriler')
                    ->falseLabel('Ana kategoriler'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
