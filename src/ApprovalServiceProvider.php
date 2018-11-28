<?php

namespace Httpfactory\Approvals;

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
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes.php');
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
            'Httpfactory\Approvals\Contracts\ApprovableConfig',
            'Httpfactory\Approvals\Repositories\ApprovalConfiguration'
        );

    }
}
