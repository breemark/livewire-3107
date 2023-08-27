<?php

use App\Http\Livewire\ArticleForm;
use App\Http\Livewire\ArticlesTable;
use App\Http\Livewire\ArticleShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/blog/{article}', ArticleShow::class)
        ->name('articles.show');

Route::middleware(['auth:sanctum', 'verified'])
    ->prefix('dashboard')->group(function() {

    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/blog', ArticlesTable::class)
    ->name('articles.index');

    Route::get('/blog/create', ArticleForm::class)
        ->name('articles.create');

    Route::get('/blog/{article:id}/edit', ArticleForm::class)
        ->name('articles.edit');
    
});


