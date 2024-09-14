<?php

namespace App\Providers;

use App\Models\Workspace;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('partials.sidebar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $workspaces = $user->getWorkspace();  // Lấy danh sách workspaces của người dùng

                // Chia sẻ workspaces với view sidebar
                $view->with('workspaces', $workspaces);
            }
        });



    }

}
