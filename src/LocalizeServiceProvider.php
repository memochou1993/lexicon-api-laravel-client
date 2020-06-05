<?php

namespace MemoChou1993\Localize;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MemoChou1993\Localize\Console\ClearCommand;
use MemoChou1993\Localize\Console\SyncCommand;

class LocalizeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/localize.php', 'localize'
        );

        $this->app->singleton(Client::class, function() {
            return new Client([
                'api_url' => config('localize.api_url'),
                'api_key' => config('localize.api_key'),
            ]);
        });

        $this->app->singleton('localize', function() {
            return new Localize(app(Client::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! defined('CONFIG_SEPARATOR')) {
            define('CONFIG_SEPARATOR', '.');
        }

        $this->publishes([
            __DIR__.'/../config/localize.php' => config_path('localize.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncCommand::class,
                ClearCommand::class,
            ]);
        }

        Route::group([
            'namespace' => 'MemoChou1993\Localize\Http\Controllers',
            'prefix' => config('localize.path'),
            'middleware' => config('localize.middleware', []),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }
}
