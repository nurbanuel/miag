<?php

namespace App\Livewire;

use App\Models\HrApplication;
use App\Models\HrPersonnelRequest;
use Closure;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Component;

/**
 * Belediye personel talebi ön yüz formu. Kayıtlar hr_personnel_requests tablosuna yazılır;
 * iş başvurularından bağımsızdır ve adaylardan CV istenmez.
 */
class PersonnelRequestForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public bool $submitted = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->form->fill([
            'authorized_person_name' => $user?->name,
            // Kurumsal e-posta zorunlu: üyenin e-postası kişisel sağlayıcıdaysa boş bırakılır.
            'corporate_email' => $user && ! in_array(mb_strtolower((string) substr(strrchr($user->email, '@') ?: '', 1)), HrPersonnelRequest::PUBLIC_EMAIL_DOMAINS, true) ? $user->email : null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(HrPersonnelRequest::class)
            ->statePath('data')
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
                            ->helperText('Talebi ileten kişinin unvanı (ör. İnsan Kaynakları Müdürü).')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('corporate_email')
                            ->label('Kurumsal E-posta')
                            ->email()
                            ->required()
                            ->maxLength(150)
                            ->rule(fn () => function (string $attribute, $value, Closure $fail) {
                                $domain = mb_strtolower((string) substr(strrchr((string) $value, '@') ?: '', 1));
                                if (in_array($domain, HrPersonnelRequest::PUBLIC_EMAIL_DOMAINS, true)) {
                                    $fail('Lütfen kurumsal e-posta adresinizi kullanın.');
                                }
                            }),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Talep Edilen Pozisyon')
                    ->description('Bu bölüm aranan personele aittir.')
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
                        Forms\Components\TextInput::make('personnel_count')
                            ->label('Personel Sayısı')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->maxValue(500)
                            ->default(1)
                            ->required(),
                        Forms\Components\TextInput::make('work_location')->label('Çalışma Yeri')->placeholder('İl / ilçe / hizmet binası')->required()->maxLength(255),
                        Forms\Components\Textarea::make('job_description')
                            ->label('Görev Tanımı')
                            ->rows(4)
                            ->minLength(20)
                            ->maxLength(3000)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Aranan Nitelikler')
                    ->description('Eğitim ve deneyim bilgileri aranan pozisyona aittir.')
                    ->schema([
                        Forms\Components\Select::make('education_level')
                            ->label('Eğitim Düzeyi')
                            ->options(HrPersonnelRequest::EDUCATION_LEVEL_LABELS)
                            ->required(),
                        Forms\Components\TextInput::make('profession_title')->label('Meslek Unvanı')->maxLength(255),
                        Forms\Components\Textarea::make('accepted_programs')
                            ->label('Kabul Edilen Bölümler / Programlar')
                            ->rows(2)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('minimum_experience')
                            ->label('Asgari Deneyim')
                            ->placeholder('Örn. 3 yıl, mahallî idarede tercihen')
                            ->maxLength(100),
                        Forms\Components\Textarea::make('mandatory_conditions')
                            ->label('Zorunlu Koşullar')
                            ->helperText('Adayda mutlaka bulunması gereken koşullar.')
                            ->rows(4)
                            ->maxLength(3000)
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('preferred_conditions')
                            ->label('Tercih Sebepleri')
                            ->helperText('Zorunlu olmayan ancak tercih sebebi sayılacak nitelikler.')
                            ->rows(4)
                            ->maxLength(3000)
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Süre ve Başvuru')
                    ->schema([
                        Forms\Components\DatePicker::make('deadline_date')
                            ->label('Son Başvuru Tarihi')
                            ->native(false)
                            ->displayFormat('d.m.Y')
                            ->minDate(today())
                            ->maxDate(today()->addMonths(6))
                            ->helperText('Bu tarihten sonra talep otomatik olarak yayından kalkar.')
                            ->required(),
                        Forms\Components\TextInput::make('application_channel')
                            ->label('Başvuru Kanalı')
                            ->placeholder('E-posta adresi veya başvuru bağlantısı')
                            ->helperText('Adayların size nasıl ulaşacağını belirtin.')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('additional_document_path')
                            ->label('Talebi Açıklayan Ek Belge (isteğe bağlı)')
                            ->disk('local')
                            ->directory('hr-personnel-requests')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->helperText('PDF veya DOCX, en fazla 10 MB. Aday CV’si yüklemeyin.')
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Checkbox::make('consent_accepted')
                    ->label(new HtmlString('<a href="'.e(lroute('legal.kvkk')).'" target="_blank" class="underline">KVKK Aydınlatma Metni</a>’ni okudum; talebin yayımlanması amacıyla kurum ve yetkili bilgilerinin işlenmesine onay veriyorum.'))
                    ->accepted()
                    ->dehydrated(false),
            ]);
    }

    public function submit(): void
    {
        abort_unless(auth()->check(), 403);

        $data = $this->form->getState();

        HrPersonnelRequest::create([...$data, 'is_active' => true, 'user_id' => auth()->id()]);

        $this->submitted = true;
        $this->data = [];
        $this->mount();
    }

    public function render(): View
    {
        return view('livewire.personnel-request-form');
    }
}
