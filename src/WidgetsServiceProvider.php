<?php

namespace Displore\Widgets;

use Illuminate\Support\ServiceProvider;

class WidgetsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/widgets.php' => config_path('displore/widgets.php'),
        ], 'displore.widgets.config');

        $this->mergeConfigFrom(__DIR__.'/../config/widgets.php', 'displore.widgets');
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        if (config('displore.widgets.dynamic')) {
            $this->registerDynamicProvider();
        } else {
            $this->registerProvider();
        }
    }

    /**
     * Register default service.
     */
    public function registerProvider()
    {
        $this->app->singleton('widget', function () {
            return new WidgetsProvider(config('displore.widgets.providers'));
        });
    }

    /**
     * Register dynamic resolving service.
     */
    public function registerDynamicProvider()
    {
        $this->app->singleton('widget', function () {
            return (new DynamicWidgetsProvider())
                ->withPath(config('displore.widgets.path'))
                ->withNamespace(config('displore.widgets.namespace'))
                ->scanForProviders();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['widget'];
    }
}
