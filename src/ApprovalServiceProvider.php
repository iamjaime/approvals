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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
