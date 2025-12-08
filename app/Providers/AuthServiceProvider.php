<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Gates selon rôle
         * Tu as déjà :
         * - isAdmin()
         * - isManager()
         * - isAdminOrManager()
         */

        // Accès autorisé aux admins et managers
        $accessGates = [
            'access-users',
            'access-type-media',
            'access-type-contenu',
            'access-medias',
            'access-contenu',
            'access-langues',
            'access-regions',
            'access-commentaires',
            'access-roles',
        ];

        foreach ($accessGates as $gate) {
            Gate::define($gate, fn($user) => $user->isAdminOrManager());
        }

        // Suppression réservée uniquement aux admins
        $deleteGates = [
            'delete-users',
            'delete-type-media',
            'delete-type-contenu',
            'delete-medias',
            'delete-contenus',
            'delete-langues',
            'delete-regions',
            'delete-commentaires',
            'delete-roles',
        ];

        foreach ($deleteGates as $gate) {
            Gate::define($gate, fn($user) => $user->isAdmin());
        }
    }

}
