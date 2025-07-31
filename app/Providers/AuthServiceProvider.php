<?php

namespace App\Providers;

// use App\Models\Business;
// use App\Models\BusinessRole;
// use App\Policies\BusinessRolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\TableBuilder' => 'App\Policies\TableBuilderPolicy',
        // BusinessRole::class => BusinessRolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define business role management gate
        // Gate::define('manage-business-roles', function ($user, Business $business) {
        //     return $user->businesses->contains($business) && 
        //           $user->hasBusinessPermission($business, 'manage_roles');
        // });
    }
} 