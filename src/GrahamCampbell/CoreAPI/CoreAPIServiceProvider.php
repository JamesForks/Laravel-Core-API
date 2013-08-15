<?php namespace GrahamCampbell\CoreAPI;

use Illuminate\Support\ServiceProvider;

class CoreAPIServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('graham-campbell/core-api');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['coreapi'] = $this->app->share(function($app) {
            return new Classes\CoreAPI;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }
}
