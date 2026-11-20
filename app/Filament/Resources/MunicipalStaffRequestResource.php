<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MunicipalStaffRequestResource\Pages;
use App\Models\MunicipalStaffRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MunicipalStaffRequestResource extends Resource
{
    protected static ?string $model = MunicipalStaffRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $pluralModelLabel = 'Belediye Personel Talepleri';

    protected static ?string $modelLabel = 'Belediye Personel Talebi';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'Belediye Personel Talepleri';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Başvuruyu Yapan Üye')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Forms\Components\Placeholder::make('member_name')
                            ->label('Üye Adı Soyadı')
                            ->content(fn ($record) => $record?->user?->name ?? '— (üyelik öncesi / misafir kaydı)'),
                        Forms\Components\Placeholder::make('member_email')
                            ->label('Üye E-postası')
                            ->content(fn ($record) => $record?->user?->email ?? '—'),
                        Forms\Components\Placeholder::make('member_phone')
                            ->label('Üye Telefonu')
                            ->content(fn ($record) => $record?->user?->phone ?: '—'),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('municipality_name')->label('Belediye Adı')->required(),
                Forms\Components\TextInput::make('contact_name')->label('Yetkili')->required(),
                Forms\Components\TextInput::make('contact_email')->label('Kurumsal E-posta')->email()->required(),
                Forms\Components\TextInput::make('position_title')->label('Unvan')->required(),
                Forms\Components\Select::make('employment_status')
                    ->label('İstihdam Statüsü')
                    ->options(MunicipalStaffRequest::EMPLOYMENT_STATUS_LABELS)
                    ->required(),
                Forms\Components\TextInput::make('min_experience')->label('Min. Deneyim (yıl)')->numeric()->default(0)->required(),
                Forms\Components\TextInput::make('work_location')->label('Çalışma Yeri')->required(),
                Forms\Components\Textarea::make('description')->label('Açıklama')->required()->columnSpanFull(),
                Forms\Components\Placeholder::make('attachment_path')
                    ->label('Ek Dosya')
                    ->content(fn (?MunicipalStaffRequest $record) => $record?->attachment_path
                        ? new \Illuminate\Support\HtmlString('<a class="underline text-primary-600" href="'.Storage::url($record->attachment_path).'" target="_blank">Dosyayı görüntüle</a>')
                        : 'Ek yok'),
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
            ->modifyQueryUsing(fn ($query) => $query->with('user'))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Üye')
                    ->description(fn ($record) => $record->user?->email)
                    ->placeholder('Misafir')
                    ->searchable(['name', 'email'])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('municipality_name')->label('Belediye')->searchable(),
                Tables\Columns\TextColumn::make('position_title')->label('Unvan')->searchable(),
                Tables\Columns\TextColumn::make('employment_status')
                    ->label('Statü')
                    ->formatStateUsing(fn (string $state) => MunicipalStaffRequest::EMPLOYMENT_STATUS_LABELS[$state] ?? $state),
                Tables\Columns\TextColumn::make('contact_email')->label('E-posta')->searchable(),
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
            'index' => Pages\ListMunicipalStaffRequests::route('/'),
            'edit' => Pages\EditMunicipalStaffRequest::route('/{record}/edit'),
        ];
    }
}
