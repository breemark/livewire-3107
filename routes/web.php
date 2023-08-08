<?php

use App\Http\Livewire\ArticleForm;
use App\Http\Livewire\Articles;
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

Route::get('/', Articles::class)
    ->name('home');
Route::get('/blog/create', ArticleForm::class)
    ->name('articles.create')
    ->middleware('auth');

Route::get('/blog/{article}', ArticleShow::class)
    ->name('articles.show');
Route::get('/blog/{article}/edit', ArticleForm::class)
    ->name('articles.edit')
    ->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
