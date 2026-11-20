<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyContentResource\Pages;
use App\Filament\Resources\PolicyContentResource\RelationManagers;
use App\Models\PolicyContent;
use App\Filament\Support\ContentForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolicyContentResource extends Resource
{
    protected static ?string $model = PolicyContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Politika ve Mevzuat İçeriği';

    protected static ?string $pluralModelLabel = 'Politika ve Mevzuat İçerikleri';

    protected static ?string $navigationLabel = 'Politika ve Mevzuat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...ContentForm::titleSpotContent(spotRequired: true),
                Forms\Components\Select::make('type')
                    ->label('Tür')
                    ->options(PolicyContent::TYPE_LABELS)
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Yayın Tarihi'),
                ...ContentForm::categorySelects(),
                ContentForm::featuredImage('policycontents'),
                ContentForm::activeToggle(),
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
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge()->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL Uzantısı (Slug)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->formatStateUsing(fn (string $state): string => PolicyContent::TYPE_LABELS[$state] ?? $state)
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime()
                    ->sortable(),
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
                ContentForm::activeColumn(),
            ])
            ->filters([
                ContentForm::activeFilter(),
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

    public static function getEloquentQuery(): Builder
    {
        // Pasif içerikler de panelde listelenir ve düzenlenebilir.
        return parent::getEloquentQuery()->withoutGlobalScope('active');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolicyContents::route('/'),
            'create' => Pages\CreatePolicyContent::route('/create'),
            'edit' => Pages\EditPolicyContent::route('/{record}/edit'),
        ];
    }
}
