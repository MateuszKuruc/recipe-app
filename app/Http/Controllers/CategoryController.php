<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::withCount('recipes')->get();

        $totalRecipes = Recipe::count();

        $randomRecipes = Recipe::with(['category'])->inRandomOrder()->take(3)->get();

        return inertia::render('categories/Index', [
            'categories' => $categories,
            'totalRecipes' => $totalRecipes,
            'randomRecipes' => $randomRecipes,
        ]);
    }

    public function show(Category $category)
    {
        $recipes = $category->recipes()
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(6);

        return Inertia::render('categories/Show', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }

    public function randomRedirect(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $recipe = $category->recipes()->inRandomOrder()->first();

        return redirect()->route('recipes.show', $recipe->slug);
    }


}
