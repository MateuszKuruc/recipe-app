<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $newestRecipes = Recipe::with(['tags', 'category'])
            ->latest()
            ->take(3)
            ->get();

        return inertia('Home', [
            'newestRecipes' => $newestRecipes,
        ]);
    }
}
