<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('tags', 'category')->paginate(5);

        return inertia::render('recipes/Index', [
            'recipes' => $recipes,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('recipes/Create', [
            'categories' => $categories,
        ]);
    }

    public function store()
    {
        return inertia::render('recipes/Index');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['tags', 'category']);
        $categories = Category::withCount('recipes')->get();
        $relatedRecipes = Recipe::where('category_id', $recipe->category_id)
            ->where('id', '!=', $recipe->id)
            ->take(3)
            ->get();

        return inertia::render('recipes/Show', [
            'recipe' => $recipe,
            'categories' => $categories,
            'relatedRecipes' => $relatedRecipes
        ]);
    }

    public function edit(Recipe $recipe)
    {

    }

    public function update(Request $request, Recipe $recipe)
    {

    }

    public function destroy(Recipe $recipe)
    {

    }
}
