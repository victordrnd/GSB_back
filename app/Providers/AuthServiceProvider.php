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
        $this->loadGates();
        //
    }

    public function loadGates(){
        Gate::define('frais.view', function($user){
            return $user->hasPermission('frais.view');
        });

        Gate::define('frais.edit-status', function($user){
            return $user->hasPermission('frais.edit-status');
        });

        Gate::define('users.view', function($user){
            return $user->hasPermission('users.view');
        });

        Gate::define('users.edit', function($user){
            return $user->hasPermission('users.edit');
        });

        Gate::define('users.delete', function($user){
            return $user->hasPermission('users.delete');
        });

        Gate::define('users.edit-role', function($user){
            return $user->hasPermission('users.edit-role');
        });

        Gate::define('my.frais.view', function($user){
            return $user->hasPermission('my.frais.view');
        });

        Gate::define('my.frais.edit', function($user){
            return $user->hasPermission('my.frais.edit');
        });

        Gate::define('my.frais.delete', function($user){
            return $user->hasPermission('my.frais.delete');
        });
        Gate::define('my.frais.create', function($user){
            return $user->hasPermission('my.frais.create');
        });

        Gate::define('permissions.edit', function($user){
            return $user->hasPermission('permissions.edit');
        });
    }
}
