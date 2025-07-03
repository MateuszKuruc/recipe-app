<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('przepisy/dodaj', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('przepisy', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('przepisy/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::match(['put', 'post'], 'przepisy/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('przepisy/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::get('przepisy/ulubione', [RecipeController::class, 'showFavorites'])->name('recipes.favorites');
    Route::get('przepisy/ulubione/losowy', [RecipeController::class, 'showRandomFavorite'])->name('recipes.randomFavorite');
    Route::post('przepisy/{recipe}/ulubione', [RecipeController::class, 'favorite'])->name('recipes.favorite');
    Route::delete('przepisy/{recipe}/ulubione', [RecipeController::class, 'unfavorite'])->name('recipes.unfavorite');
});

Route::get('przepisy', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('przepisy/losowy', [RecipeController::class, 'showRandom'])->name('recipes.random');


Route::get('przepisy/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');


Route::get('kategorie', [CategoryController::class, 'index'])->name('categories.index');
Route::get('kategorie/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('kategorie/{slug}/losowy', [CategoryController::class, 'randomRedirect'])->name('categories.random');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
