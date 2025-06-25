<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('tags', 'category')->latest()->paginate(5);

        return inertia::render('recipes/Index', [
            'recipes' => $recipes,
        ]);
    }

    public function create()
    {
        $tags = Tag::all(['id', 'name']);
        $categories = Category::all(['id', 'name']);
        return Inertia::render('recipes/Create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'ingredients' => 'required|string',
            'prepare_time' => 'required|integer',
            'cooking_time' => 'required|integer',
            'servings' => 'required|integer',
            'instructions' => 'required|string',
            'main_image' => 'required|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $mainImagePath = $request->file('main_image')->store('recipes', 'public');
        $secondaryImagePath = $request->file('secondary_image')
           ? $request->file('secondary_image')->store('recipes', 'public')
            : null;

        unset($validated['tags']);

        $recipe = Recipe::create([
           ...$validated,
           'main_image' => $mainImagePath,
           'secondary_image' => $secondaryImagePath,
        ]);

        $recipe->tags()->attach($request->tags);

        return redirect()->route('recipes.show', $recipe->slug)->with('success', 'Dodano nowy przepis!');

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

    public function showRandom(Recipe $recipe)
    {
        $random = Recipe::inRandomOrder()->firstOrFail();
        return redirect()->route('recipes.show', $random->slug);
    }
}
