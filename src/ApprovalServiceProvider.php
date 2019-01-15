<?php

namespace Httpfactory\Approvals;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApprovalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //load up the migrations...
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        //load up the views...
        $this->loadViewsFrom(__DIR__.'/views', 'approvals');

        //publish our views...
        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/approvals'),
        ]);

        //load up the routes...
        $this->defineRoutes();
    }

    /**
     * Define the Spark routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        // If the routes have not been cached, we will include them in a route group
        // so that all of the routes will be conveniently registered to the given
        // controller namespace.
        if (! $this->app->routesAreCached()) {
            Route::group([
                'namespace' => 'Httpfactory\Approvals\Http\Controllers'],
                function ($router) {
                    require __DIR__.'/Http/Routes.php';
                }
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->approvals();
    }

    /**
     * Handles Approval Bindings
     */
    protected function approvals()
    {

        $this->app->bind(
            'Httpfactory\Approvals\Contracts\ApprovalElementRepository',
            'Httpfactory\Approvals\Repositories\ApprovalElementRepository'
        );

        $this->app->bind(
            'Httpfactory\Approvals\Contracts\ApprovalLevelRepository',
            'Httpfactory\Approvals\Repositories\ApprovalLevelRepository'
        );

        $this->app->bind(
            'Httpfactory\Approvals\Contracts\ApprovalProcessRepository',
            'Httpfactory\Approvals\Repositories\ApprovalProcessRepository'
        );

        $this->app->bind(
            'Httpfactory\Approvals\Contracts\ApprovalRequestRepository',
            'Httpfactory\Approvals\Repositories\ApprovalRequestRepository'
        );

    }
}
