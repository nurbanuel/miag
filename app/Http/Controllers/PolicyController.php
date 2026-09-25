<?php

namespace App\Http\Controllers;

use App\Models\PolicyContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function index(Request $request): View
    {
        $items = PolicyContent::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('policy.index', compact('items'));
    }

    public function show(PolicyContent $policyContent): View
    {
        return view('policy.show', ['item' => $policyContent]);
    }
}
