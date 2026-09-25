<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProjectCompetitionController extends Controller
{
    public function index(): View
    {
        return view('project-competition.index');
    }
}
