<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\URL;

// Redirect root to /posts
Route::redirect('/', '/posts');

// Posts routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::resource('posts', PostController::class);
Route::resource('services', ServiceController::class);
Route::resource('events', EventController::class);
Route::resource('pets', PetController::class);
Route::delete('/posts/{post}/attachments/{attachment}', [PostController::class, 'deleteAttachment'])->name('posts.attachments.destroy');
Route::delete('/events/{event}/attachments/{attachment}', [EventController::class, 'deleteAttachment'])->name('events.attachments.destroy');
Route::delete('/pets/{pet}/attachments/{attachment}', [PetController::class, 'deleteAttachment'])->name('pets.attachments.destroy');

Route::post('services/{service}/apply', [ServiceController::class, 'apply'])->name('service.apply');
Route::post('events/{event}/apply', [EventController::class, 'apply'])->name('events.apply');


// Navigation route
Route::get('/navigation', [NavigationController::class, 'show']);

// Authentication routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');

// Dashboard route with authentication middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

// Force HTTPS
URL::forceScheme('https');

// Include auth.php routes
require __DIR__.'/auth.php';
