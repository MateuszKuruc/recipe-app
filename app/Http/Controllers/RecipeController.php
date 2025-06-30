<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::query();

        if ($request->filled('searchField')) {
            $search = $request->input('searchField');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('ingredients', 'like', "%{$search}%")
                    ->orWhere('instructions', 'like', "%{$search}%");
            });
        }

        $recipes = $query
            ->with(['tags', 'category'])
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return inertia('recipes/Index', [
            'recipes' => $recipes,
            'searchField' => $request->input('searchField', ''),
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
           'user_id' => auth()->id(),
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
        $recipe->load('tags', 'category');
        return inertia::render('recipes/Edit', [
            'recipe' => $recipe,
            'tags' => Tag::all(),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Recipe $recipe)
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
            'main_image' => 'nullable|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'tags.*' => 'integer|exists:tags,id'
        ]);


        if ($recipe->title != $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('recipes', 'public');
        } else {
            unset($validated['main_image']);
        }

        if ($request->hasFile('secondary_image')) {
            $validated['secondary_image'] = $request->file('secondary_image')->store('recipes', 'public');
        } else {
            unset($validated['secondary_image']);
        }

        unset($validated['tags']);

        $recipe->update($validated);

        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe->slug)->with('success', 'Przepis został zaktualizowany!');
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->main_image) {
            Storage::disk('public')->delete($recipe->main_image);
        }

        if ($recipe->secondary_image) {
            Storage::disk('public')->delete($recipe->secondary_image);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Przepis został usunięty');
    }

    public function showRandom(Recipe $recipe)
    {
        $random = Recipe::inRandomOrder()->firstOrFail();
        return redirect()->route('recipes.show', $random->slug);
    }
}
