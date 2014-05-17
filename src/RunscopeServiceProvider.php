<?php

namespace Runscope;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class RunscopeServiceProvider extends ServiceProvider
{

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
    public function boot()
    {
        $this->package('peterfox/runscope', 'runscope', __DIR__);

        AliasLoader::getInstance()->alias('Runscope', 'Runscope\RunscopeFacade');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Runscope\Runscope', function ($app, $parameters) {
            $config = $app->config->get('runscope::config', false) ? : $app->config->get('runscope');

            return new \Runscope\Runscope(
                $config['bucket'],
                $config['auth_token'],
                $config['gateway_host']
            );
        });

        $this->app->bind('Runscope\Plugin\Guzzle\RunscopePlugin', function ($app, $parameters) {
            return new \Runscope\Plugin\Guzzle\RunscopePlugin($app->make('Runscope\Runscope'));
        });

        $this->app->bind('Runscope\Plugin\GuzzleHttp\RunscopePlugin', function ($app, $parameters) {
            return new \Runscope\Plugin\GuzzleHttp\RunscopePlugin($app->make('Runscope\Runscope'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Runscope\Runscope', 'Runscope\Plugin\Guzzle\RunscopePlugin', 'Runscope\Plugin\GuzzleHttp\RunscopePlugin');
    }

}
