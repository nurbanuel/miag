<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobInternshipApplicationResource\Pages;
use App\Models\JobInternshipApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class JobInternshipApplicationResource extends Resource
{
    protected static ?string $model = JobInternshipApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $pluralModelLabel = 'İş / Staj Başvuruları';

    protected static ?string $modelLabel = 'İş / Staj Başvurusu';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'İş / Staj Başvuruları';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('applicant_type')
                    ->label('Aday Türü')
                    ->options(JobInternshipApplication::APPLICANT_TYPE_LABELS)
                    ->required(),
                Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required(),
                Forms\Components\TextInput::make('email')
                    ->label('E-posta')->email()->required(),
                Forms\Components\TextInput::make('field_of_interest')->label('İlgi Alanı')->required(),
                Forms\Components\Placeholder::make('cv_path')
                    ->label('CV')
                    ->content(fn (?JobInternshipApplication $record) => $record?->cv_path
                        ? new \Illuminate\Support\HtmlString('<a class="underline text-primary-600" href="'.Storage::url($record->cv_path).'" target="_blank">CV\'yi görüntüle</a>')
                        : 'Ek yok'),
                Forms\Components\Textarea::make('message')->label('Mesaj')->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('applicant_type')
                    ->label('Aday Türü')
                    ->formatStateUsing(fn (string $state) => JobInternshipApplication::APPLICANT_TYPE_LABELS[$state] ?? $state),
                Tables\Columns\TextColumn::make('field_of_interest')->label('İlgi Alanı')->searchable(),
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
            'index' => Pages\ListJobInternshipApplications::route('/'),
            'edit' => Pages\EditJobInternshipApplication::route('/{record}/edit'),
        ];
    }
}
