<?php

namespace App\Filament\Support;

use App\Models\Category;
use App\Support\RichTextAlignment;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;

/**
 * İçerik modüllerinin (Yazılar, Raporlar, Haberler, Politika, Etkinlikler, Duyurular)
 * ortak form ve tablo bileşenleri.
 */
class ContentForm
{
    public const IMAGE_HELP = 'Önerilen görsel boyutu: 1200x675 px (16:9 yatay format, maks. 2 MB). Ana manşette kullanılacak görseller için 1600x900 px önerilir.';

    /** Başlık, Özet/Spot ve Metin — ayrı ve sıralı alanlar. */
    public static function titleSpotContent(string $contentField = 'content', bool $contentRequired = false, bool $spotRequired = false): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('Başlık')
                ->required()
                ->maxLength(500)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('spot')
                ->label('Özet / Spot')
                ->rows(3)
                ->required($spotRequired)
                ->helperText('İçeriğin girişinde ve listeleme kartlarında görünecek bir paragraflık özet metin.')
                ->columnSpanFull(),
            static::editor($contentField)
                ->label('Metin')
                ->required($contentRequired),
        ];
    }

    /** Kalın, başlık, paragraf, liste, bağlantı ve hizalama araçlı metin editörü. */
    public static function editor(string $name): Forms\Components\RichEditor
    {
        return Forms\Components\RichEditor::make($name)
            ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'strike',
                'link',
                'h2',
                'h3',
                'blockquote',
                'bulletList',
                'orderedList',
                'attachFiles',
                'undo',
                'redo',
            ])
            ->fileAttachmentsDirectory('editor')
            ->extraAttributes(['class' => 'miargem-content-editor'])
            ->afterStateHydrated(fn (Forms\Components\RichEditor $component, ?string $state) => $component->state(RichTextAlignment::toEditor($state)))
            ->dehydrateStateUsing(fn (?string $state) => RichTextAlignment::toStorage($state))
            ->columnSpanFull();
    }

    /** Ana kategori + ona bağlı alt kategori. */
    public static function categorySelects(): array
    {
        $hasChildren = fn (Get $get): bool => filled($get('category_id'))
            && Category::where('parent_id', $get('category_id'))->exists();

        return [
            Forms\Components\Select::make('category_id')
                ->label('Ana Kategori')
                ->options(fn () => Category::roots()->orderBy('name')->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn (Set $set) => $set('sub_category_id', null)),
            Forms\Components\Select::make('sub_category_id')
                ->label('Alt Kategori')
                ->options(fn (Get $get) => filled($get('category_id'))
                    ? Category::where('parent_id', $get('category_id'))->orderBy('name')->pluck('name', 'id')
                    : [])
                ->searchable()
                ->required($hasChildren)
                ->disabled(fn (Get $get): bool => ! $hasChildren($get))
                ->placeholder(fn (Get $get): string => $hasChildren($get) ? 'Alt kategori seçin' : 'Bu kategorinin alt kategorisi yok')
                ->helperText('Alt kategoriler, Kategoriler ekranında "Üst (Ana) Kategori" seçilerek tanımlanır.'),
        ];
    }

    public static function featuredImage(string $directory, string $field = 'featured_image', string $label = 'Öne Çıkan Görsel'): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make($field)
            ->label($label)
            ->image()
            ->imageEditor()
            ->imageCropAspectRatio('16:9')
            ->imageEditorAspectRatios(['16:9', null])
            ->maxSize(2048)
            ->directory($directory)
            ->helperText(self::IMAGE_HELP)
            ->columnSpanFull();
    }

    public static function activeToggle(): Forms\Components\Toggle
    {
        return Forms\Components\Toggle::make('is_active')
            ->label('Yayında (Aktif)')
            ->helperText('Kapatıldığında içerik silinmeden siteden gizlenir.')
            ->default(true);
    }

    public static function activeColumn(): Tables\Columns\ToggleColumn
    {
        return Tables\Columns\ToggleColumn::make('is_active')->label('Durum');
    }

    public static function activeFilter(): Tables\Filters\TernaryFilter
    {
        return Tables\Filters\TernaryFilter::make('is_active')
            ->label('Yayın Durumu')
            ->trueLabel('Yayında')
            ->falseLabel('Pasif');
    }
}
