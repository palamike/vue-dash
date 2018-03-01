<?php

namespace Palamike\VueDash\Providers;

use Palamike\VueDash\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    if(Schema::hasTable('settings')) {
	    	    $settings = Setting::pluck('value', 'key');
	    	    config()->set('setting', $settings);
	    }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
