<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class UserComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\UserRepositoryInterface', 'App\Repositories\UserRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {
            $id = Auth::id();
            if (isset($id)) {
                $userRepository = $this->app->make(UserRepository::class);

                $userLogin = $userRepository->findById($id);
                $view->with('userLogin', $userLogin);
            }

        });
    }
}
