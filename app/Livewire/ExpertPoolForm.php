<?php

namespace App\Livewire;

use App\Models\ExpertPool;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Component;

/**
 * Uzman ve Araştırmacı Havuzu ön yüz formu. Kayıtlar yalnızca expert_pools tablosuna yazılır;
 * İK modüllerinden bağımsızdır. Durum ve değerlendirme notları formda yer almaz.
 */
class ExpertPoolForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public bool $submitted = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Temel Profil')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required()->maxLength(150),
                        Forms\Components\TextInput::make('email')->label('E-posta')->email()->required()->maxLength(150),
                        Forms\Components\TextInput::make('phone')->label('Telefon (isteğe bağlı)')->tel()->maxLength(30),
                        Forms\Components\TextInput::make('current_institution')->label('Mevcut Kurum')->maxLength(255),
                        Forms\Components\TextInput::make('actual_duty')->label('Fiilî Görev')->maxLength(255),
                        Forms\Components\TextInput::make('unit')->label('Birim')->maxLength(255),
                        Forms\Components\Textarea::make('expertise_summary')
                            ->label('Uzmanlık Özeti')
                            ->helperText('Çalışma alanınızı ve öne çıkan deneyimlerinizi birkaç cümleyle özetleyin.')
                            ->rows(4)
                            ->minLength(30)
                            ->maxLength(2000)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 3]),

                Forms\Components\Section::make('Eğitim ve Akademik Bilgi')
                    ->description('Meslek unvanınızı ve varsa akademik unvanınızı ayrı alanlara yazın.')
                    ->schema([
                        Forms\Components\Select::make('education_level')
                            ->label('Öğrenim Düzeyi')
                            ->options(ExpertPool::EDUCATION_LEVEL_LABELS)
                            ->required(),
                        Forms\Components\TextInput::make('university')->label('Üniversite')->required()->maxLength(255),
                        Forms\Components\TextInput::make('faculty')->label('Fakülte')->maxLength(255),
                        Forms\Components\TextInput::make('department')->label('Bölüm')->required()->maxLength(255),
                        Forms\Components\TextInput::make('graduation_year')
                            ->label('Mezuniyet Yılı')
                            ->numeric()
                            ->integer()
                            ->minValue(1950)
                            ->maxValue((int) date('Y')),
                        Forms\Components\TextInput::make('profession_title')
                            ->label('Meslek Unvanı')
                            ->placeholder('Örn. Şehir Plancısı, Avukat, İktisatçı')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('academic_title')
                            ->label('Akademik Unvan (varsa)')
                            ->options(array_combine(ExpertPool::ACADEMIC_TITLES, ExpertPool::ACADEMIC_TITLES))
                            ->placeholder('Yok'),
                        Forms\Components\TextInput::make('academic_duty')
                            ->label('Akademik Görev (varsa)')
                            ->placeholder('Örn. Kamu Yönetimi Bölüm Başkanı')
                            ->maxLength(255),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Uzmanlık ve Katkı')
                    ->schema([
                        Forms\Components\Select::make('expertise_areas')
                            ->label('Uzmanlık Alanları')
                            ->multiple()
                            ->searchable()
                            ->options(ExpertPool::EXPERTISE_AREAS)
                            ->minItems(1)
                            ->maxItems(6)
                            ->helperText('En fazla 6 alan seçebilirsiniz.')
                            ->required(),
                        Forms\Components\CheckboxList::make('contribution_types')
                            ->label('Katkı Sunmak İstediğiniz Alanlar')
                            ->options(ExpertPool::CONTRIBUTION_TYPES)
                            ->columns(['md' => 2])
                            ->minItems(1)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Deneyim ve Üretimler')
                    ->schema([
                        Forms\Components\TextInput::make('total_experience')
                            ->label('Toplam Mesleki Deneyim')
                            ->placeholder('Örn. 12 yıl')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('local_gov_experience')
                            ->label('Mahallî İdare Deneyimi')
                            ->placeholder('Örn. 5 yıl veya Yok')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Repeater::make('experience_links')
                            ->label('Yayın / Proje Bağlantıları')
                            ->helperText('Yayın, proje, rapor veya profil bağlantılarınızı ayrı ayrı ekleyin.')
                            ->addActionLabel('Bağlantı ekle')
                            ->defaultItems(0)
                            ->maxItems(15)
                            ->reorderable()
                            ->itemLabel(fn (array $state) => $state['title'] ?? null)
                            ->schema([
                                Forms\Components\Select::make('type')->label('Tür')->options(ExpertPool::LINK_TYPES)->required(),
                                Forms\Components\TextInput::make('title')->label('Başlık')->required()->maxLength(255)->live(onBlur: true),
                                Forms\Components\TextInput::make('url')->label('Bağlantı')->url()->placeholder('https://')->maxLength(500),
                                Forms\Components\TextInput::make('year')->label('Yıl')->numeric()->integer()->minValue(1950)->maxValue((int) date('Y')),
                            ])
                            ->columns(['md' => 2])
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Yetkinlik ve Uygunluk')
                    ->schema([
                        Forms\Components\TagsInput::make('foreign_languages')
                            ->label('Yabancı Diller')
                            ->placeholder('Dil ve düzey yazıp Enter’a basın (ör. İngilizce – C1)'),
                        Forms\Components\Textarea::make('digital_tools')
                            ->label('Kullandığınız Dijital Araçlar')
                            ->placeholder('Örn. SPSS, R, QGIS, Excel, Python')
                            ->rows(2)
                            ->maxLength(1000),
                        Forms\Components\Select::make('contribution_period')
                            ->label('Katkı Süresi')
                            ->options(ExpertPool::CONTRIBUTION_PERIODS)
                            ->required(),
                        Forms\Components\Select::make('work_format')
                            ->label('Çalışma Biçimi')
                            ->options(ExpertPool::WORK_FORMATS)
                            ->required(),
                        Forms\Components\FileUpload::make('cv_path')
                            ->label('Özgeçmiş (isteğe bağlı)')
                            ->disk('local')
                            ->directory('expert-pool/cv')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->helperText('PDF veya DOCX, en fazla 10 MB.')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('profile_visibility')
                            ->label('Profilimin MİARGEM proje ekipleriyle paylaşılmasına izin veriyorum')
                            ->helperText('Varsayılan olarak kapalıdır.')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Checkbox::make('consent_accepted')
                    ->label(new HtmlString('<a href="'.e(lroute('legal.kvkk')).'" target="_blank" class="underline">KVKK Aydınlatma Metni</a>’ni okudum; havuz kaydımın değerlendirilmesi amacıyla bilgilerimin işlenmesine onay veriyorum.'))
                    ->accepted()
                    ->dehydrated(false),
            ]);
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // Durum ve değerlendirme notları yalnızca yöneticiler tarafından belirlenir.
        unset($data['status'], $data['evaluation_notes']);

        ExpertPool::create([
            ...$data,
            'experience_links' => array_values($data['experience_links'] ?? []),
        ]);

        $this->submitted = true;
        $this->data = [];
        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.expert-pool-form');
    }
}
