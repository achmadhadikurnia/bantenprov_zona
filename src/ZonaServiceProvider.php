<?php

namespace Bantenprov\Zona;

use Illuminate\Support\ServiceProvider;
use Bantenprov\Zona\Console\Commands\ZonaCommand;

/**
 * The ZonaServiceProvider class
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ZonaServiceProvider extends ServiceProvider
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
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
        $this->publishHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('zona', function ($app) {
            return new Zona;
        });

        $this->app->singleton('command.zona', function ($app) {
            return new ZonaCommand;
        });

        $this->commands('command.zona');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'zona',
            'command.zona',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle($publish = '')
    {
        $packageConfigPath = __DIR__.'/config';
        $appConfigPath     = config_path('bantenprov/zona');

        $this->mergeConfigFrom($packageConfigPath.'/zona.php', 'zona');
        $this->mergeConfigFrom($packageConfigPath.'/master-zona.php', 'master-zona');

        $this->publishes([
            $packageConfigPath.'/zona.php' => $appConfigPath.'/zona.php',
            $packageConfigPath.'/master-zona.php' => $appConfigPath.'/master-zona.php',
        ], $publish ? $publish : 'zona-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle($publish = '')
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'zona');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/zona'),
        ], $publish ? $publish : 'zona-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle($publish = '')
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'zona');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/zona'),
        ], $publish ? $publish : 'zona-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle($publish = '')
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], $publish ? $publish : 'zona-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle($publish = '')
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], $publish ? $publish : 'zona-migrations');
    }

    /**
     * Publishing package's publics (JavaScript, CSS, images...)
     *
     * @return void
     */
    public function publicHandle($publish = '')
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], $publish ? $publish : 'zona-public');
    }

    /**
     * Publishing package's seeds
     *
     * @return void
     */
    public function seedHandle($publish = '')
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], $publish ? $publish : 'zona-seeds');
    }

    /**
     * Publishing package's all files
     *
     * @return void
     */
    public function publishHandle()
    {
        $publish = 'zona-publish';

        $this->routeHandle($publish);
        $this->configHandle($publish);
        $this->langHandle($publish);
        $this->viewHandle($publish);
        $this->assetHandle($publish);
        // $this->migrationHandle($publish);
        $this->publicHandle($publish);
        $this->seedHandle($publish);
    }
}
