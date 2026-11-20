<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use App\Filament\Support\ContentForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Rapor / Analiz';

    protected static ?string $pluralModelLabel = 'Rapor ve Analizler';

    protected static ?string $navigationLabel = 'Rapor ve Analizler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...ContentForm::titleSpotContent(),
                Forms\Components\Select::make('sub_category')
                    ->label('Tür (Rapor / Analiz)')
                    ->options(['Rapor' => 'Rapor', 'Analiz' => 'Analiz'])
                    ->default('Rapor')
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('cover_color')
                    ->label('Kapak Rengi')
                    ->options(['navy' => 'Lacivert', 'turquoise' => 'Turkuaz', 'bordo' => 'Bordo'])
                    ->required(),
                ...ContentForm::categorySelects(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('PDF Dosyası')
                    ->directory('reports')
                    ->acceptedFileTypes(['application/pdf']),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Yayın Tarihi'),
                ContentForm::featuredImage('reports'),
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
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL Uzantısı (Slug)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_category')
                    ->label('Tür')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'Analiz' ? 'warning' : 'info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cover_color')
                    ->label('Kapak Rengi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Dosya')
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
                Tables\Filters\SelectFilter::make('sub_category')
                    ->label('Tür')
                    ->options(['Rapor' => 'Rapor', 'Analiz' => 'Analiz']),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
