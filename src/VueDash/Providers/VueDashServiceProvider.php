<?php

namespace Palamike\VueDash\Providers;

use Illuminate\Support\ServiceProvider;

class VueDashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
	    $this->loadViewsFrom(__DIR__.'/../../resources/views', 'vueDash');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
