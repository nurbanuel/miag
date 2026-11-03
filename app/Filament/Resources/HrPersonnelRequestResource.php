<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HrPersonnelRequestResource\Pages;
use App\Models\HrApplication;
use App\Models\HrPersonnelRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HrPersonnelRequestResource extends Resource
{
    protected static ?string $model = HrPersonnelRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $pluralModelLabel = 'Personel Talepleri';

    protected static ?string $modelLabel = 'Personel Talebi';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'Personel Talepleri (Kurum)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kurum ve Yetkili Bilgileri')
                    ->description('Talebi ileten kurum ve yetkili kişiye ait bilgiler.')
                    ->schema([
                        Forms\Components\TextInput::make('institution_name')->label('Kurum Adı')->required()->maxLength(255),
                        Forms\Components\Select::make('institution_type')
                            ->label('Kurum Türü')
                            ->options(HrApplication::INSTITUTION_TYPE_LABELS)
                            ->required(),
                        Forms\Components\TextInput::make('unit')->label('Birim')->maxLength(255),
                        Forms\Components\TextInput::make('authorized_person_name')->label('Yetkili Adı Soyadı')->required()->maxLength(150),
                        Forms\Components\TextInput::make('authorized_person_title')
                            ->label('Yetkilinin Görev Unvanı')
                            ->helperText('Talebi ileten kişinin unvanı.')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('corporate_email')->label('Kurumsal E-posta')->email()->required()->maxLength(150),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Talep Edilen Pozisyon')
                    ->description('Aranan personele ait bilgiler.')
                    ->schema([
                        Forms\Components\TextInput::make('requested_position_title')
                            ->label('Aranan Kadro / Pozisyon Unvanı')
                            ->helperText('Aranan personelin unvanı; talebi ileten kişinin değil.')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('work_status')
                            ->label('Çalışma Statüsü')
                            ->options(HrPersonnelRequest::WORK_STATUS_LABELS)
                            ->required(),
                        Forms\Components\TextInput::make('personnel_count')->label('Personel Sayısı')->numeric()->minValue(1)->maxValue(500)->default(1)->required(),
                        Forms\Components\TextInput::make('work_location')->label('Çalışma Yeri')->required()->maxLength(255),
                        Forms\Components\Textarea::make('job_description')->label('Görev Tanımı')->required()->rows(4)->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Aranan Nitelikler')
                    ->description('Eğitim ve deneyim bilgileri aranan pozisyona aittir.')
                    ->schema([
                        Forms\Components\Select::make('education_level')->label('Eğitim Düzeyi')->options(HrPersonnelRequest::EDUCATION_LEVEL_LABELS),
                        Forms\Components\TextInput::make('profession_title')->label('Meslek Unvanı')->maxLength(255),
                        Forms\Components\Textarea::make('accepted_programs')->label('Kabul Edilen Bölümler / Programlar')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('minimum_experience')->label('Asgari Deneyim')->maxLength(100),
                        Forms\Components\Textarea::make('mandatory_conditions')->label('Zorunlu Koşullar')->rows(4)->columnSpanFull(),
                        Forms\Components\Textarea::make('preferred_conditions')->label('Tercih Sebepleri')->rows(4)->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Süre ve Başvuru')
                    ->schema([
                        Forms\Components\DatePicker::make('deadline_date')
                            ->label('Son Başvuru Tarihi')
                            ->helperText('Bu tarihten sonra talep aktif listeden ve ön yüzden otomatik olarak düşer.')
                            ->required(),
                        Forms\Components\TextInput::make('application_channel')->label('Başvuru Kanalı (e-posta / bağlantı)')->required()->maxLength(255),
                        // Adaylardan CV istenmez; yalnızca talebi açıklayan ek belge saklanır.
                        Forms\Components\FileUpload::make('additional_document_path')
                            ->label('Talebi Açıklayan Ek Belge')
                            ->disk('local')
                            ->directory('hr-personnel-requests')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->downloadable(),
                        Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('institution_name')->label('Kurum')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('requested_position_title')->label('Aranan Pozisyon Unvanı')->searchable(),
                Tables\Columns\TextColumn::make('authorized_person_title')->label('Yetkili Unvanı')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('work_status')
                    ->label('Statü')
                    ->formatStateUsing(fn (?string $state) => HrPersonnelRequest::WORK_STATUS_LABELS[$state] ?? $state),
                Tables\Columns\TextColumn::make('personnel_count')->label('Kişi')->numeric(),
                Tables\Columns\TextColumn::make('deadline_date')
                    ->label('Son Başvuru')
                    ->date('d.m.Y')
                    ->sortable()
                    ->color(fn (HrPersonnelRequest $record) => $record->deadline_date?->isPast() && ! $record->deadline_date->isToday() ? 'danger' : null),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Oluşturma')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('deadline_date')
            ->filters([
                Tables\Filters\SelectFilter::make('institution_type')->label('Kurum Türü')->options(HrApplication::INSTITUTION_TYPE_LABELS),
                Tables\Filters\SelectFilter::make('work_status')->label('Statü')->options(HrPersonnelRequest::WORK_STATUS_LABELS),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHrPersonnelRequests::route('/'),
            'create' => Pages\CreateHrPersonnelRequest::route('/create'),
            'edit' => Pages\EditHrPersonnelRequest::route('/{record}/edit'),
        ];
    }
}
