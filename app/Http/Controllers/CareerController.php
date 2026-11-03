<?php

namespace App\Http\Controllers;

use App\Models\ExpertPoolProfile;
use App\Models\JobInternshipApplication;
use App\Models\MunicipalStaffRequest;
use App\Models\TransferNetworkProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CareerController extends Controller
{
    private const PUBLIC_EMAIL_DOMAINS = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com', 'icloud.com'];

    public function index(): View
    {
        return view('career.index');
    }

    // Modül 1: Belediye Personel Talebi
    public function personnelRequestForm(): View
    {
        $this->useSiteColorsForFilamentForms();

        return view('career.personnel-request');
    }

    public function municipalStaffRequestForm(): View
    {
        return view('career.municipal-staff-request', [
            'employmentStatuses' => MunicipalStaffRequest::EMPLOYMENT_STATUS_LABELS,
        ]);
    }

    public function storeMunicipalStaffRequest(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'municipality_name' => 'required|string|max:150',
            'contact_name' => 'required|string|max:150',
            'contact_email' => [
                'required',
                'email',
                'max:150',
                // Kurumsal e-posta doğrulaması: yaygın kişisel e-posta sağlayıcıları reddedilir.
                // Not: Gerçek doğrulama için e-posta onay bağlantısı akışı eklenmelidir.
                function ($attribute, $value, $fail) {
                    $domain = strtolower(substr(strrchr($value, '@'), 1));
                    if (in_array($domain, self::PUBLIC_EMAIL_DOMAINS, true)) {
                        $fail('Lütfen kurumsal (belediye) e-posta adresinizi kullanınız.');
                    }
                },
            ],
            'position_title' => 'required|string|max:150',
            'employment_status' => ['required', Rule::in(array_keys(MunicipalStaffRequest::EMPLOYMENT_STATUS_LABELS))],
            'min_experience' => 'required|integer|min:0|max:50',
            'work_location' => 'required|string|max:150',
            'description' => 'required|string|min:10|max:3000',
            'attachment' => 'nullable|file|mimes:pdf,docx|max:10240',
            'consent_accepted' => 'accepted',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('municipal-staff-requests', 'local');
        }
        $data['consent_accepted'] = true;
        unset($data['attachment']);

        MunicipalStaffRequest::create($data);

        return back()->with('status', 'Personel talebiniz alınmıştır. Doğrulama sonrası yayına alınacaktır.');
    }

    // Modül 2: Nakil Ağı
    public function transferNetworkForm(): View
    {
        $this->useSiteColorsForFilamentForms();

        return view('career.transfer-network');
    }

    public function storeTransferNetwork(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_title' => 'required|string|max:150',
            'current_institution' => 'required|string|max:150',
            'target_locations' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'summary' => 'required|string|min:10|max:2000',
            'contact_email' => 'required|email|max:150',
            'consent_accepted' => 'accepted',
        ]);

        $data['consent_accepted'] = true;
        $data['is_identity_revealed'] = false;

        TransferNetworkProfile::create($data);

        return back()->with('status', 'Profiliniz gizlilik esasıyla oluşturuldu. Kimlik bilgileriniz yalnızca sizin onayınızla açılır.');
    }

    // Modül 3: İş / Staj Başvurusu
    public function jobInternshipForm(): View
    {
        $this->useSiteColorsForFilamentForms();

        return view('career.job-internship');
    }

    public function storeJobInternship(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'applicant_type' => ['required', Rule::in(array_keys(JobInternshipApplication::APPLICANT_TYPE_LABELS))],
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'field_of_interest' => 'required|string|max:150',
            'cv' => 'nullable|file|mimes:pdf,docx|max:10240',
            'message' => 'nullable|string|max:2000',
            'consent_accepted' => 'accepted',
        ]);

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('job-internship-applications', 'local');
        }
        $data['consent_accepted'] = true;
        unset($data['cv']);

        JobInternshipApplication::create($data);

        return back()->with('status', 'Başvurunuz alınmıştır. Teşekkür ederiz.');
    }

    // Modül 4: MİARGEM CV Havuzu
    public function cvPoolForm(): View
    {
        return view('career.cv-pool', [
            'visibilityOptions' => ExpertPoolProfile::VISIBILITY_LABELS,
        ]);
    }

    public function storeCvPool(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'expertise_areas' => 'required|string|max:255',
            'visibility' => ['required', Rule::in(array_keys(ExpertPoolProfile::VISIBILITY_LABELS))],
            'summary' => 'required|string|min:10|max:2000',
            'cv' => 'nullable|file|mimes:pdf,docx|max:10240',
            'consent_accepted' => 'accepted',
        ]);

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('cv-pool', 'local');
        }
        $data['consent_accepted'] = true;
        unset($data['cv']);

        ExpertPoolProfile::create($data);

        return back()->with('status', 'CV\'niz havuzumuza eklenmiştir.');
    }
}
