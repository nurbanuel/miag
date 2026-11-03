<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpertPoolResource\Pages;
use App\Models\ExpertPool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

/**
 * Uzman ve Araştırmacı Havuzu yönetimi. İK menüsünden ayrı bir grupta durur.
 * Değerlendirme notları adayla paylaşılmaz; bu kaynağa bildirim/e-posta otomasyonu bağlanmaz.
 */
class ExpertPoolResource extends Resource
{
    protected static ?string $model = ExpertPool::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $pluralModelLabel = 'Uzman ve Araştırmacılar';

    protected static ?string $modelLabel = 'Uzman / Araştırmacı';

    protected static ?string $navigationGroup = 'Uzman Havuzu';

    protected static ?string $navigationLabel = 'Uzman ve Araştırmacı Havuzu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Değerlendirme (yalnızca yöneticiler)')
                    ->description('Bu alanlar adayla paylaşılmaz ve herhangi bir bildirim tetiklemez.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Başvuru Durumu')
                            ->options(array_combine(ExpertPool::STATUSES, ExpertPool::STATUSES))
                            ->default('Bekliyor')
                            ->required()
                            ->native(false),
                        Forms\Components\Textarea::make('evaluation_notes')
                            ->label('Değerlendirme Notları')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Temel Profil')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required(),
                        Forms\Components\TextInput::make('email')->label('E-posta')->email()->required(),
                        Forms\Components\TextInput::make('phone')->label('Telefon')->tel(),
                        Forms\Components\TextInput::make('current_institution')->label('Mevcut Kurum'),
                        Forms\Components\TextInput::make('actual_duty')->label('Fiilî Görev'),
                        Forms\Components\TextInput::make('unit')->label('Birim'),
                        Forms\Components\Textarea::make('expertise_summary')->label('Uzmanlık Özeti')->required()->rows(4)->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Eğitim ve Akademik Bilgi')
                    ->schema([
                        Forms\Components\Select::make('education_level')->label('Öğrenim Düzeyi')->options(ExpertPool::EDUCATION_LEVEL_LABELS)->required(),
                        Forms\Components\TextInput::make('university')->label('Üniversite')->required(),
                        Forms\Components\TextInput::make('faculty')->label('Fakülte'),
                        Forms\Components\TextInput::make('department')->label('Bölüm')->required(),
                        Forms\Components\TextInput::make('graduation_year')->label('Mezuniyet Yılı')->numeric(),
                        Forms\Components\TextInput::make('profession_title')->label('Meslek Unvanı')->required(),
                        Forms\Components\Select::make('academic_title')
                            ->label('Akademik Unvan')
                            ->options(array_combine(ExpertPool::ACADEMIC_TITLES, ExpertPool::ACADEMIC_TITLES)),
                        Forms\Components\TextInput::make('academic_duty')->label('Akademik Görev'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Uzmanlık ve Katkı')
                    ->schema([
                        Forms\Components\Select::make('expertise_areas')
                            ->label('Uzmanlık Alanları')
                            ->multiple()
                            ->options(ExpertPool::EXPERTISE_AREAS)
                            ->required(),
                        Forms\Components\CheckboxList::make('contribution_types')
                            ->label('Katkı Türleri')
                            ->options(ExpertPool::CONTRIBUTION_TYPES)
                            ->columns(2)
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Deneyim ve Üretimler')
                    ->schema([
                        Forms\Components\TextInput::make('total_experience')->label('Toplam Deneyim')->required(),
                        Forms\Components\TextInput::make('local_gov_experience')->label('Mahallî İdare Deneyimi')->required(),
                        Forms\Components\Repeater::make('experience_links')
                            ->label('Yayın / Proje Bağlantıları')
                            ->defaultItems(0)
                            ->schema([
                                Forms\Components\Select::make('type')->label('Tür')->options(ExpertPool::LINK_TYPES)->required(),
                                Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                                Forms\Components\TextInput::make('url')->label('Bağlantı')->url(),
                                Forms\Components\TextInput::make('year')->label('Yıl')->numeric(),
                            ])
                            ->columns(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Yetkinlik ve Uygunluk')
                    ->schema([
                        Forms\Components\TagsInput::make('foreign_languages')->label('Yabancı Diller'),
                        Forms\Components\Textarea::make('digital_tools')->label('Dijital Araçlar')->rows(2),
                        Forms\Components\Select::make('contribution_period')->label('Katkı Süresi')->options(ExpertPool::CONTRIBUTION_PERIODS)->required(),
                        Forms\Components\Select::make('work_format')->label('Çalışma Biçimi')->options(ExpertPool::WORK_FORMATS)->required(),
                        Forms\Components\Placeholder::make('cv_link')
                            ->label('CV')
                            ->content(fn (?ExpertPool $record) => $record?->cv_path
                                ? new HtmlString('<a class="underline text-primary-600" href="'.e(route('admin.private-file', ['path' => $record->cv_path])).'" target="_blank">CV’yi indir</a>')
                                : 'Ek yok'),
                        Forms\Components\Toggle::make('profile_visibility')->label('Profil görünür')->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('Ad Soyad')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('profession_title')->label('Meslek Unvanı')->searchable(),
                Tables\Columns\TextColumn::make('academic_title')->label('Akademik Unvan')->toggleable(),
                Tables\Columns\TextColumn::make('expertise_areas')
                    ->label('Uzmanlık Alanları')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => ExpertPool::EXPERTISE_AREAS[$state] ?? $state)
                    ->limitList(2)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Havuza Alındı' => 'success',
                        'İnceleniyor' => 'info',
                        'Uygun Bulunmadı' => 'danger',
                        'İleride Değerlendirilecek' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('profile_visibility')->label('Görünür')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options(array_combine(ExpertPool::STATUSES, ExpertPool::STATUSES)),
                Tables\Filters\SelectFilter::make('expertise_areas')
                    ->label('Uzmanlık Alanı')
                    ->options(ExpertPool::EXPERTISE_AREAS)
                    ->query(fn ($query, array $data) => $query->when($data['value'] ?? null, fn ($q, $v) => $q->whereJsonContains('expertise_areas', $v))),
                Tables\Filters\SelectFilter::make('contribution_types')
                    ->label('Katkı Türü')
                    ->options(ExpertPool::CONTRIBUTION_TYPES)
                    ->query(fn ($query, array $data) => $query->when($data['value'] ?? null, fn ($q, $v) => $q->whereJsonContains('contribution_types', $v))),
                Tables\Filters\SelectFilter::make('academic_title')->label('Akademik Unvan')->options(array_combine(ExpertPool::ACADEMIC_TITLES, ExpertPool::ACADEMIC_TITLES)),
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
            'index' => Pages\ListExpertPools::route('/'),
            'create' => Pages\CreateExpertPool::route('/create'),
            'edit' => Pages\EditExpertPool::route('/{record}/edit'),
        ];
    }
}
