<?php

namespace Palamike\VueDash\Providers;

use Illuminate\Support\ServiceProvider;
use Palamike\VueDash\Console\Commands\MakeModule;

class VueDashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

	    if ($this->app->runningInConsole()) {
		    $this->commands([
			    MakeModule::class
		    ]);
	    }

    	$viewPath = __DIR__.'/../../resources/views';

	    /**
	     *  Load resource from package
	     */
	    $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
	    $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
	    $this->loadViewsFrom($viewPath, 'vueDash');
	    $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'vueDash');

	    //publish views
	    $this->publishes([
		    $viewPath => resource_path('views/vendor/vueDash'),
	    ],'view');

	    //publish sass elements
	    $sassElementsPackagePath = __DIR__.'/../../resources/assets/sass/elements';
	    $sassElementsAppPath = resource_path('assets/sass/elements');
	    $this->publishes([
		    $sassElementsPackagePath => $sassElementsAppPath,
	    ],'sass-elements');

	    //publish sass app
	    $sassAppPackagePath = __DIR__.'/../../resources/assets/sass/vue_dash.scss';
	    $sassAppAppPath = resource_path('assets/sass/vue_dash.scss');
	    $this->publishes([
		    $sassAppPackagePath => $sassAppAppPath,
	    ],'sass-app');

	    //publish sass variable
	    $sassVarPackagePath = __DIR__.'/../../resources/assets/sass/vue_dash_variables.scss';
	    $sassVarAppPath = resource_path('assets/sass/vue_dash_variables.scss');
	    $this->publishes([
		    $sassVarPackagePath => $sassVarAppPath,
	    ],'sass-app');

	    //all sass
	    $this->publishes([
		    $sassElementsPackagePath => $sassElementsAppPath,
		    $sassAppPackagePath => $sassAppAppPath,
		    $sassVarPackagePath => $sassVarAppPath,
	    ],'sass-all');

	    //publish js
	    $jsPackagePaths = [
	    	'classes' => __DIR__.'/../../resources/assets/js/classes',
		    'components' => __DIR__.'/../../resources/assets/js/components',
		    'data' => __DIR__.'/../../resources/assets/js/data',
		    'entries' => __DIR__.'/../../resources/assets/js/entries',
		    'functions' => __DIR__.'/../../resources/assets/js/functions',
		    'lang' => __DIR__.'/../../resources/assets/js/lang',
		    'mixins' => __DIR__.'/../../resources/assets/js/mixins',
		    'boot' => __DIR__.'/../../resources/assets/js/boot.js',
		    'vueDash' => __DIR__.'/../../resources/assets/js/vue-dash.js',
	    ];

	    $jsAppPaths = [
		    'classes' => resource_path('assets/js/classes'),
		    'components' => resource_path('assets/js/components'),
		    'data' => resource_path('assets/js/data'),
		    'entries' => resource_path('assets/js/entries'),
		    'functions' => resource_path('assets/js/functions'),
		    'lang' => resource_path('assets/js/lang'),
		    'mixins' => resource_path('assets/js/mixins'),
		    'boot' => resource_path('assets/js/boot.js'),
		    'vueDash' => resource_path('assets/js/vue-dash.js'),
	    ];

	    $this->publishes([
		    $jsPackagePaths['classes'] => $jsAppPaths['classes'],
		    $jsPackagePaths['components'] => $jsAppPaths['components'],
		    $jsPackagePaths['entries'] => $jsAppPaths['entries'],
		    $jsPackagePaths['functions'] => $jsAppPaths['functions'],
		    $jsPackagePaths['mixins'] => $jsAppPaths['mixins'],
		    $jsPackagePaths['boot'] => $jsAppPaths['boot'],
		    $jsPackagePaths['vueDash'] => $jsAppPaths['vueDash'],
	    ],'js-elements');

	    //publish js data
	    $this->publishes([
		    $jsPackagePaths['data'] => $jsAppPaths['data'],
	    ],'js-data');

	    //publish lang js
	    $this->publishes([
		    $jsPackagePaths['lang'] => $jsAppPaths['lang'],
	    ],'js-lang');

	    //all js
	    $this->publishes([
		    $jsPackagePaths['classes'] => $jsAppPaths['classes'],
		    $jsPackagePaths['components'] => $jsAppPaths['components'],
		    $jsPackagePaths['entries'] => $jsAppPaths['entries'],
		    $jsPackagePaths['functions'] => $jsAppPaths['functions'],
		    $jsPackagePaths['mixins'] => $jsAppPaths['mixins'],
		    $jsPackagePaths['boot'] => $jsAppPaths['boot'],
		    $jsPackagePaths['data'] => $jsAppPaths['data'],
		    $jsPackagePaths['lang'] => $jsAppPaths['lang'],
	    ],'js-all');

	    //publish lang php
	    $phpPackagePath = __DIR__.'/../../resources/lang';
	    $phpAppPath = resource_path('lang/vendor/vueDash');
	    $this->publishes([
		    $phpPackagePath => $phpAppPath
	    ],'php-lang');

	    //fonts
	    $fontPackagePath = __DIR__.'/../../resources/assets/fonts';
	    $fontAppPath = resource_path('assets/fonts');
	    $this->publishes([
		    $fontPackagePath => $fontAppPath
	    ],'fonts');

	    //mix template
	    $mixPackagePath = __DIR__.'/../../../webpack.mix.js';
	    $mixAppPath = base_path('webpack.mix.js');
	    $this->publishes([
		    $mixPackagePath => $mixAppPath
	    ],'mix');

	    //package json
	    $jsonPackagePath = __DIR__.'/../../../package.json';
	    $jsonAppPath = base_path('package.json');
	    $this->publishes([
		    $jsonPackagePath => $jsonAppPath
	    ],'package-json');

	    //seeder
	    $seederPackagePath = __DIR__.'/../../database/seeds';
	    $seederAppPath = database_path('seeds');
	    $this->publishes([
		    $seederPackagePath => $seederAppPath
	    ],'seeder');

	    //factory
	    $factoryPackagePath = __DIR__.'/../../database/factories';
	    $factoryAppPath = database_path('factories');
	    $this->publishes([
		    $factoryPackagePath => $factoryAppPath
	    ],'factory');
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
