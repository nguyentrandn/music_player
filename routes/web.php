<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\ViewSongsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// create a new category
// Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'store'])->name('categories.store');
Route::resource('categories', CategoriesController::class);

// get Songs
Route::resource('/songs', SongsController::class);

Route::post('/delete', [SongsController::class, 'delete'])->name('song.delete');
Route::post('/show-song', [SongsController::class, 'show_song'])->name('song.show_song');
Route::post('/edit-song', [SongsController::class, 'edit_song'])->name('song.edit_song');

Route::controller(SongsController::class)->group(function () {
    Route::get('/show', 'getSong')->name('getSong');
});

// User
Route::get('/user', [ViewSongsController::class, 'index']);