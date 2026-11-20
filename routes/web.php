<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Auth\MemberAuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CitizenGuideController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\LegislationTrackingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProjectCompetitionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site rotaları
|--------------------------------------------------------------------------
| Aynı rota kümesi, "tr" (varsayılan, önek yok) ve "en" öneki için iki kez
| kaydedilir. Böylece / -> Türkçe, /en -> İngilizce ana sayfayı gösterir ve
| her sayfa için gerçek, ayrı bir URL kırılımı oluşur (SEO + dil hazırlığı).
*/
$registerSiteRoutes = function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/kurumsal', [CorporateController::class, 'index'])->name('corporate');
    Route::get('/baskan', fn () => view('pages.president', [
        'resume' => \App\Models\Resume::first(),
    ]))->name('president');

    Route::get('/rapor-ve-analizler', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/rapor-ve-analizler/{report:slug}', [ReportController::class, 'show'])->name('reports.show');

    Route::get('/politika-ve-mevzuat', [PolicyController::class, 'index'])->name('policy.index');
    Route::get('/politika-ve-mevzuat/{policyContent:slug}', [PolicyController::class, 'show'])->name('policy.show');

    Route::get('/haberler', [NewsController::class, 'index'])->name('news.index');
    Route::get('/haberler/{news:slug}', [NewsController::class, 'show'])->name('news.show');

    Route::get('/duyurular/{announcement:slug}', [AnnouncementController::class, 'show'])->name('announcements.show');

    Route::get('/sayfa/{slug}', [PageController::class, 'show'])->name('page.show');

    Route::get('/yazilar', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/yazilar/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/vatandas-rehberi/{kategori?}', [CitizenGuideController::class, 'index'])
        ->whereIn('kategori', array_keys(\App\Models\Article::CITIZEN_GUIDE_CATEGORIES))
        ->name('citizen-guide.index');
    Route::get('/yazarlar/{author:slug}', [AuthorController::class, 'show'])->name('authors.show');

    Route::get('/etkinlikler', [EventController::class, 'index'])->name('events.index');
    Route::get('/etkinlikler/{event:slug}', [EventController::class, 'show'])->name('events.show');
    Route::get('/etkinlikler/{event:slug}/kayit', [EventRegistrationController::class, 'create'])->name('events.register');
    Route::post('/etkinlikler/{event:slug}/kayit', [EventRegistrationController::class, 'store'])->middleware('throttle:10,1')->name('events.register.store');

    // Katılım: MİARGEM Uzman ve Araştırmacı Havuzu (Livewire formu)
    Route::get('/katilim', [ParticipationController::class, 'index'])->name('participation.index');

    // Üyelik (ön yüz)
    Route::middleware('guest')->group(function () {
        Route::get('/uye-girisi', [MemberAuthController::class, 'showLogin'])->name('member.login');
        Route::post('/uye-girisi', [MemberAuthController::class, 'login'])->middleware('throttle:10,1')->name('member.login.store');
        Route::get('/uye-ol', [MemberAuthController::class, 'showRegister'])->name('member.register');
        Route::post('/uye-ol', [MemberAuthController::class, 'register'])->middleware('throttle:5,1')->name('member.register.store');
    });
    Route::post('/cikis', [MemberAuthController::class, 'logout'])->middleware('auth')->name('member.logout');

    // İK ve Kariyer: genel bakış ve tüm alt başlıklar (GET + POST) yalnızca üyelere açıktır.
    Route::middleware('auth')->group(function () {
        Route::prefix('ik-ve-kariyer')->name('career.')->group(function () {
            Route::get('/', [CareerController::class, 'index'])->name('index');

            Route::get('/personel-talebi', [CareerController::class, 'personnelRequestForm'])->name('personnel-request');
            // Eski adres yeni personel talebi formuna yönlendirilir.
            Route::get('/belediye-personel-talebi', fn () => redirect(lroute('career.personnel-request'), 301))->name('municipal-staff-request');
            Route::post('/belediye-personel-talebi', [CareerController::class, 'storeMunicipalStaffRequest'])->name('municipal-staff-request.store');

            Route::get('/nakil-agi', [CareerController::class, 'transferNetworkForm'])->name('transfer-network');
            Route::post('/nakil-agi', [CareerController::class, 'storeTransferNetwork'])->name('transfer-network.store');

            Route::get('/is-staj-basvurusu', [CareerController::class, 'jobInternshipForm'])->name('job-internship');
            Route::post('/is-staj-basvurusu', [CareerController::class, 'storeJobInternship'])->name('job-internship.store');

            Route::get('/miargem-cv-havuzu', [CareerController::class, 'cvPoolForm'])->name('cv-pool');
            Route::post('/miargem-cv-havuzu', [CareerController::class, 'storeCvPool'])->name('cv-pool.store');
        });
    });

    Route::get('/proje-yarismasi', [ProjectCompetitionController::class, 'index'])->name('project-competition');
    Route::get('/mevzuat-takip-sistemi', [LegislationTrackingController::class, 'index'])->name('legislation-tracking');

    Route::get('/arama', [SearchController::class, 'index'])->name('search');
    Route::post('/bulten', [NewsletterController::class, 'store'])->name('newsletter.store');

    // Yasal metinler (panel > Yasal Metinler). Eski /kvkk adresi yeni metne yönlendirilir.
    Route::get('/gizlilik-politikasi', [LegalDocumentController::class, 'show'])->defaults('slug', 'gizlilik-politikasi')->name('legal.privacy');
    Route::get('/kvkk-aydinlatma-metni', [LegalDocumentController::class, 'show'])->defaults('slug', 'kvkk-aydinlatma-metni')->name('legal.kvkk');
    Route::get('/kvkk', fn () => redirect(lroute('legal.kvkk'), 301))->name('legal.kvkk.legacy');
    Route::get('/cerez-politikasi', [LegalController::class, 'cookies'])->name('legal.cookies');
    Route::get('/erisilebilirlik', [LegalController::class, 'accessibility'])->name('legal.accessibility');

    // Panelden eklenen diğer yasal metinler (ör. /mesafeli-satis-sozlesmesi). Grubun en sonunda
    // tanımlıdır; yalnızca başka hiçbir rotanın yakalamadığı tek seviyeli adresleri yakalar.
    Route::get('/{slug}', [LegalDocumentController::class, 'show'])
        ->where('slug', '(?!admin$|livewire|filament|storage|up$|en$)[a-z0-9]+(?:-[a-z0-9]+)*')
        ->name('legal.show');
};

Route::middleware(['setlocale:tr'])->name('tr.')->group($registerSiteRoutes);
Route::prefix('en')->middleware(['setlocale:en'])->name('en.')->group($registerSiteRoutes);

// Başvuru dosyaları (İK, personel talebi, uzman havuzu) özel diskte tutulur;
// yalnızca panele giriş yapmış yöneticiler indirebilir.
Route::middleware(['panel:admin', \Filament\Http\Middleware\Authenticate::class])
    ->get('/admin/private-file', function (\Illuminate\Http\Request $request) {
        $path = (string) $request->query('path');
        $allowed = ['hr-applications/', 'hr-personnel-requests/', 'expert-pool/'];
        abort_unless(\Illuminate\Support\Str::startsWith($path, $allowed) && ! str_contains($path, '..'), 404);
        abort_unless(\Illuminate\Support\Facades\Storage::disk('local')->exists($path), 404);

        return \Illuminate\Support\Facades\Storage::disk('local')->download($path);
    })
    ->name('admin.private-file');
