<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $modelLabel = 'Site Ayarları';

    protected static ?string $pluralModelLabel = 'Site Ayarları';

    protected static ?string $navigationLabel = 'Site Ayarları';

    public static function canCreate(): bool
    {
        return SiteSetting::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Ana Menü (Header)')->schema([
                Forms\Components\Repeater::make('header_menu')
                    ->label('Menü Öğeleri')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                        Forms\Components\TextInput::make('url')->label('URL')->required(),
                        Forms\Components\Repeater::make('children')
                            ->label('Alt Menüler')
                            ->schema([
                                Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                                Forms\Components\TextInput::make('url')->label('URL')->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->collapsible(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Footer')->schema([
                Forms\Components\Textarea::make('footer_about_text')
                    ->label('Footer Hakkımızda Yazısı')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('footer_quick_links')
                    ->label('Hızlı Bağlantılar')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                        Forms\Components\TextInput::make('url')->label('URL')->required(),
                    ])
                    ->columns(2)
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),

                Forms\Components\Repeater::make('footer_legal_links')
                    ->label('Yasal')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                        Forms\Components\TextInput::make('url')->label('URL')->required(),
                    ])
                    ->columns(2)
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),

                Forms\Components\TextInput::make('footer_copyright_text')
                    ->label('Telif Hakkı Yazısı')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('footer_copyright_text')->label('Telif Hakkı Yazısı'),
                Tables\Columns\TextColumn::make('updated_at')->label('Güncellenme Tarihi')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
