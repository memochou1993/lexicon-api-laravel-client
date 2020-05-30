<?php

namespace Memochou1993\Localize;

use Illuminate\Support\ServiceProvider;

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
            __DIR__ . '/../config/localize.php', 'localize'
        );

        $this->app->singleton('localize', function() {
            return new Localize();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/localize.php' => config_path('localize.php'),
        ]);
    }
}
