<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = Report::query()->with('category')
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where('title', 'like', $term)->orWhere('summary', 'like', $term)->orWhere('content', 'like', $term);
            }))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->integer('category')))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = \App\Models\Category::whereIn('id', Report::select('category_id'))->orderBy('name')->pluck('name', 'id');

        return view('reports.index', compact('reports', 'categories'));
    }

    public function show(Report $report): View
    {
        return view('reports.show', compact('report'));
    }
}
