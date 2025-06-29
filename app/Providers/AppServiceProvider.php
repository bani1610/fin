<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\PostPolicy; // <-- Impor PostPolicy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as Authenticatable;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
