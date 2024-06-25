<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\URL;

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect()->route('posts.index');

// });


Route::redirect('/', '/posts');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/navigation', [NavigationController::class, 'show']);

Route::resource('posts', PostController::class);
Route::resource('services', ServiceController::class);
Route::post('services/{service}/apply', [ServiceController::class, 'apply'])->name('service.apply');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

URL::forceScheme('https');

require __DIR__.'/auth.php';
