<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function show(Author $author): View
    {
        $author->load(['articles' => fn ($q) => $q->latest('published_at')]);

        return view('authors.show', compact('author'));
    }
}
