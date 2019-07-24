<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Gate::define('isSuperAdmin', function ($user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isAdmin', function ($user) {
            if ($user->hasRole('admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isFinanceAdmin', function ($user) {
            if ($user->hasRole('finance-admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isSupportAdmin', function ($user) {
            if ($user->hasRole('support-admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isSAF', function ($user) {
            if ($user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('finance-admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isSA', function ($user) {
            if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
                return true;
            }
            return false;
        });

        Gate::define('isSAS', function ($user) {
            if ($user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('support-admin')) {
                return true;
            }
            return false;
        });
    }
}
