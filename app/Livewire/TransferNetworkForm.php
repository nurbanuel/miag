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
 * Nakil Ağı ön yüz formu. Kayıtlar yalnızca hr_applications tablosuna (type: nakil) yazılır;
 * Uzman Havuzu'na herhangi bir aktarım yapılmaz.
 */
class TransferNetworkForm extends Component implements HasForms
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
        $isCivilServant = fn (Get $get) => in_array($get('work_status'), HrApplication::CIVIL_SERVANT_STATUSES, true);

        return $form
            ->model(HrApplication::class)
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Temel Bilgiler')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')->label('Ad Soyad')->required()->maxLength(150),
                        Forms\Components\TextInput::make('email')->label('E-posta')->email()->required()->maxLength(150),
                        Forms\Components\TextInput::make('phone')->label('Telefon')->tel()->required()->maxLength(30),
                    ])
                    ->columns(['md' => 3]),

                Forms\Components\Section::make('Mevcut Görev')
                    ->schema([
                        Forms\Components\TextInput::make('current_institution')->label('Mevcut Kurum')->required()->maxLength(255),
                        Forms\Components\Select::make('institution_type')
                            ->label('Kurum Türü')
                            ->options(HrApplication::INSTITUTION_TYPE_LABELS)
                            ->required(),
                        Forms\Components\Select::make('work_status')
                            ->label('Çalışma Statüsü')
                            ->options(HrApplication::TRANSFER_WORK_STATUS_LABELS)
                            ->required()
                            ->live(),
                        Forms\Components\Select::make('service_class')
                            ->label('Hizmet Sınıfı')
                            ->options(HrApplication::SERVICE_CLASSES)
                            ->required()
                            ->visible($isCivilServant),
                        Forms\Components\Select::make('degree')
                            ->label('Derece')
                            ->options(array_combine(range(1, 15), range(1, 15)))
                            ->required()
                            ->visible($isCivilServant),
                        Forms\Components\TextInput::make('staff_title')->label('Kadro Unvanı')->maxLength(255),
                        Forms\Components\TextInput::make('actual_duty')->label('Fiilî Görev')->maxLength(255),
                        Forms\Components\TextInput::make('unit')->label('Birim')->maxLength(255),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Eğitim ve Deneyim')
                    ->schema([
                        Forms\Components\Repeater::make('educations')
                            ->label('Öğrenim Bilgileri')
                            ->relationship()
                            ->addActionLabel('Öğrenim ekle')
                            ->minItems(1)
                            ->defaultItems(1)
                            ->schema([
                                Forms\Components\Select::make('education_level')
                                    ->label('Öğrenim Düzeyi')
                                    ->options(HrEducation::LEVEL_LABELS)
                                    ->required(),
                                Forms\Components\Select::make('student_status')
                                    ->label('Öğrenci / Mezun Durumu')
                                    ->options(HrEducation::STUDENT_STATUS_LABELS)
                                    ->default('mezun')
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('university')->label('Üniversite / Okul')->required()->maxLength(255),
                                Forms\Components\TextInput::make('department')->label('Bölüm')->maxLength(255),
                                Forms\Components\TextInput::make('graduation_year')
                                    ->label('Mezuniyet Yılı')
                                    ->numeric()
                                    ->minValue(1950)
                                    ->maxValue((int) date('Y'))
                                    ->visible(fn (Get $get) => $get('student_status') === 'mezun'),
                                Forms\Components\TextInput::make('current_class')
                                    ->label('Sınıf')
                                    ->maxLength(20)
                                    ->visible(fn (Get $get) => $get('student_status') === 'ogrenci'),
                            ])
                            ->columns(['md' => 2])
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('professional_title')->label('Meslek Unvanı')->required()->maxLength(255),
                        Forms\Components\TextInput::make('total_service_time')
                            ->label('Toplam Hizmet Süresi')
                            ->placeholder('Örn. 8 yıl 4 ay')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('current_institution_time')
                            ->label('Mevcut Kurumdaki Hizmet Süresi')
                            ->placeholder('Örn. 3 yıl')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('local_gov_experience')
                            ->label('Mahallî İdare Deneyimi')
                            ->placeholder('Örn. 6 yıl')
                            ->maxLength(50),
                        Forms\Components\Textarea::make('expertise_areas')
                            ->label('Uzmanlık Alanları')
                            ->rows(3)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ])
                    ->columns(['md' => 2]),

                Forms\Components\Section::make('Görev Yeri Tercihleri')
                    ->description('Tercihlerinizi öncelik sırasıyla ekleyin; sırayı sürükleyip bırakarak değiştirebilirsiniz.')
                    ->schema([
                        Forms\Components\Repeater::make('transferPreferences')
                            ->hiddenLabel()
                            ->relationship()
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->minItems(1)
                            ->maxItems(10)
                            ->defaultItems(1)
                            ->addActionLabel('Tercih ekle')
                            ->itemLabel(fn (array $state) => collect([$state['province'] ?? null, $state['district'] ?? null, $state['institution'] ?? null])->filter()->implode(' / ') ?: 'Yeni tercih')
                            ->schema([
                                Forms\Components\TextInput::make('province')->label('İl')->required()->maxLength(100)->live(onBlur: true),
                                Forms\Components\TextInput::make('district')->label('İlçe')->maxLength(100)->live(onBlur: true),
                                Forms\Components\TextInput::make('institution')->label('Kurum')->maxLength(255)->live(onBlur: true),
                                Forms\Components\TextInput::make('position')->label('Düşünülen Görev')->maxLength(255),
                                Forms\Components\DatePicker::make('available_from')
                                    ->label('Uygun Tarih (başlangıç)')
                                    ->native(false)
                                    ->displayFormat('d.m.Y')
                                    ->live(),
                                Forms\Components\DatePicker::make('available_until')
                                    ->label('Uygun Tarih (bitiş)')
                                    ->native(false)
                                    ->displayFormat('d.m.Y')
                                    ->minDate(fn (Get $get) => $get('available_from'))
                                    ->afterOrEqual('available_from'),
                            ])
                            ->columns(['md' => 2]),
                        Forms\Components\Textarea::make('transfer_reason')
                            ->label('Gerekçe (isteğe bağlı)')
                            ->rows(3)
                            ->maxLength(2000)
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Görünürlük')
                    ->description('Her seçenek birbirinden bağımsızdır. Paylaşım seçenekleri varsayılan olarak kapalıdır.')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Profil')
                            ->helperText('Kapalıysa profiliniz değerlendirme listelerinde yer almaz.')
                            ->default(true),
                        Forms\Components\Toggle::make('share_current_institution')
                            ->label('Mevcut Kurumu Paylaş')
                            ->default(false),
                        Forms\Components\Toggle::make('share_contact_info')
                            ->label('İletişim Bilgilerini Paylaş')
                            ->default(false),
                    ])
                    ->columns(['md' => 3]),

                Forms\Components\Checkbox::make('consent_accepted')
                    ->label(new HtmlString('<a href="'.e(lroute('legal.kvkk')).'" target="_blank" class="underline">KVKK Aydınlatma Metni</a>’ni okudum; profilimin değerlendirilmesi amacıyla bilgilerimin işlenmesine onay veriyorum.'))
                    ->accepted(),
            ]);
    }

    public function submit(): void
    {
        abort_unless(auth()->check(), 403);

        $data = $this->form->getState();

        // Memur dışı statülerde gizli kalan hizmet sınıfı / derece kaydedilmez.
        if (! in_array($data['work_status'] ?? null, HrApplication::CIVIL_SERVANT_STATUSES, true)) {
            $data['service_class'] = null;
            $data['degree'] = null;
        }

        $application = HrApplication::create([
            ...$data,
            'type' => 'nakil',
            'user_id' => auth()->id(),
            'status' => 'Alındı',
            'consent_accepted' => true,
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
        return view('livewire.transfer-network-form');
    }
}
