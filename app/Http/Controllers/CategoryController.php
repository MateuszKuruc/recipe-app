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

        return inertia::render('categories/Index', [
            'categories' => $categories,
            'totalRecipes' => $totalRecipes,
        ]);
    }
}
