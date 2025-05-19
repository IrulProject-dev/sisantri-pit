<?php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Gate::define('admin', function ($user) {
            return $user->role === 'admin' || $user->role === 'superadmin'; // Or use a permission check if using Spatie
        });

        Gate::define('mentor', function ($user) {
            return $user->role === 'mentor'; // Or use a permission check if using Spatie
        });

        Gate::define('santri', function ($user) {
            return $user->role === 'santri'; // Or use a permission check if using Spatie
        });
    }
}
