<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('recipes', RecipeController::class)->name('recipes.index');
Route::get('recipes/create', RecipeController::class)->name('recipes.create');
Route::post('recipes', RecipeController::class)->name('recipes.store');
Route::get('recipes/{recipe}', RecipeController::class)->name('recipes.show');
Route::get('recipes/{recipe}/edit', RecipeController::class)->name('recipes.edit');
Route::patch('recipes/{recipe}', RecipeController::class)->name('recipes.update');
Route::delete('recipes/{recipe}', RecipeController::class)->name('recipes.destroy');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
