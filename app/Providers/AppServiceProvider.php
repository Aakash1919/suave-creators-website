<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Services\SeoGenerateService;
use App\Support\Frontend\ContactSupport;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(SeoGenerateService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        View::composer(['frontend.*', 'components.frontend.*'], function ($view): void {
            $view->with('demoHref', ContactSupport::demoHref());
        });

        Paginator::useTailwind();
    }
}
