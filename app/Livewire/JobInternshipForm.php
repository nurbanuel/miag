<?php

namespace App\Livewire;

use App\Models\HrApplication;
use App\Models\HrEducation;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Component;

/**
 * İş / staj başvurusu ön yüz formu. Kayıtlar yalnızca hr_applications tablosuna yazılır;
 * Uzman Havuzu'na herhangi bir aktarım yapılmaz.
 */
class JobInternshipForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $trackingNumber = null;

    public function mount(): void
    {
        $this->form->fill([
            'full_name' => auth()->user()?->name,
            'email' => auth()->user()?->email,
            'phone' => auth()->user()?->phone,
        ]);
    }

    public function form(Form $form): Form
    {
        $isJob = fn (Get $get) => $get('application_kind') === 'is';
        $isInternship = fn (Get $get) => $get('application_kind') === 'staj';
        $hasKind = fn (Get $get) => filled($get('application_kind'));

        return $form
            ->model(HrApplication::class)
            ->statePath('data')
            ->schema([
                Forms\Components\ToggleButtons::make('application_kind')
                    ->label('Başvuru Türü')
                    ->options(HrApplication::APPLICATION_KIND_LABELS)
                    ->icons(['is' => 'heroicon-o-briefcase', 'staj' => 'heroicon-o-academic-cap'])
                    ->inline()
                    ->required()
                    ->live(),

                Forms\Components\Section::make('Temel Bilgiler')
                    ->visible($hasKind)
                    ->schema([
                        Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required()->maxLength(150),
                        Forms\Components\TextInput::make('email')->label('E-posta')->email()->required()->maxLength(150),
                        Forms\Components\TextInput::make('phone')->label('Telefon')->tel()->required()->maxLength(30),
                    ])
                    ->columns(['md' => 3]),

                Forms\Components\Section::make('Eğitim Bilgileri')
                    ->description('Birden fazla eğitim kaydını ayrı ayrı ekleyebilirsiniz.')
                    ->visible($hasKind)
                    ->schema([
                        Forms\Components\Repeater::make('educations')
                            ->hiddenLabel()
                            ->relationship()
                            ->addActionLabel('Eğitim ekle')
                            ->minItems(1)
                            ->defaultItems(1)
                            ->schema([
                                Forms\Components\Select::make('education_level')
                                    ->label('Eğitim Düzeyi')
                                    ->options(HrEducation::LEVEL_LABELS)
                                    ->required(),
                                Forms\Components\Select::make('student_status')
                                    ->label('Öğrenci / Mezun Durumu')
                                    ->options(HrEducation::STUDENT_STATUS_LABELS)
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('university')->label('Üniversite / Okul')->required()->maxLength(255),
                                Forms\Components\TextInput::make('faculty')->label('Fakülte')->maxLength(255),
                                Forms\Components\TextInput::make('department')->label('Bölüm')->maxLength(255),
                                Forms\Components\TextInput::make('graduation_year')
                                    ->label('Mezuniyet Yılı')
                                    ->numeric()
                                    ->minValue(1950)
                                    ->maxValue((int) date('Y'))
                                    ->visible(fn (Get $get) => $get('student_status') === 'mezun'),
                                Forms\Components\TextInput::make('current_class')
                                    ->label('Sınıf')
                                    ->required()
                                    ->maxLength(20)
                                    ->visible(fn (Get $get) => $get('student_status') === 'ogrenci'),
                                Forms\Components\DatePicker::make('expected_graduation_date')
                                    ->label('Beklenen Mezuniyet Tarihi')
                                    ->native(false)
                                    ->displayFormat('d.m.Y')
                                    ->minDate(now()->startOfMonth())
                                    ->visible(fn (Get $get) => $get('student_status') === 'ogrenci'),
                            ])
                            ->columns(['md' => 2]),
                    ]),

                Forms\Components\Section::make('İş Başvurusu')
                    ->visible($isJob)
                    ->schema([
                        Forms\Components\TextInput::make('desired_position')->label('İstenen Görev / Pozisyon')->required()->maxLength(255),
                        Forms\Components\Select::make('work_status')
                            ->label('Çalışma Durumu')
                            ->options(HrApplication::WORK_STATUS_LABELS)
                            ->required(),
                        Forms\Components\Select::make('job_search_status')
                            ->label('İş Arama Durumu')
                            ->options(HrApplication::JOB_SEARCH_STATUS_LABELS)
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('İşe Başlayabileceğiniz Tarih')
                            ->native(false)
                            ->displayFormat('d.m.Y')
                            ->minDate(today()),
                        Forms\Components\TagsInput::make('location_preferences')
                            ->label('Çalışma Yeri Tercihleri')
                            ->placeholder('İl / ilçe yazıp Enter’a basın')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('experience_details')
                            ->label('Deneyim')
                            ->rows(4)
                            ->maxLength(3000)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('cv_path')
                            ->label('CV')
                            ->disk('local')
                            ->directory('hr-applications/cv')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->helperText('PDF veya DOCX, en fazla 10 MB.')
                            ->required(),
                        Forms\Components\FileUpload::make('portfolio_path')
                            ->label('Portfolyo')
                            ->disk('local')
                            ->directory('hr-applications/portfolio')
                            ->acceptedFileTypes(['application/pdf', 'application/zip', 'image/jpeg', 'image/png'])
                            ->maxSize(20480)
                            ->helperText('İsteğe bağlı. PDF, ZIP veya görsel, en fazla 20 MB.'),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Staj Başvurusu')
                    ->visible($isInternship)
                    ->schema([
                        Forms\Components\TextInput::make('internship_school')->label('Okul')->required()->maxLength(255),
                        Forms\Components\TextInput::make('internship_department')->label('Bölüm')->required()->maxLength(255),
                        Forms\Components\Radio::make('internship_type')
                            ->label('Staj Türü')
                            ->options(array_combine(HrApplication::INTERNSHIP_TYPES, HrApplication::INTERNSHIP_TYPES))
                            ->inline()
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('internship_start_date')
                            ->label('Staj Başlangıç Tarihi')
                            ->native(false)
                            ->displayFormat('d.m.Y')
                            ->minDate(today())
                            ->required()
                            ->live(),
                        Forms\Components\DatePicker::make('internship_end_date')
                            ->label('Staj Bitiş Tarihi')
                            ->native(false)
                            ->displayFormat('d.m.Y')
                            ->required()
                            ->minDate(fn (Get $get) => $get('internship_start_date') ?: today())
                            ->afterOrEqual('internship_start_date'),
                        Forms\Components\FileUpload::make('school_documents_path')
                            ->label('Okulun Talep Ettiği Belgeler')
                            ->disk('local')
                            ->directory('hr-applications/school-documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(10240)
                            ->helperText('Staj formu, sigorta yazısı vb. PDF veya görsel, en fazla 10 MB.')
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Checkbox::make('consent_accepted')
                    ->label(new HtmlString('<a href="'.e(lroute('legal.kvkk')).'" target="_blank" class="underline">KVKK Aydınlatma Metni</a>’ni okudum; başvurumun değerlendirilmesi amacıyla bilgilerimin işlenmesine onay veriyorum.'))
                    ->accepted()
                    ->visible($hasKind),
            ]);
    }

    public function submit(): void
    {
        abort_unless(auth()->check(), 403);

        $data = $this->form->getState();

        $application = HrApplication::create([
            ...$data,
            'type' => 'is_staj',
            'user_id' => auth()->id(),
            'status' => 'Alındı',
            'consent_accepted' => true,
            // Gizlilik: bu formdan gelen kayıtlar her zaman kapalı başlar.
            'contact_info_public' => false,
            'cv_public' => false,
        ]);

        $this->form->model($application)->saveRelationships();

        $this->trackingNumber = $application->tracking_number;
        $this->data = [];
        $this->mount();
    }

    public function render(): View
    {
        return view('livewire.job-internship-form');
    }
}
