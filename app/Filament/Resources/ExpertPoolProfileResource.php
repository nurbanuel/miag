<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpertPoolProfileResource\Pages;
use App\Models\ExpertPoolProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ExpertPoolProfileResource extends Resource
{
    protected static ?string $model = ExpertPoolProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $pluralModelLabel = 'CV Havuzu Profilleri';

    protected static ?string $modelLabel = 'CV Havuzu Profili';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'MİARGEM CV Havuzu';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required(),
                Forms\Components\TextInput::make('email')
                    ->label('E-posta')->email()->required(),
                Forms\Components\TextInput::make('expertise_areas')->label('Uzmanlık Alanları')->required(),
                Forms\Components\Select::make('visibility')
                    ->label('Görünürlük')
                    ->options(ExpertPoolProfile::VISIBILITY_LABELS)
                    ->required(),
                Forms\Components\Placeholder::make('cv_path')
                    ->label('CV')
                    ->content(fn (?ExpertPoolProfile $record) => $record?->cv_path
                        ? new \Illuminate\Support\HtmlString('<a class="underline text-primary-600" href="'.Storage::url($record->cv_path).'" target="_blank">CV\'yi görüntüle</a>')
                        : 'Ek yok'),
                Forms\Components\Textarea::make('summary')->label('Özet')->required()->columnSpanFull(),
                Forms\Components\Toggle::make('consent_accepted')->label('Açık Rıza Onayı')->required(),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options(['beklemede' => 'Beklemede', 'incelendi' => 'İncelendi', 'onaylandi' => 'Onaylandı', 'reddedildi' => 'Reddedildi'])
                    ->default('beklemede')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('Ad Soyad')->searchable(),
                Tables\Columns\TextColumn::make('expertise_areas')->label('Uzmanlık Alanları')->searchable(),
                Tables\Columns\TextColumn::make('visibility')
                    ->label('Görünürlük')
                    ->formatStateUsing(fn (string $state) => ExpertPoolProfile::VISIBILITY_LABELS[$state] ?? $state),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')->searchable(),
                Tables\Columns\BadgeColumn::make('status')->label('Durum')->colors([
                    'warning' => 'beklemede',
                    'info' => 'incelendi',
                    'success' => 'onaylandi',
                    'danger' => 'reddedildi',
                ]),
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListExpertPoolProfiles::route('/'),
            'edit' => Pages\EditExpertPoolProfile::route('/{record}/edit'),
        ];
    }
}
