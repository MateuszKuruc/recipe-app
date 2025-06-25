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
    //Route::get('recipes/{recipe}/edit', RecipeController::class)->name('recipes.edit');
//Route::patch('recipes/{recipe}', RecipeController::class)->name('recipes.update');
//Route::delete('recipes/{recipe}', RecipeController::class)->name('recipes.destroy');
});

Route::get('przepisy', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('przepisy/losowy', [RecipeController::class, 'showRandom'])->name('recipes.random');


Route::get('przepisy/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');


Route::get('kategorie', [CategoryController::class, 'index'])->name('categories.index');
Route::get('kategorie/{category}', [CategoryController::class, 'show'])->name('categories.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
