<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as Authenticatable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\Responses\FilamentLogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
            Post::class => PostPolicy::class, // <-- TAMBAHKAN BARIS INI
        ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->bind(LogoutResponseContract::class, FilamentLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data notifikasi ke view 'layouts.navigation' setiap kali view itu di-render.
        View::composer('layouts.navigation', function ($view) {
            // Cek dulu apakah ada pengguna yang sedang login
            if (Auth::check()) {
                $user = Auth::user();
                $unreadNotifications = $user->unreadNotifications()->take(5)->get();
                $view->with('unreadNotifications', $unreadNotifications);
            } else {
                // Jika tidak ada yang login, kirim collection kosong agar tidak error di view
                $view->with('unreadNotifications', collect());
            }
        });
    }
}
