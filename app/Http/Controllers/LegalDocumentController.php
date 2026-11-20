<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\View\View;

/** Panelden yönetilen yasal metinler (Gizlilik Politikası, KVKK Aydınlatma Metni vb.). */
class LegalDocumentController extends Controller
{
    public function show(string $slug): View
    {
        $document = LegalDocument::active()->where('slug', $slug)->firstOrFail();

        return view('pages.legal-document', compact('document'));
    }
}
