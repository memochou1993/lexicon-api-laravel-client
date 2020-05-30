<?php

namespace MemoChou\Localize\Tests;

use Illuminate\Foundation\Application;
use MemoChou\Localize\Facades\Localize;
use MemoChou\Localize\LocalizeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LocalizeServiceProvider::class,
        ];
    }

    /**
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'localize' => Localize::class,
        ];
    }
}
