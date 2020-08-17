<?php

namespace App\Providers;



use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('edit_attr_admin',function ($user){

            return $user->canDo('edit_attr_admin',false);
        });

        $gate->define('edit_attr_manager',function ($user){

            return $user->canDo('edit_attr_manager',false);
        });

        $gate->define('edit_attr_leader',function ($user){

            return $user->canDo('edit_attr_leader',false);
        });
        //
    }
}
