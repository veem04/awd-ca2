<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\GameController;
// use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GameListController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\User\GameController as UserGameController;

use App\Http\Controllers\Admin\PublisherController as AdminPublisherController;
use App\Http\Controllers\User\PublisherController as UserPublisherController;

use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\User\GenreController as UserGenreController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('game_list', GameListController::class);
    Route::resource('/user/games', UserGameController::class)->names('user.games')->only(['index', 'show']);
    Route::resource('/user/publishers', UserPublisherController::class)->names('user.publishers')->only(['index', 'show']);
    Route::resource('/user/genres', UserGenreController::class)->names('user.genres')->only(['index', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth', 'role:admin'])->group(function (){
    Route::resource('/admin/games', AdminGameController::class)->names('admin.games');
    Route::resource('/admin/publishers', AdminPublisherController::class)->names('admin.publishers');
    Route::resource('/admin/genres', AdminGenreController::class)->names('admin.genres');
});











require __DIR__.'/auth.php';
