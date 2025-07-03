<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $favoriteRecipes = null;

        if ($user && $user->favoriteRecipes()->count() >= 3) {
            $favoriteRecipes = $user->favoriteRecipes()->with(['tags', 'category'])->inRandomOrder()->take(3)->get();
        }

        $randomRecipes = Recipe::with(['tags', 'category'])->inRandomOrder()->take(3)->get();

        $newestRecipes = Recipe::with(['tags', 'category'])
            ->latest()
            ->take(3)
            ->get();

        $breakfastRecipes = Recipe::with(['tags', 'category'])
            ->whereHas('category', fn($q) => $q->where('slug', 'sniadania'))
            ->inRandomOrder()
            ->take(3)
            ->get();

        $dinnerRecipes = Recipe::with(['tags', 'category'])
            ->whereHas('category', fn($q) => $q->where('slug', 'dania-glowne'))
            ->inRandomOrder()
            ->take(3)
            ->get();

        $dessertRecipes = Recipe::with(['tags', 'category'])
            ->whereHas('category', fn($q) => $q->where('slug', 'desery'))
            ->inRandomOrder()
            ->take(3)
            ->get();


        return inertia('Home', [
            'newestRecipes' => $newestRecipes,
            'randomRecipes' => $randomRecipes,
            'favoriteRecipes' => $favoriteRecipes,
            'breakfastRecipes' => $breakfastRecipes,
            'dinnerRecipes' => $dinnerRecipes,
            'dessertRecipes' => $dessertRecipes,
        ]);
    }
}
