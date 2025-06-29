<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoodLogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\CommentController;
use App\Http\Controllers\Forum\CategoryController;
use App\Http\Controllers\StatisticController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ForumController as AdminForumController;



// Rute publik (halaman utama, dll)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/coba', function () {
    return view('coba');
});
// Rute yang hanya bisa diakses setelah login
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Mood Tracking
    Route::post('/moods', [MoodLogController::class, 'store'])->name('moods.store');

    // Manajemen Tugas (menggunakan resource controller)
    Route::resource('tasks', TaskController::class);


    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/statistics', StatisticController::class)->name('statistics');

    Route::get('/forum', [PostController::class, 'index'])->name('forum.index');
    Route::get('/forum/posts/create', [PostController::class, 'create'])->name('forum.posts.create');
    Route::post('/forum/posts', [PostController::class, 'store'])->name('forum.posts.store');
    Route::get('/forum/posts/{post}', [PostController::class, 'show'])->name('forum.posts.show');
    Route::post('/forum/posts/{post}/comments', [CommentController::class, 'store'])->name('forum.comments.store');
    Route::get('/forum/category/{category}', [CategoryController::class, 'show'])->name('forum.category.show');
    Route::delete('/forum/posts/{post}', [PostController::class, 'destroy'])->name('forum.posts.destroy');
    Route::get('/forum/my-posts', [PostController::class, 'myPosts'])->name('forum.myposts');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Pengguna
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

        // Manajemen Forum
        Route::get('/forum/posts', [AdminForumController::class, 'posts'])->name('forum.posts');
        Route::delete('/forum/posts/{post}', [AdminForumController::class, 'destroyPost'])->name('forum.posts.destroy');
    });

require __DIR__.'/auth.php'; // Rute autentikasi dari Breeze
