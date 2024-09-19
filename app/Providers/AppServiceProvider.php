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
//        dd(request()->getP());
//        View::share('boardGlobal', \App\Models\Board::query()->findOrFail(request()->input('id')));

    }

}
