<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PagesController
{
    public function index(Request $request): View
    {
        $currentPage = $request->get('page', 'home');

        return view('backend.pages.index', [
            'currentPage' => $currentPage,
            'pages' => [
                ['id' => 'home', 'label' => 'Accueil', 'active' => $currentPage === 'home'],
                ['id' => 'about', 'label' => 'À propos', 'active' => $currentPage === 'about'],
            ],
            'recipes' => Recipe::whereNotNull('published_at')->get(['id', 'title']),
        ]);
    }
}
