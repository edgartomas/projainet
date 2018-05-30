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

        //

        Gate::define('do-operation', function($auth, $user_id){
            return $auth->id != $user_id;
        });

        Gate::define('view-account', function($auth, $user_id){
            return $auth->id == $user_id || $auth->isAssociate($user_id);
        });

        Gate::define('add-account', function($auth, $owner_id){
            return $auth->id == $owner_id;
        });

        Gate::define('edit-account', function($auth, $user_id){
            return $auth->id == $user_id;
        });

        Gate::define('remove-account', function($auth, $account){
            return $auth->id == $account->owner_id;
        });

        Gate::define('view-movement', function($auth, $user_id){
            return $auth->id == $user_id || $auth->isAssociate($user_id);
        });

        Gate::define('add-movement', function($auth, $owner_id){
            return $auth->id == $owner_id;
        });

        Gate::define('edit-movement', function($auth, $owner_id){
            return $auth->id == $owner_id;
        });

        Gate::define('remove-movement', function($auth, $movement){
            return $auth->id == $movement->account->owner_id;
        });

        Gate::define('view-dashboard', function($auth, $user){
            return $auth->id == $user->id || $auth->isAssociate($user->id);
        });
        
        Gate::define('add-document', function($auth, $movement){
            return $auth->id == $movement->account->owner_id;
        });
    }
}
