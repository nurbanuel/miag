<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorporateSectionResource\Pages;
use App\Models\CorporateSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CorporateSectionResource extends Resource
{
    protected static ?string $model = CorporateSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $navigationLabel = 'Kurumsal Sayfası';

    protected static ?string $modelLabel = 'Kurumsal Bölüm';

    protected static ?string $pluralModelLabel = 'Kurumsal Bölümler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::sectionFields());
    }

    /**
     * Bölüm form alanları; "Sayfalar > Kurumsal" ekranındaki repeater ile ortak kullanılır.
     */
    public static function sectionFields(): array
    {
        return [
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Bölüm / Sekme Başlığı')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->label('Bağlantı Anahtarı')
                        ->helperText('Sayfa içi bağlantı kimliği (ör. /kurumsal#tarihce).')
                        ->required()
                        ->maxLength(255)
                        ->alphaDash()
                        ->unique(table: CorporateSection::class, column: 'slug', ignoreRecord: true),
                    Forms\Components\Select::make('display_type')
                        ->label('Görünüm Formatı')
                        ->options(CorporateSection::DISPLAY_TYPES)
                        ->default('standard')
                        ->required()
                        ->native(false),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Sitede Göster')
                        ->default(true)
                        ->inline(false),
                ])->columns(2),

                Forms\Components\RichEditor::make('content')
                    ->label('Bölüm Ana Metni / Giriş Açıklaması')
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('items')
                    ->label('Bölüm Alt Öğeleri / Kartlar / Akordeonlar / Üyeler')
                    ->helperText('Misyon/Vizyon formatında: yalnızca başlık = ara başlık; başlık + açıklama = kart; vurgu etiketi (ör. a) + açıklama = öncelik maddesi.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Alt Başlık / Üye Adı Soyadı / Madde Başlığı'),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Üye Görevi / Vurgu Etiketi (Opsiyonel)'),
                        Forms\Components\RichEditor::make('description')
                            ->label('Alt Açıklama Metni (Opsiyonel)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->reorderable()
                    ->defaultItems(0)
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? (filled($state['subtitle'] ?? null) ? $state['subtitle'].')' : null))
                    ->columnSpanFull(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_type')
                    ->label('Görünüm Tipi')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CorporateSection::DISPLAY_TYPES[$state] ?? (string) $state)
                    ->color(fn (?string $state): string => match ($state) {
                        'mission_vision' => 'success',
                        'cards' => 'info',
                        'accordion' => 'warning',
                        'team' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Yayında'),
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
            'index' => Pages\ListCorporateSections::route('/'),
            'create' => Pages\CreateCorporateSection::route('/create'),
            'edit' => Pages\EditCorporateSection::route('/{record}/edit'),
        ];
    }
}
