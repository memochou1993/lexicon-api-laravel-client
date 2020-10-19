<?php

namespace MemoChou1993\Lexicon\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MemoChou1993\Lexicon\Client;
use MemoChou1993\Lexicon\Console\ClearCommand;
use MemoChou1993\Lexicon\Console\SyncCommand;
use MemoChou1993\Lexicon\Lexicon;

class LexiconServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/lexicon.php',
            'lexicon'
        );

        $this->app->singleton(Client::class, function() {
            return new Client([
                'host' => config('lexicon.host'),
                'api_key' => config('lexicon.api_key'),
            ]);
        });

        $this->app->singleton('lexicon', function() {
            return new Lexicon(app(Client::class));
        });

        $this->app->register(EventServiceProvider::class);
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
            __DIR__.'/../../config/lexicon.php' => config_path('lexicon.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncCommand::class,
                ClearCommand::class,
            ]);
        }

        Route::group([
            'prefix' => '/api/'.config('lexicon.path'),
            'middleware' => config('lexicon.middleware', []),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        });
    }
}
