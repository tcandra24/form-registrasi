<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('sections.pagination');

        if (app()->environment('production')){
            $this->app->bind('path.public', function() {
                return base_path().'/../public_html/event.fuboru.co.id';
            });
        }
    }
}
