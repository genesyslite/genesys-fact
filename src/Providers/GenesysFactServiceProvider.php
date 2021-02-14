<?php

namespace GenesysLite\GenesysFact\Providers;

use GenesysLite\GenesysFact\InputRequest;
use GenesysLite\GenesysFact\Models\Document;
use GenesysLite\GenesysFact\Observers\DocumentObserver;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class GenesysFactServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/genesysFact.php',
            'genesysFact'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
            $this->publishes([
                __DIR__.'/../../config/genesysFact.php' => config_path('genesysFact.php'),
            ], 'config');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/routes.php');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('input.request', InputRequest::class);
        Document::observe(DocumentObserver::class);
    }
}
