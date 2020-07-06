<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        Gate::define('can_super_admin', function ($user) {
            return in_array($user->role, [0]);
        });

        Gate::define('can_admin', function ($user) {
            return in_array($user->role, [1]);
        });

        Gate::define('can_petugas', function ($user) {
            return in_array($user->role, [2]);
        });

        Gate::define('can_pasien', function ($user) {
            return in_array($user->role, [4]);
        });
        
        Gate::define('can_posko', function ($user) {
            return in_array($user->role, [3]);
        });

    }
}
