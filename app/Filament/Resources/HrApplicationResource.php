<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HrApplicationResource\Pages;
use App\Models\HrApplication;
use App\Models\HrEducation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HrApplicationResource extends Resource
{
    protected static ?string $model = HrApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralModelLabel = 'İK Başvuruları';

    protected static ?string $modelLabel = 'İK Başvurusu';

    protected static ?string $navigationGroup = 'İK ve Kariyer Başvuruları';

    protected static ?string $navigationLabel = 'İK Başvuruları (Ortak)';

    private const STAFF_REQUEST_HINT = 'Bu alanlar talebi ileten kişiyi değil, aranan personelin niteliklerini ifade eder.';

    /** Personel talebinde unvan/eğitim alanlarına eklenen açıklama. */
    private static function staffRequestHint(string $typePath = 'type'): \Closure
    {
        return fn (Get $get) => $get($typePath) === 'personel_talebi' ? self::STAFF_REQUEST_HINT : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Başvuru Takibi')
                    ->schema([
                        Forms\Components\TextInput::make('tracking_number')
                            ->label('Takip Numarası')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Kayıtta otomatik oluşturulur'),
                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options(array_combine(HrApplication::STATUSES, HrApplication::STATUSES))
                            ->default('Alındı')
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Başvuru')
                    ->schema([
                        Forms\Components\Select::make('application_kind')
                            ->label('İş / Staj')
                            ->options(HrApplication::APPLICATION_KIND_LABELS)
                            ->visible(fn (Get $get) => $get('type') === 'is_staj'),
                        Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->maxLength(150),
                        Forms\Components\TextInput::make('email')->label('E-posta')->email()->maxLength(150),
                        Forms\Components\TextInput::make('phone')->label('Telefon')->tel()->maxLength(30),
                        Forms\Components\Select::make('type')
                            ->label('Başvuru Türü')
                            ->options(HrApplication::TYPE_LABELS)
                            ->required()
                            ->live(),
                        Forms\Components\Select::make('institution_type')
                            ->label('Kurum Türü')
                            ->options(HrApplication::INSTITUTION_TYPE_LABELS),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Unvan ve Görev')
                    ->schema([
                        Forms\Components\TextInput::make('professional_title')
                            ->label('Meslek Unvanı')
                            ->maxLength(255)
                            ->helperText(self::staffRequestHint()),
                        // Listede olmayan kadro unvanı, arama kutusuna yazılarak serbestçe eklenebilir.
                        Forms\Components\Select::make('staff_title')
                            ->label('Kadro Unvanı')
                            ->searchable()
                            ->options(fn (?string $state) => collect(HrApplication::STAFF_TITLES)
                                ->when($state, fn ($titles) => $titles->push($state))
                                ->unique()
                                ->mapWithKeys(fn ($title) => [$title => $title])
                                ->all())
                            ->getSearchResultsUsing(function (string $search) {
                                $search = trim($search);
                                $matches = collect(HrApplication::STAFF_TITLES)
                                    ->filter(fn ($title) => str_contains(mb_strtolower($title), mb_strtolower($search)))
                                    ->mapWithKeys(fn ($title) => [$title => $title]);

                                return $search !== '' && ! $matches->has($search)
                                    ? $matches->put($search, $search.' (yeni unvan olarak ekle)')->all()
                                    : $matches->all();
                            })
                            ->getOptionLabelUsing(fn ($value) => $value)
                            ->helperText(fn (Get $get) => $get('type') === 'personel_talebi'
                                ? self::STAFF_REQUEST_HINT
                                : 'Listede yoksa unvanı yazarak ekleyebilirsiniz.'),
                        Forms\Components\TextInput::make('actual_duty')
                            ->label('Fiilî Görev')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('unit')
                            ->label('Birim')
                            ->maxLength(255),
                        Forms\Components\Select::make('work_status')
                            ->label(fn (Get $get) => $get('type') === 'nakil' ? 'Çalışma Statüsü' : 'Çalışma Durumu')
                            ->options(fn (Get $get) => $get('type') === 'nakil'
                                ? HrApplication::TRANSFER_WORK_STATUS_LABELS
                                : HrApplication::WORK_STATUS_LABELS)
                            ->live(),
                        Forms\Components\Select::make('job_search_status')
                            ->label('İş Arama Durumu')
                            ->options(HrApplication::JOB_SEARCH_STATUS_LABELS),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Eğitim Bilgileri')
                    ->schema([
                        Forms\Components\Repeater::make('educations')
                            ->label('Eğitimler')
                            ->relationship()
                            ->helperText(self::staffRequestHint())
                            ->addActionLabel('Eğitim ekle')
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state) => trim(($state['university'] ?? '').' '.($state['department'] ?? '')) ?: null)
                            ->schema([
                                Forms\Components\Select::make('education_level')
                                    ->label('Eğitim Düzeyi')
                                    ->options(HrEducation::LEVEL_LABELS)
                                    ->required(),
                                Forms\Components\Select::make('student_status')
                                    ->label('Öğrenci / Mezun')
                                    ->options(HrEducation::STUDENT_STATUS_LABELS)
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('university')->label('Üniversite / Okul'),
                                Forms\Components\TextInput::make('faculty')->label('Fakülte'),
                                Forms\Components\TextInput::make('department')->label('Bölüm'),
                                Forms\Components\TextInput::make('graduation_year')
                                    ->label('Mezuniyet Yılı')
                                    ->numeric()
                                    ->minValue(1950)
                                    ->maxValue((int) date('Y') + 10)
                                    ->visible(fn (Get $get) => $get('student_status') === 'mezun'),
                                Forms\Components\TextInput::make('current_class')
                                    ->label('Sınıf')
                                    ->visible(fn (Get $get) => $get('student_status') === 'ogrenci'),
                                Forms\Components\DatePicker::make('expected_graduation_date')
                                    ->label('Beklenen Mezuniyet Tarihi')
                                    ->visible(fn (Get $get) => $get('student_status') === 'ogrenci'),
                            ])
                            ->columns(2),
                    ]),

                Forms\Components\Section::make('İş Başvurusu Ayrıntıları')
                    ->visible(fn (Get $get) => $get('application_kind') === 'is')
                    ->schema([
                        Forms\Components\TextInput::make('desired_position')->label('İstenen Görev / Pozisyon'),
                        Forms\Components\TagsInput::make('location_preferences')->label('Çalışma Yeri Tercihleri'),
                        Forms\Components\DatePicker::make('start_date')->label('İşe Başlayabileceği Tarih'),
                        Forms\Components\Textarea::make('experience_details')->label('Deneyim')->columnSpanFull(),
                        Forms\Components\Placeholder::make('cv_link')->label('CV')
                            ->content(fn (?HrApplication $record) => self::fileLink($record?->cv_path)),
                        Forms\Components\Placeholder::make('portfolio_link')->label('Portfolyo')
                            ->content(fn (?HrApplication $record) => self::fileLink($record?->portfolio_path)),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Staj Başvurusu Ayrıntıları')
                    ->visible(fn (Get $get) => $get('application_kind') === 'staj')
                    ->schema([
                        Forms\Components\TextInput::make('internship_school')->label('Okul'),
                        Forms\Components\TextInput::make('internship_department')->label('Bölüm'),
                        Forms\Components\Select::make('internship_type')->label('Staj Türü')
                            ->options(array_combine(HrApplication::INTERNSHIP_TYPES, HrApplication::INTERNSHIP_TYPES)),
                        Forms\Components\DatePicker::make('internship_start_date')->label('Staj Başlangıcı'),
                        Forms\Components\DatePicker::make('internship_end_date')->label('Staj Bitişi'),
                        Forms\Components\Placeholder::make('school_documents_link')->label('Okul Belgeleri')
                            ->content(fn (?HrApplication $record) => self::fileLink($record?->school_documents_path)),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Nakil Bilgileri')
                    ->visible(fn (Get $get) => $get('type') === 'nakil')
                    ->schema([
                        Forms\Components\TextInput::make('current_institution')->label('Mevcut Kurum'),
                        Forms\Components\Select::make('service_class')
                            ->label('Hizmet Sınıfı')
                            ->options(HrApplication::SERVICE_CLASSES)
                            ->visible(fn (Get $get) => in_array($get('work_status'), HrApplication::CIVIL_SERVANT_STATUSES, true)),
                        Forms\Components\Select::make('degree')
                            ->label('Derece')
                            ->options(array_combine(range(1, 15), range(1, 15)))
                            ->visible(fn (Get $get) => in_array($get('work_status'), HrApplication::CIVIL_SERVANT_STATUSES, true)),
                        Forms\Components\TextInput::make('total_service_time')->label('Toplam Hizmet Süresi'),
                        Forms\Components\TextInput::make('current_institution_time')->label('Mevcut Kurumdaki Hizmet Süresi'),
                        Forms\Components\TextInput::make('local_gov_experience')->label('Mahallî İdare Deneyimi'),
                        Forms\Components\Textarea::make('expertise_areas')->label('Uzmanlık Alanları')->columnSpanFull(),
                        Forms\Components\Textarea::make('transfer_reason')->label('Nakil Gerekçesi')->columnSpanFull(),
                        Forms\Components\Repeater::make('transferPreferences')
                            ->label('Görev Yeri Tercihleri (öncelik sırasıyla)')
                            ->relationship()
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->defaultItems(0)
                            ->addActionLabel('Tercih ekle')
                            ->itemLabel(fn (array $state) => collect([$state['province'] ?? null, $state['district'] ?? null, $state['institution'] ?? null])->filter()->implode(' / ') ?: null)
                            ->schema([
                                Forms\Components\TextInput::make('province')->label('İl')->required(),
                                Forms\Components\TextInput::make('district')->label('İlçe'),
                                Forms\Components\TextInput::make('institution')->label('Kurum'),
                                Forms\Components\TextInput::make('position')->label('Düşünülen Görev'),
                                Forms\Components\DatePicker::make('available_from')->label('Uygun Tarih (başlangıç)'),
                                Forms\Components\DatePicker::make('available_until')->label('Uygun Tarih (bitiş)')->afterOrEqual('available_from'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Yönetici Notları')
                    ->description('Yalnızca panelde görünür. Bu notlar bir görevlendirme veya nakil taahhüdü anlamına gelmez.')
                    ->schema([
                        Forms\Components\TextInput::make('communication_stage')
                            ->label('İletişim Aşaması')
                            ->maxLength(255)
                            ->datalist(['İletişime geçilmedi', 'İlk iletişim kuruldu', 'Ek bilgi istendi', 'Görüşme planlandı', 'Görüşme yapıldı']),
                        Forms\Components\TextInput::make('evaluation_stage')
                            ->label('Değerlendirme Aşaması')
                            ->maxLength(255)
                            ->datalist(['Ön inceleme', 'Uygunluk değerlendirmesi', 'Kurumla paylaşıldı', 'Değerlendirme tamamlandı']),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Profil')
                            ->helperText('Pasif profiller varsayılan listede ve aramalarda gösterilmez.')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Gizlilik')
                    ->description('Varsayılan olarak kapalıdır; yalnızca başvuru sahibinin onayıyla açılmalıdır.')
                    ->schema([
                        Forms\Components\Toggle::make('share_current_institution')
                            ->label('Mevcut kurum paylaşılabilir')
                            ->default(false)
                            ->visible(fn (Get $get) => $get('type') === 'nakil'),
                        Forms\Components\Toggle::make('share_contact_info')
                            ->label('İletişim bilgileri paylaşılabilir')
                            ->default(false)
                            ->visible(fn (Get $get) => $get('type') === 'nakil'),
                        Forms\Components\Toggle::make('contact_info_public')
                            ->label('İletişim bilgileri görünür')
                            ->default(false),
                        Forms\Components\Toggle::make('cv_public')
                            ->label('CV görünür')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    /** Özel diskteki başvuru dosyası için yönetici indirme bağlantısı. */
    private static function fileLink(?string $path): string|\Illuminate\Support\HtmlString
    {
        if (! $path) {
            return 'Ek yok';
        }

        return new \Illuminate\Support\HtmlString('<a class="underline text-primary-600" href="'.e(route('admin.private-file', ['path' => $path])).'" target="_blank">Dosyayı indir</a>');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tracking_number')->label('Takip No')->searchable()->copyable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Durum')
                    ->options(array_combine(HrApplication::STATUSES, HrApplication::STATUSES))
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('full_name')->label('Ad Soyad')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Başvuru Türü')
                    ->badge()
                    ->formatStateUsing(fn (string $state, HrApplication $record) => $record->application_kind
                        ? HrApplication::APPLICATION_KIND_LABELS[$record->application_kind]
                        : (HrApplication::TYPE_LABELS[$state] ?? $state)),
                Tables\Columns\TextColumn::make('professional_title')->label('Meslek Unvanı')->searchable(),
                Tables\Columns\TextColumn::make('staff_title')->label('Kadro Unvanı')->searchable(),
                Tables\Columns\TextColumn::make('unit')->label('Birim')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('institution_type')
                    ->label('Kurum Türü')
                    ->formatStateUsing(fn (?string $state) => HrApplication::INSTITUTION_TYPE_LABELS[$state] ?? $state)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('educations_count')->label('Eğitim')->counts('educations'),
                Tables\Columns\TextColumn::make('communication_stage')->label('İletişim Aşaması')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('evaluation_stage')->label('Değerlendirme Aşaması')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\IconColumn::make('contact_info_public')->label('İletişim Açık')->boolean(),
                Tables\Columns\IconColumn::make('cv_public')->label('CV Açık')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options(array_combine(HrApplication::STATUSES, HrApplication::STATUSES)),
                Tables\Filters\SelectFilter::make('type')->label('Başvuru Türü')->options(HrApplication::TYPE_LABELS),
                Tables\Filters\SelectFilter::make('application_kind')->label('İş / Staj')->options(HrApplication::APPLICATION_KIND_LABELS),
                Tables\Filters\SelectFilter::make('staff_title')
                    ->label('Kadro Unvanı')
                    ->searchable()
                    ->options(fn () => HrApplication::query()->whereNotNull('staff_title')->distinct()->orderBy('staff_title')->pluck('staff_title', 'staff_title')->all()),
                Tables\Filters\SelectFilter::make('institution_type')->label('Kurum Türü')->options(HrApplication::INSTITUTION_TYPE_LABELS),
                Tables\Filters\SelectFilter::make('work_status')->label('Çalışma Durumu / Statüsü')->options(HrApplication::allWorkStatusLabels()),
                Tables\Filters\TernaryFilter::make('cv_public')->label('CV Açık'),
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
            'index' => Pages\ListHrApplications::route('/'),
            'create' => Pages\CreateHrApplication::route('/create'),
            'edit' => Pages\EditHrApplication::route('/{record}/edit'),
        ];
    }
}
