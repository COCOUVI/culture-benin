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
        // Liste des modules pour lesquels on veut définir des Gates
        $modules = [
            'users',
            'type-media',
            'type-contenu',
            'medias',
            'contenu',
            'langues',
            'regions',
            'commentaires',
            'roles',
        ];

        // Définir les Gates "access" et "delete" pour chaque module
        foreach ($modules as $module) {
            Gate::define("access-$module", fn($user) => $user->isAdmin());
            Gate::define("delete-$module", fn($user) => $user->isAdmin());
        }
    }
}
