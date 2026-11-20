<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalDocumentResource\Pages;
use App\Filament\Support\ContentForm;
use App\Models\LegalDocument;
use App\Support\RichTextAlignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LegalDocumentResource extends Resource
{
    protected static ?string $model = LegalDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $navigationLabel = 'Yasal Metinler';

    protected static ?string $modelLabel = 'Yasal Metin';

    protected static ?string $pluralModelLabel = 'Yasal Metinler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Başlık')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->label('URL Bağlantısı')
                        ->prefix(url('/').'/')
                        ->required()
                        ->maxLength(255)
                        ->alphaDash()
                        ->unique(ignoreRecord: true)
                        ->notIn(static::reservedSlugs())
                        ->validationMessages(['not_in' => 'Bu adres sitede başka bir sayfa tarafından kullanılıyor.']),
                    Forms\Components\Toggle::make('is_active')
                        ->label("Footer'da ve Sitede Göster")
                        ->default(true)
                        ->inline(false),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Sıra')
                        ->numeric()
                        ->default(0),
                ])->columns(2),

                // Trix editörü tablo desteklemez. Tablo içeren metinler (ör. KVKK 7. madde) HTML
                // kaynak modunda düzenlenir; aksi hâlde editörde kaydetmek tabloyu bozar.
                Forms\Components\Toggle::make('html_mode')
                    ->label('HTML kaynak modunda düzenle (tablo içeren metinler için)')
                    ->helperText('Metin editörü tablo desteklemez. Tablo içeren metinler bu modda açılır; tabloyu bozmamak için açık bırakın.')
                    ->dehydrated(false)
                    ->live()
                    ->afterStateHydrated(fn (Forms\Components\Toggle $component, Get $get) => $component->state(str_contains((string) $get('content'), '<table'))),

                ContentForm::editor('content')
                    ->label('Metin İçeriği')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'h2', 'h3', 'blockquote', 'bulletList', 'orderedList', 'undo', 'redo'])
                    ->required()
                    ->visible(fn (Get $get): bool => ! $get('html_mode')),

                Forms\Components\Textarea::make('content')
                    ->label('Metin İçeriği (HTML)')
                    ->helperText('Başlık: <h2>, alt başlık: <h3>, paragraf: <p>, kalın: <strong>, liste: <ul><li>, tablo: <table><tr><th>/<td>.')
                    ->rows(28)
                    ->required()
                    ->extraInputAttributes(['class' => 'font-mono text-xs', 'spellcheck' => 'false'])
                    ->dehydrateStateUsing(fn (?string $state) => RichTextAlignment::toStorage($state))
                    ->visible(fn (Get $get): bool => (bool) $get('html_mode'))
                    ->columnSpanFull(),
            ]);
    }

    /** Sitedeki diğer tek seviyeli adreslerle çakışmayı önler. */
    public static function reservedSlugs(): array
    {
        return collect(app('router')->getRoutes())
            ->map(fn ($route) => explode('/', trim(preg_replace('#^en/?#', '', $route->uri()), '/'))[0] ?? '')
            ->filter(fn ($segment) => $segment !== '' && ! str_starts_with($segment, '{'))
            ->unique()
            ->reject(fn ($segment) => LegalDocument::where('slug', $segment)->exists())
            ->values()
            ->all();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->formatStateUsing(fn (string $state): string => '/'.$state)
                    ->url(fn (LegalDocument $record): string => url('/'.$record->slug), shouldOpenInNewTab: true)
                    ->color('primary'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Yayında'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme')
                    ->dateTime('d.m.Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->paginated(false)
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
            'index' => Pages\ListLegalDocuments::route('/'),
            'create' => Pages\CreateLegalDocument::route('/create'),
            'edit' => Pages\EditLegalDocument::route('/{record}/edit'),
        ];
    }
}
