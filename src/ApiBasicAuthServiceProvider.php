<?php

namespace Consilience\ApiBasicAuth;

use Illuminate\Support\ServiceProvider;

class ApiBasicAuthServiceProvider extends ServiceProvider
{

    /**
     * Path to config-file
     * @var string
     */
    protected $config;

    /**
     * Constructor
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app) {
        $this->config = __DIR__ . '/../config/api_basic_auth.php';

        parent::__construct($app);
    }

    /**
     * Perform post-registration booting of services.
     * @return void
     */
    public function boot(/*\Illuminate\Routing\Router*/ $router = null)
    {
        // Publishing of configuration
        $this->publishes([
            $this->config => config_path('api_basic_auth.php'),
        ]);

        // Register middleware
        $router->aliasMiddleware(
            'auth.api_basic',
            \Consilience\ApiBasicAuth\Http\Middleware\ApiBasicAuth::class
        );
    }

    /**
     * Register any package services.
     * @return void
     */
    public function register()
    {
        // If the user doesn't set their own config, load default
        $this->mergeConfigFrom(
            $this->config, 'api_basic_auth'
        );
    }
}
