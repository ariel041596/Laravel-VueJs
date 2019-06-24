<?php

namespace App\Providers;
// Import Laravel passport
use Laravel\Passport\Passport; 
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
    public function boot(){
        $this->registerPolicies();
        Gate::define('isAdmin', function($user){
            return $user->type ==='admin';
        });

        $this->registerPolicies();
        Gate::define('isAuthor', function($user){
            return $user->type ==='author';
        });

        $this->registerPolicies();
        Gate::define('isUser', function($user){
            return $user->type ==='user';
        });
        $this->registerPolicies();
        Gate::define('isAdminOrAuthor', function($user){
            return $user->type ==='admin' || $user->type ==='author';
        });

        Passport::routes();
    }

    // public function boot(GateContract $gate)
    // {
    //     // Register the gate for authenticated user role type
    //     $this->registerPolicies($gate);

    //     $gate->define('isAdmin', function($user){
    //         return $user->type == 'admin';
    //     });

    //     $gate->define('isUser', function($user){
    //         return $user->type == 'user';
    //     });

    //     $gate->define('isOrganization', function($user){
    //         return $user->type == 'organization';
    //     });

    //     $gate->define('isMyAccount', function($user, $profileUser){
    //         return $user->id === $profileUser->id;
    //     });

    //     // use the function for laravel passport
    //     Passport::routes();

    //     //
    // }
}
