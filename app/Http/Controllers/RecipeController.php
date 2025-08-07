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
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
                    ->orWhere('instructions', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $recipes = $query
            ->with(['tags', 'category'])
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('recipes/Index', [
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
            'comments' => 'nullable|string',
            'main_image' => 'required|image',
            'secondary_image' => 'nullable|image',
            'tags.*' => 'integer|exists:tags,id'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('main_image'));

        $optimizedImage = $image
            ->scaleDown(width: 800)
            ->toWebp(quality: 85);

        $mainImagePath = 'recipes/'.uniqid().'.webp';
        Storage::disk('public')->put($mainImagePath, $optimizedImage);

        $secondaryImagePath = null;
        if ($request->hasFile('secondary_image')) {
            $secondaryImage = $manager->read($request->file('secondary_image'));
            $optimizedSecondaryImage = $secondaryImage
                ->scaleDown(width: 800)
                ->toWebp(quality: 85);

            $secondaryImagePath = 'recipes/'.uniqid().'.webp';
            Storage::disk('public')->put($secondaryImagePath, $optimizedSecondaryImage);
        }

        unset($validated['tags']);

        $recipe = Recipe::create([
            ...$validated,
            'user_id' => auth()->id(),
            'main_image' => $mainImagePath,
            'secondary_image' => $secondaryImagePath,
        ]);

        $recipe->tags()->attach($request->tags);

        return redirect()->route('recipes.show', $recipe->slug);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['tags', 'category', 'favoritedBy']);
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
            'comments' => 'nullable|string',
            'main_image' => 'nullable|image',
            'secondary_image' => 'nullable|image',
            'tags.*' => 'integer|exists:tags,id'
        ]);


        if ($recipe->title != $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('main_image')) {

            if ($recipe->main_image) {
                Storage::disk('public')->delete($recipe->main_image);
            }

            $image = $manager->read($request->file('main_image'));
            $optimizedImage = $image
                ->scaleDown(width: 800)
                ->toWebp(quality: 85);

            $mainImagePath = 'recipes/'.uniqid().'.webp';
            Storage::disk('public')->put($mainImagePath, $optimizedImage);
            $validated['main_image'] = $mainImagePath;

        } else {
            unset($validated['main_image']);
        }

        if ($request->hasFile('secondary_image')) {
            if ($recipe->secondary_image) {
                Storage::disk('public')->delete($recipe->secondary_image);
            }

            $secondaryImage = $manager->read($request->file('secondary_image'));
            $optimizedSecondaryImage = $secondaryImage
                ->scaleDown(width: 800)
                ->toWebp(quality: 85);

            $secondaryImagePath = 'recipes/'.uniqid().'.webp';
            Storage::disk('public')->put($secondaryImagePath, $optimizedSecondaryImage);
            $validated['secondary_image'] = $secondaryImagePath;

        } else {
            unset($validated['secondary_image']);
        }

        unset($validated['tags']);

        $recipe->update($validated);

        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe->slug);
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

        return redirect()->route('recipes.index');
    }

    public function showRandom(Recipe $recipe)
    {
        $random = Recipe::inRandomOrder()->firstOrFail();
        return redirect()->route('recipes.show', $random->slug);
    }

    public function favorite(Recipe $recipe)
    {
        $user = auth()->user();

        if (!$user->favoriteRecipes()->where('recipe_id', $recipe->id)->exists()) {
            $user->favoriteRecipes()->attach($recipe->id);
        }
    }

    public function unfavorite(Recipe $recipe)
    {
        $user = auth()->user();

        $user->favoriteRecipes()->detach($recipe->id);
    }

    public function showFavorites()
    {
        $user = auth()->user();

        $favoriteRecipes = $user->favoriteRecipes()
            ->with(['tags', 'category'])
            ->paginate(6);

        return inertia::render('recipes/ShowFavorites', [
            'favoriteRecipes' => $favoriteRecipes
        ]);
    }

    public function showRandomFavorite()
    {
        $user = auth()->user();

        $random = $user->favoriteRecipes()->inRandomOrder()->firstOrFail();

        return redirect()->route('recipes.show', $random->slug);
    }
}
