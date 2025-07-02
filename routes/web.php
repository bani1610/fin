<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoodLogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\CommentController;
use App\Http\Controllers\Forum\CategoryController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Forum\LikeController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute publik akan langsung diarahkan ke dashboard jika sudah login
Route::get('/', function () {
    // Cek role user saat mengakses root
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect('/admin');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Grup rute untuk USER saja
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mood Tracking
    Route::post('/moods', [MoodLogController::class, 'store'])->name('moods.store');

    // Manajemen Tugas
    Route::resource('tasks', TaskController::class);

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Statistik
    Route::get('/statistics', StatisticController::class)->name('statistics');

    // Forum
    Route::get('/forum', [PostController::class, 'index'])->name('forum.index');
    Route::get('/forum/posts/create', [PostController::class, 'create'])->name('forum.posts.create');
    Route::post('/forum/posts', [PostController::class, 'store'])->name('forum.posts.store');
    Route::get('/forum/posts/{post}', [PostController::class, 'show'])->name('forum.posts.show');
    Route::delete('/forum/posts/{post}', [PostController::class, 'destroy'])->name('forum.posts.destroy');
    Route::get('/forum/my-posts', [PostController::class, 'myPosts'])->name('forum.myposts');
    Route::get('/forum/category/{category}', [CategoryController::class, 'show'])->name('forum.category.show');

    // Interaksi Forum (Like & Komentar)
    Route::post('/forum/posts/{post}/comments', [CommentController::class, 'store'])->name('forum.comments.store');
    Route::post('/forum/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('forum.posts.like');
    
    // Notifikasi
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAsRead');
});

require __DIR__.'/auth.php';