<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // System Admin
        Gate::define('isAdmin', function($user) {
            return $user->role == '23001';
        });

        // ผู้บริหาร กคพ.
        Gate::define('isManagement', function($user) {
            return $user->role == '23002';
        });

        // พนักงาน กคพ.
        Gate::define('isNesdc', function($user) {
            return $user->role == '23003';
        });

        // หน่วยงานอื่นๆ
        Gate::define('isNesdc', function($user) {
            return $user->role == '23003';
        });
    }
}
