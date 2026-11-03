<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ParticipationController extends Controller
{
    /** Katılım sayfası: MİARGEM Uzman ve Araştırmacı Havuzu başvuru formu. */
    public function index(): View
    {
        $this->useSiteColorsForFilamentForms();

        return view('participation.index');
    }
}
